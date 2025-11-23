<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerCategory;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('query');

        $customers = Customer::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name_ar', 'like', "%{$search}%")
                            ->orWhere('name_en', 'like', "%{$search}%");
                    });
            })
            ->when($request->customer_category_id, fn($q) => $q->where('customer_category_id', $request->customer_category_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('id', 'desc')
            ->paginate(10);

        $categories = CustomerCategory::where('status', 'active')->get();

        return view('backend.pages.customers.index', compact('customers', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CustomerCategory::where('status', 'active')->get();
        return view('backend.pages.customers.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address_ar' => 'nullable|string',
            'address_en' => 'nullable|string',
            'customer_category_id' => 'required|exists:customer_categories,id',
            'notes_ar' => 'nullable|string',
            'notes_en' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Customer::create($validated);

        toast(__('back.added_successfully'), 'success');
        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load(['category', 'invoices.status', 'quotations']);
        return view('backend.pages.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $categories = CustomerCategory::where('status', 'active')->get();
        return view('backend.pages.customers.edit', compact('customer', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address_ar' => 'nullable|string',
            'address_en' => 'nullable|string',
            'customer_category_id' => 'required|exists:customer_categories,id',
            'notes_ar' => 'nullable|string',
            'notes_en' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $customer->update($validated);

        toast(__('back.updated_successfully'), 'success');
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        toast(__('back.deleted_successfully'), 'success');
        return redirect()->route('customers.index');
    }
}
