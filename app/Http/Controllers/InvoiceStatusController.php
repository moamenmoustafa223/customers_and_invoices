<?php

namespace App\Http\Controllers;

use App\Models\InvoiceStatus;
use Illuminate\Http\Request;

class InvoiceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('query');

        $invoiceStatuses = InvoiceStatus::withCount('invoices')
            ->when($search, function ($query) use ($search) {
                $query->where('name_ar', 'LIKE', "%{$search}%")
                    ->orWhere('name_en', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('backend.pages.invoice_statuses.index', compact('invoiceStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.invoice_statuses.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'color' => 'required|string|max:20',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        InvoiceStatus::create($validated);

        toast(__('back.added_successfully'), 'success');
        return redirect()->route('invoice_statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceStatus $invoiceStatus)
    {
        $invoiceStatus->load('invoices');
        return view('backend.pages.invoice_statuses.show', compact('invoiceStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceStatus $invoiceStatus)
    {
        return view('backend.pages.invoice_statuses.edit', compact('invoiceStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceStatus $invoiceStatus)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'color' => 'required|string|max:20',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $invoiceStatus->update($validated);

        toast(__('back.updated_successfully'), 'success');
        return redirect()->route('invoice_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceStatus $invoiceStatus)
    {
        $invoiceStatus->delete();

        toast(__('back.deleted_successfully'), 'success');
        return redirect()->route('invoice_statuses.index');
    }
}
