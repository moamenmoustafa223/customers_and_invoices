<?php

namespace App\Http\Controllers;

use App\Models\Payment_method;
use App\Models\PaymentMethodBalance;
use App\Models\PaymentMethodTransaction;
use App\Models\PaymentMethodTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PaymentMethodController extends Controller
{


    public function index()
    {
        $paymentMethods = Payment_method::orderBy('id', 'desc')->paginate(10);
        $paymentMethodTransfers = \App\Models\PaymentMethodTransfer::with('fromPaymentMethod', 'toPaymentMethod')->paginate(10);

        return view('backend.pages.paymentMethods.index', compact('paymentMethods', 'paymentMethodTransfers'));
    }


    public function transfers(Request $request)
    {
        $query = PaymentMethodTransfer::with(['fromPaymentMethod', 'toPaymentMethod'])
            ->orderBy('transfer_date', 'desc');

        // Apply date filters if present
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from = Carbon::parse($request->from_date)->startOfDay();
            $to = Carbon::parse($request->to_date)->endOfDay();
            $query->whereBetween('transfer_date', [$from, $to]);
        }

        $paymentMethodTransfers = $query->paginate(10);

        return view('backend.pages.paymentMethods.transfers', compact('paymentMethodTransfers'));
    }

    public function exportTransferHistory(Request $request)
    {
        $startDate = \Carbon\Carbon::parse($request->from_date)->format('Y-m-d');
        $endDate = \Carbon\Carbon::parse($request->to_date)->format('Y-m-d');

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PaymentTransferExport($startDate, $endDate),
            'transfer_history_' . now()->format('Ymd_His') . '.xlsx'
        );
    }




    public function transfer(Request $request)
    {
        $request->validate([
            'from_payment_method_id' => 'required|different:to_payment_method_id|exists:payment_methods,id',
            'to_payment_method_id'   => 'required|exists:payment_methods,id',
            'amount'                 => 'required|numeric|min:0.001',
            'transfer_date'          => 'required|date',
            'notes'                  => 'nullable|string',
            'attachment'             => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        DB::beginTransaction();

        try {
            // Get balances
            $fromBalance = PaymentMethodBalance::firstOrCreate(
                ['payment_method_id' => $request->from_payment_method_id],
                ['initial_amount' => 0, 'current_balance' => 0]
            );

            $toBalance = PaymentMethodBalance::firstOrCreate(
                ['payment_method_id' => $request->to_payment_method_id],
                ['initial_amount' => 0, 'current_balance' => 0]
            );

            // ✅ Check if from account has enough funds
            if ($fromBalance->current_balance < $request->amount) {
                DB::rollBack();
                return redirect()->back()->with('error', 'الرصيد غير كافٍ لإتمام عملية التحويل.');
            }

            // Handle file upload to S3
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $attachmentPath = $file->storeAs('payment_transfers', $fileName, 's3');
            }

            // Save transfer record
            $transfer = PaymentMethodTransfer::create([
                'from_payment_method_id' => $request->from_payment_method_id,
                'to_payment_method_id'   => $request->to_payment_method_id,
                'amount'                 => $request->amount,
                'transfer_date'          => $request->transfer_date,
                'notes'                  => $request->notes,
                'attachment'             => $attachmentPath,
            ]);

            // Update balances
            $fromBalance->decrement('current_balance', $request->amount);
            $toBalance->increment('current_balance', $request->amount);

            // Log transactions
            // PaymentMethodTransaction::create([
            //     'payment_method_id' => $request->from_payment_method_id,
            //     'transaction_date'  => $request->transfer_date,
            //     'amount'            => $request->amount,
            //     'type'              => 'debit',
            //     'source_type'       => 'تحويل',
            //     'source_id'         => $transfer->id,
            //     'description'       => 'تحويل إلى: ' . $transfer->toPaymentMethod->name_ar,
            // ]);

            // PaymentMethodTransaction::create([
            //     'payment_method_id' => $request->to_payment_method_id,
            //     'transaction_date'  => $request->transfer_date,
            //     'amount'            => $request->amount,
            //     'type'              => 'credit',
            //     'source_type'       => 'transfer',
            //     'source_id'         => $transfer->id,
            //     'description'       => 'تحويل من: ' . $transfer->fromPaymentMethod->name_ar,
            // ]);

            DB::commit();
            toast('تم التحويل بنجاح', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            toast('حدث خطأ أثناء التحويل: ' . $e->getMessage(), 'error');
        }

        return redirect()->back();
    }




    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        $paymentMethod = Payment_method::create([
            'user_id' => Auth::id(),
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
        ]);

        PaymentMethodBalance::create([
            'payment_method_id' => $paymentMethod->id,
            'initial_amount' => 0,          // force zero
            'current_balance' => 0,         // force zero
        ]);

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->back();
    }





    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
        ]);

        $paymentMethod = Payment_method::findOrFail($id);

        $paymentMethod->update([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
        ]);

        // Always force initial amount to 0
        $balance = $paymentMethod->balance;

        if ($balance) {
            $balance->update([
                'initial_amount' => 0, // lock it at 0
                // current_balance remains unchanged
            ]);
        }

        toast('تم التعديل بنجاح', 'success');
        return redirect()->back();
    }




    public function destroy($id)
    {
        $paymentMethod = Payment_method::findOrFail($id);

        $hasTransactions = PaymentMethodTransaction::where('payment_method_id', $id)->exists();

        if (!$hasTransactions) {
            // Also delete balance record if it exists
            $paymentMethod->balance()->delete();
            $paymentMethod->delete();

            toast('تم الحذف بنجاح', 'success');
            return redirect()->back();
        }

        toast('لا يمكن الحذف .. يوجد عمليات دفع مرتبطة بطرق الدفع', 'error');
        return redirect()->back();
    }
}
