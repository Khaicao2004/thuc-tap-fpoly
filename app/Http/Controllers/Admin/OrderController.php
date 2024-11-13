<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    const PATH_VIEW = 'admin.orders.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $data = Order::query()->with('user')->latest('id')->get();
    //    dd($data);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $data = Order::query()->with(['orderItems', 'coupon'])->where('id', $order->id)->firstOrFail();
        $user = User::query()->findOrFail($data->user_id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $data = Order::query()->with(['orderItems', 'coupon'])->where('id', $order->id)->firstOrFail();
        $user = User::query()->findOrFail($data->user_id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        try {
            $order->update($request->all());
            return back()->with('success','Cập nhật thành công đơn hàng');
        } catch (\Exception $e) {
            return back()->with('error','Lỗi cập nhật đơn hàng');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function getRestore()
    {
        $data = Order::onlyTrashed()->get();
        return view('admin.Orders.restore', compact('data'));
    }
    public function restore(Request $request)
    { 
        // dd($request->all());
        try {
            $OrderIds = $request->input('ids');
            if ($OrderIds) {
                Order::onlyTrashed()->whereIn('id', $OrderIds)->restore();
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
