<?php

namespace App\Http\Controllers;

use App\Models\Payment_method;
use App\Models\PaymentMethodTransaction;
use Illuminate\Http\Request;
use App\Exports\PaymentMethodTransactionExport;
use Maatwebsite\Excel\Facades\Excel;

class PaymentMethodTransactionController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $type = $request->input('type');
        $sourceType = $request->input('source_type');
        $paymentMethodId = $request->input('payment_method_id');
    
        $query = PaymentMethodTransaction::with('Payment_method');
    
        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }
    
        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }
    
        if ($type && in_array($type, ['credit', 'debit'])) {
            $query->where('type', $type);
        }
    
        if ($sourceType) {
            $query->where('source_type', $sourceType);
        }
    
        if ($paymentMethodId) {
            $query->where('payment_method_id', $paymentMethodId);
        }
    
        $transactions = $query->latest()->paginate(25);
    
        $totalCredit = $query->clone()->where('type', 'credit')->sum('amount');
        $totalDebit  = $query->clone()->where('type', 'debit')->sum('amount');
    
        $paymentMethods = Payment_method::all();
        $sourceTypes = PaymentMethodTransaction::select('source_type')->distinct()->pluck('source_type');
    
        return view('backend.pages.paymentMethods.transactions_report', compact(
            'transactions', 'paymentMethods', 'sourceTypes', 'totalCredit', 'totalDebit',
            'startDate', 'endDate', 'type', 'sourceType', 'paymentMethodId'
        ));
    }
    


public function exportExcel(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;
    $type = $request->type;
    $sourceType = $request->source_type;
    $paymentMethodId = $request->payment_method_id;

    return Excel::download(new PaymentMethodTransactionExport($startDate, $endDate, $type, $sourceType, $paymentMethodId), 'payment_transactions.xlsx');
}

}
