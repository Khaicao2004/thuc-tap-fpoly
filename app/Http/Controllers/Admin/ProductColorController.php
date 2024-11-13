<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductColorRequest;
use App\Http\Requests\UpdateProductColorRequest;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductColorController extends Controller
{
    const PATH_VIEW = 'admin.productcolors.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductColor::query()->latest('id')->get();
        // dd($data);
        return view(self::PATH_VIEW . __FUNCTION__,compact('data'));
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
    public function store(StoreProductColorRequest $request)
    {
        try {
            $data = [
                'name' => $request->name 
              ];
            ProductColor::query()->create($data);
            return redirect()->route('admin.productcolors.index')->with('success', 'Thêm size thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi thêm size'. $exception->getMessage());
            return back()->with('error', 'Lỗi thêm size');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductColor $productcolor)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('productcolor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductColor $productcolor)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('productcolor'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductColorRequest $request, ProductColor $productcolor)
    {
       $data = $request->all();
       $productcolor->update($data);
       return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductColor $productcolor)
    {
        $productcolor->delete();
        return back();
    }

    public function getRestore()
    {
        $data = ProductColor::onlyTrashed()->get();
        return view('admin.productcolors.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $productColorIds = $request->input('ids');
            if ($productColorIds) {
                ProductColor::onlyTrashed()->whereIn('id', $productColorIds)->restore();
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