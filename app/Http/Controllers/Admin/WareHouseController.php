<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WareHouseController extends Controller
{
    const PATH_VIEW = 'admin.warehouses.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = WareHouse::query()->latest('id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        WareHouse::query()->create($request->all());
        return redirect()->route('admin.warehouses.index')->with('success', 'Thêm thuộc tính thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(WareHouse $warehouse)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WareHouse $warehouse)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WareHouse $warehouse)
    {
        $warehouse->update($request->all());
        return back()->with('success', 'Cập nhật thuộc tính thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WareHouse $warehouse)
    {
        $warehouse->delete();
        return back()->with('success', 'Xóa thuộc tính thành công');
    }

    public function getRestore()
    {
        $data = WareHouse::onlyTrashed()->get();
        return view('admin.warehouses.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $warehouseIds = $request->input('ids');
            if ($warehouseIds) {
                WareHouse::onlyTrashed()->whereIn('id', $warehouseIds)->restore();
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
