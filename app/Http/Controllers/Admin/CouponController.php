<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
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
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['is_active'] ??= 0;
            Coupon::query()->create($data);
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
        return view(self::PATH_VIEW . __FUNCTION__, compact('coupon'));
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
        $coupon->delete();
        return back()->with('success', 'Xóa thành công');
    }
}
