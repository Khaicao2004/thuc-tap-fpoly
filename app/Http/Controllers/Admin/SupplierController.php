<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Supplier::query()->get();
        return view('admin.suppliers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        try {
            Supplier::query()->create($request->all());
            return redirect()->route('admin.suppliers.index')->with('success', 'Thành công');
        } catch (\Exception $exception) {
            return back()->with('error' . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('admin.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        try {
            $supplier->update($request->all());
            return back()->with('success', 'Thành công');
        } catch (\Exception $exception) {
            return back()->with('error' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Thành công');
    }

    public function getRestore()
    {
        $data = Supplier::onlyTrashed()->get();
        return view('admin.Suppliers.restore', compact('data'));
        return view('admin.suppliers.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $SupplierIds = $request->input('ids');
            if ($SupplierIds) {
                Supplier::onlyTrashed()->whereIn('id', $SupplierIds)->restore();
            $supplierIds = $request->input('ids');
            if ($supplierIds) {
                Supplier::onlyTrashed()->whereIn('id', $supplierIds)->restore();
                return back()->with('success', 'Khôi phục bản ghi thành công.');
            } else {
                return back()->with('error', 'Không bản ghi nào cần khôi phục.');
            }
        } catch (\Exception $exception) {
            Log::error('Lỗi xảy ra: ' . $exception->getMessage());
            return back()->with('error', 'Khôi phục bản ghi thất bại.');
        }
    }
}
