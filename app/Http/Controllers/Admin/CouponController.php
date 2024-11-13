<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    const PATH_VIEW = 'admin.coupons.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Coupon::query()->latest('id')->get();
        // dd($data);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $data = $request->all();
            $data['is_active'] ??= 0;
            $coupon = Coupon::query()->create($data);
        
            if ($request->products) {
                $coupon->products()->sync($request->products);
            }
            return redirect()->route('admin.coupons.index')->with('success', 'Thêm mã giảm giá thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi thêm mã giảm giá ' . $exception->getMessage());
            return back()->with('error', 'Lỗi thêm mã giảm giá');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        $products = Product::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('coupon','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        try {
            $data = $request->all();
            $data['is_active'] ??= 0;
            $coupon->update($data);

            if ($request->products) {
                $coupon->products()->sync($request->products);
            }else{
                $coupon->products()->sync([]);

            }
            
            return back()->with('success', 'Cập nhật giảm giá thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi Cập nhật mã giảm giá ' . $exception->getMessage());
            return back()->with('error', 'Lỗi cập nhật mã giảm giá');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->products()->sync([]);
        $coupon->delete();
        return back()->with('success', 'Xóa thành công');
    }


    public function getRestore()
    {
        $data = Coupon::onlyTrashed()->get();
        return view('admin.coupons.restore', compact('data'));
    }
    public function restore(Request $request)
    { 
        // dd($request->all());
        try {
            $couponIds = $request->input('ids');
            if ($couponIds) {
                Coupon::onlyTrashed()->whereIn('id', $couponIds)->restore();
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
