<?php

namespace App\Http\Controllers;

use App\Models\CustomerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('query');

        $customerCategories = CustomerCategory::withCount('customers')
            ->when($search, function ($query) use ($search) {
                $query->where('name_ar', 'LIKE', "%{$search}%")
                    ->orWhere('name_en', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('backend.pages.customer_categories.index', compact('customerCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.customer_categories.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        CustomerCategory::create($validated);

        toast(__('back.added_successfully'), 'success');
        return redirect()->route('customer_categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerCategory $customerCategory)
    {
        $customerCategory->load('customers');
        return view('backend.pages.customer_categories.show', compact('customerCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerCategory $customerCategory)
    {
        return view('backend.pages.customer_categories.edit', compact('customerCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerCategory $customerCategory)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $customerCategory->update($validated);

        toast(__('back.updated_successfully'), 'success');
        return redirect()->route('customer_categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerCategory $customerCategory)
    {
        $customerCategory->delete();

        toast(__('back.deleted_successfully'), 'success');
        return redirect()->route('customer_categories.index');
    }
}
