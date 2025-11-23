<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('query');

        $services = Service::when($search, function ($query) use ($search) {
                $query->where('name_ar', 'LIKE', "%{$search}%")
                    ->orWhere('name_en', 'LIKE', "%{$search}%");
            })
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('backend.pages.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.services.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Service::create($validated);

        toast(__('back.added_successfully'), 'success');
        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('backend.pages.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('backend.pages.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $service->update($validated);

        toast(__('back.updated_successfully'), 'success');
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        toast(__('back.deleted_successfully'), 'success');
        return redirect()->route('services.index');
    }
}
