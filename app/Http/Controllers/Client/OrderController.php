<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function showCheckout()
    {
        if ((session('cart'))) {
            $cart = session('cart');
        } else {
            $cart = [];
        }
        $totalAmount = 0;
        foreach ($cart as  $item) {
            $totalAmount += $item['quantity'] * $item['price'];
        }
        return view('client.checkout', compact('totalAmount'));
    }
    public function save()
    {
        // dd(request()->all());
        try {
            DB::transaction(function () {
                if (Auth::check()) {
                    $user = Auth::user();
                } else {
                    $user = User::query()->create([
                        'name' => request('user_name'),
                        'email' => request('user_email'),
                        'phone' => request('user_phone'),
                        'address' => request('user_address'),
                        'password' => bcrypt(request('user_email')),
                        'is_active' => false,
                    ]);
                    // dd($user);
                }
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
                        'variant_image' => $item['image'],
                        'variant_price' => $item['price'],
                        'variant_size_name' => $item['size']['name'],
                        'variant_color_name' => $item['color']['name'],

                    ];
                    // dd($dataItem,$item);
                }
                $order = Order::query()->create([
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'coupon_id' => 1,
                    'user_email' => $user->email,
                    'user_phone' => $user->phone,
                    'user_address' => $user->address,
                    'user_note' => request('user_note'),
                    'total_price' =>  $totalAmount,
                ]);
                // dd($order);
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

            return redirect()->route('home')->with('success', 'Đặt hàngthành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Lỗi đặt hàng' . $exception->getMessage());
            return back()->with('error', 'Lỗi đặt hàng');
        }
    }
}
