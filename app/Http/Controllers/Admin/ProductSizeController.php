<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductSizeController extends Controller
{
    const PATH_VIEW = 'admin.productsizes.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductSize::query()->latest('id')->get();
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
    public function store(StoreSizeRequest $request)
    {
        try {
            ProductSize::query()->create($request->all());
            return redirect()->route('admin.productsizes.index')->with('success', 'Thêm size thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi thêm size'. $exception->getMessage());
            return back()->with('error', 'Lỗi thêm size');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSize $productsize)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('productsize'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSize $productsize)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('productsize'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSizeRequest $request, ProductSize $productsize)
    {
        try {
            $productsize->update($request->all());
            return back()->with('success', 'Cập nhật thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi cập nhật size'. $exception->getMessage());
            return back()->with('error', 'Lỗi cập nhật size');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSize $productsize)
    {
        try {
            $productsize->delete();
            return back()->with('success', 'Xóa size thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi xóa size' . $exception->getMessage());
            return back()->with('error', 'Lỗi xóa size');
        }
    }

    public function getRestore()
    {
        $data = ProductSize::onlyTrashed()->get();
        return view('admin.productsizes.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $productsizeIds = $request->input('ids');
            if ($productsizeIds) {
                ProductSize::onlyTrashed()->whereIn('id', $productsizeIds)->restore();
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
