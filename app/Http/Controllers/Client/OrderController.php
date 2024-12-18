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
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function applyCoupon(Request $request)
    {
        // dd($request->all());
        $cart = session('cart', []);
        $totalAmount = 0;
        foreach ($cart as $item) {
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
        foreach ($cart as $item) {
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
                    // dd($dataItem);
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
                    'total_price' => $totalAmount,
                ]);
                // dd($dataItem);
                $dataUser = User::find($user->id);
                $dataUser->update([
                    'phone' => request('user_phone'),
                    'address' => request('user_address'),
                ]);
                foreach ($dataItem as $item) {
                    // dd($dataItem,$item);
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
            // dd($exception->getMessage());    
            Log::error('Lỗi đặt hàng' . $exception->getMessage());
            return back()->with('error', 'Lỗi đặt hàng');
        }
    }
    public function list(Request $request)
    {
        $query = Order::where('user_id', auth()->id());

        // Kiểm tra nếu có từ khóa tìm kiếm
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', "%$searchTerm%")
                    ->orWhere('user_name', 'like', "%$searchTerm%");
            });
        }

        $orders = $query->with('orderItems')->get();

        return view('client.order', compact('orders'));
    }
    public function cancel($id)
    {
        $order = Order::find($id);

        if ($order) {
            // Cập nhật trạng thái đơn hàng
            $order->status_order = 'canceled'; // Sử dụng giá trị tương ứng trong STATUS_ORDER
            $order->save();

            return response()->json(['message' => 'Đơn hàng đã được hủy thành công.']);
        }

        return response()->json(['message' => 'Đơn hàng không tồn tại.'], 404);
    }

    public function vnpay_payment(Request $request)
    {
        try {
            $data = $request->all();

            if (!isset($data['total'])) {
                throw new \Exception('Total amount is missing.');
            }

            // Store the payment details in the session
            session([
                'payment_details' => [
                    'user_name' => $request->input('user_name'),
                    'user_phone' => $request->input('user_phone'),
                    'user_address' => $request->input('user_address'),
                    'user_email' => $request->input('user_email'),
                    'user_note' => $request->input('user_note'),
                    'total' => $data['total']
                ]
            ]);

            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('vnpay.return');
            $vnp_TmnCode = "8ZDRBDI8";
            $vnp_HashSecret = "ZD3NR5W5IV5DT0NJ7I8ZYYGCMEHP9445";

            $vnp_TxnRef = Str::upper(Str::random(10));
            $vnp_OrderInfo = "Thanh toán hóa đơn";
            $vnp_OrderType = "TN SHOP";
            $vnp_Amount = $data['total'] * 100;
            $vnp_Locale = "VN";
            $vnp_BankCode = "NCB";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;

            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }

            return redirect()->to($vnp_Url);
        } catch (\Exception $e) {
            Log::error('VNPay Payment Error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại.');
        }
    }


    public function vnpay_return(Request $request)
    {
        DB::beginTransaction();
        try {
            $paymentDetails = session('payment_details');

            $cart = session('cart', []);
            $totalAmount = $paymentDetails['total'];
            $dataItem = [];

            foreach ($cart as $variantID => $item) {
                $totalAmount += $item['quantity'] * $item['price'];
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

            // Create the order
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'coupon_id' => $coupon->id ?? null,
                'user_name' => $paymentDetails['user_name'],
                'user_email' => $paymentDetails['user_email'],
                'user_phone' => $paymentDetails['user_phone'],
                'user_address' => $paymentDetails['user_address'],
                'user_note' => $paymentDetails['user_note'],
                'total_price' => $totalAmount,
                'status_payment' => 'paid',
            ]);

            // Process the order items and update the inventory
            foreach ($dataItem as $item) {
                $item['order_id'] = $order->id;
                $kk = OrderItem::create($item);

                $inventory = Inventory::where('product_variant_id', $item['product_variant_id'])->first();
                if ($inventory) {
                    $newQuantity = $inventory->quantity - $item['quantity'];
                    $inventory->update(['quantity' => $newQuantity]);
                }
            }

            DB::commit();
            session()->forget('cart');
            session()->forget('coupon');

            return redirect()->route('home')->with([
                'alert-type' => 'success',
                'alert-message' => 'Thanh toán thành công và đặt hàng thành công.',
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error creating order: ' . $exception->getMessage());
            return redirect()->route('home')->with('error', 'Đã xảy ra lỗi trong quá trình đặt hàng.');
        }
    }
}
