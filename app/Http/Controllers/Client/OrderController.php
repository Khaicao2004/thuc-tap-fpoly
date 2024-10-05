<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Inventory;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function applyCoupon(Request $request)
    {
        // dd($request->all());
        $cart = session('cart', []);
        $totalAmount = 0;
        foreach ($cart as  $item) {
            $totalAmount += $item['quantity'] * $item['price'];
        }
        if (session()->has('coupon')) {
            return back()->with([
                'alert-type' => 'error',
                'alert-message' => 'Bạn đã áp dụng một mã giảm giá cho đơn hàng này.'
            ]);
        }
        $coupon = Coupon::where('name', $request->name)
            ->where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();
        // dd($coupon);
        if (!$coupon) {
            return back()->with([
                'alert-type' => 'error',
                'alert-message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'
            ]);
        }
        if ($coupon->used >= $coupon->usage_limit) {
            return back()->with([
                'alert-type' => 'error',
                'alert-message' => 'Mã giảm giá đã được sử dụng hết.'
            ]);
        }
        $userCouponUsage = DB::table('coupon_user')
            ->where('coupon_id', $coupon->id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$userCouponUsage) {
            DB::table('coupon_user')->insert([
                'coupon_id' => $coupon->id,
                'user_id' => Auth::id(),
                'usage_count' => 0,
                'used_at' => null
            ]);
        }
        // dd($data);
        if ($userCouponUsage && $userCouponUsage->usage_count >= $coupon->max_usage_per_user) {
            return back()->with([
                'alert-type' => 'error',
                'alert-message' => 'Bạn đã sử dụng mã giảm giá này quá số lần cho phép.'
            ]);
        }

        if ($totalAmount < $coupon->min_order_value) {
            return redirect()->back()->with([
                'alert-type' => 'error',
                'alert-message' => 'Giá trị đơn hàng không đủ để áp dụng mã giảm giá này.'
            ]);
        }
        $discount = 0;
        if ($coupon->discount_type == 'percent_cart') {
            $discount = ($totalAmount * $coupon->discount_value) / 100;
        } elseif ($coupon->discount_type == 'fixed_cart') {
            $discount = $coupon->discount_value;
        } elseif (in_array($coupon->discount_type, ['percent_product', 'fixed_product'])) {
            $validProductIds = $coupon->products()->pluck('id')->toArray(); // Lấy danh sách sản phẩm hợp lệ
            $validProducts = []; // Danh sách sản phẩm hợp lệ

            foreach ($cart as $item) {
                if (in_array($item['product_id'], $validProductIds)) {
                    $validProducts[] = $item['name']; // Lưu tên sản phẩm hợp lệ
                    if ($coupon->discount_type == 'percent_product') {
                        $discount += ($item['price'] * $item['quantity'] * $coupon->discount_value) / 100;
                    } elseif ($coupon->discount_type == 'fixed_product') {
                        $discount += $coupon->discount_value * min(1, $item['quantity']); // Giảm giá cố định cho mỗi sản phẩm
                    }
                }
            }
            // Nếu không có sản phẩm hợp lệ
            if (empty($validProducts)) {
                return back()->with([
                    'alert-type' => 'error',
                    'alert-message' => 'Không có sản phẩm nào đủ điều kiện để áp dụng mã giảm giá này.'
                ]);
            }
        }
        // Cập nhật tổng số tiền sau khi giảm giá
        $totalAmountAfterDiscount = $totalAmount - $discount;
        // dd($discount);
        session()->put('coupon', [
            'name' => $coupon->name,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value,
            'discount' => $discount,
            'totalAmountBeforeDiscount' => $totalAmount,
            'totalAmountAfterDiscount' => $totalAmountAfterDiscount,
        ]);
        // Thông báo kết quả áp dụng mã giảm giá
        if (!empty($validProducts)) {
            // Nếu có sản phẩm hợp lệ, thông báo cho sản phẩm
            return back()->with([
                'alert-type' => 'success',
                'alert-message' => 'Áp dụng mã giảm giá thành công cho các sản phẩm: ' . implode(', ', $validProducts) . '.'
            ]);
        } else {
            // Nếu không có sản phẩm hợp lệ, thông báo cho giỏ hàng
            return back()->with([
                'alert-type' => 'success',
                'alert-message' => 'Áp dụng mã giảm giá thành công cho giỏ hàng.'
            ]);
        }
    }
    public function removeCoupon()
    {
        $coupon = Coupon::where('name', session('coupon')['name'])->first();
        DB::table('coupon_user')
            ->where('coupon_id', $coupon->id)
            ->where('user_id', Auth::id())
            ->delete();
        session()->forget('coupon');
        return back()->with([
            'alert-type' => 'success',
            'alert-message' => 'Hủy mã giảm giá thành công.'
        ]);
    }
    public function showCheckout()
    {
        // dd(session('coupon'));
        // session()->forget('coupon');
        $cart = session('cart', []);
        $totalAmount = 0;
        foreach ($cart as  $item) {
            $totalAmount += $item['quantity'] * $item['price'];
        }
        if (session()->has('coupon')) {
            $totalAmount = session('coupon')['totalAmountAfterDiscount']; // Lấy tổng giá trị đã giảm từ session
        }
        return view('client.checkout', compact('totalAmount'));
    }

    public function save()
    {
        // dd(request()->all());
        try {
            DB::transaction(function () {

                $user = Auth::user();

                $totalAmount = 0;
                $dataItem = [];

                foreach (session('cart') as $variantID => $item) {
                    $totalAmount += $item['quantity'] * $item['price'];
                    // dd($item);
                    $dataItem[] = [
                        'product_variant_id' => $variantID,
                        'quantity' => $item['quantity'],
                        'product_name' => $item['name'],
                        'product_sku' => $item['sku'],
                        'product_img_thumbnail' => $item['img_thumbnail'],
                        'product_price_regular' => $item['price_regular'],
                        'product_price_sale' => $item['price_sale'],
                        'variant_image' => $item['image'] ?? $item['img_thumbnail'],
                        'variant_price' => $item['price'],
                        'variant_size_name' => $item['size']['name'],
                        'variant_color_name' => $item['color']['name'],

                    ];
                    // dd($dataItem,$item);
                }
                if (session()->has('coupon')) {
                    $coupon = Coupon::where('name', session('coupon')['name'])->first();
                    $coupon->increment('used');

                    DB::table('coupon_user')
                        ->where('coupon_id', $coupon->id)
                        ->where('user_id', Auth::id())
                        ->update([
                            'usage_count' => DB::raw('usage_count + 1'),
                            'used_at' => now(),  // Cập nhật thời gian sử dụng mã
                        ]);
                    $totalAmount = session('coupon')['totalAmountAfterDiscount'];
                }
                $order = Order::query()->create([
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'coupon_id' => $coupon->id ?? null,
                    'user_email' => $user->email,
                    'user_phone' => request('user_phone'),
                    'user_address' => request('user_address'),
                    'user_note' => request('user_note'),
                    'total_price' =>  $totalAmount,
                ]);
                $dataUser = User::find($user->id);
                $dataUser->update([
                    'phone' => request('user_phone'),
                    'address' => request('user_address'),
                ]);
                foreach ($dataItem as $item) {
                    $item['order_id'] = $order->id;

                    OrderItem::query()->create($item);
                    $inventory = Inventory::where('product_variant_id', $item['product_variant_id'])
                        ->first();
                    // dd( $inventory);
                    if ($inventory) {
                        $newQuantity = $inventory->quantity - $item['quantity'];
                        $inventory->update([
                            'quantity' => $newQuantity
                        ]);
                    }
                }
            });

            session()->forget('cart');
            session()->forget('coupon');
            return redirect()->route('home')->with([
                'alert-type' => 'success',
                'alert-message' => 'Đặt hàng thành công.'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            Log::error('Lỗi đặt hàng' . $exception->getMessage());
            return back()->with('error', 'Lỗi đặt hàng');
        }
    }
}
