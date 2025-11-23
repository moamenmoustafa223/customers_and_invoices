<?php

namespace App\Exports;

use App\Models\StoreInvoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StoreInvoicesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $student_id;
    protected $payment_method_id;

    public function __construct($student_id = null, $payment_method_id = null)
    {
        $this->student_id = $student_id;
        $this->payment_method_id = $payment_method_id;
    }

    public function collection()
    {
        $query = StoreInvoice::with(['student', 'paymentMethod'])->latest();

        if ($this->student_id) {
            $query->where('student_id', $this->student_id);
        }

        if ($this->payment_method_id) {
            $query->where('payment_method_id', $this->payment_method_id);
        }

        return $query->get();
    }

    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->student->first_name . ' ' . $invoice->student->father_name,
            app()->getLocale() == 'ar' ? $invoice->paymentMethod->name_ar : $invoice->paymentMethod->name_en,
            $invoice->total_amount,
            $invoice->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            __('back.student'),
            __('back.payment_method'),
            __('back.total_amount'),
            __('back.created_at'),
        ];
    }
}

