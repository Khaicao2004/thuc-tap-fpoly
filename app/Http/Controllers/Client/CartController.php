<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function list()
    {
        if ((session('cart'))) {
            $cart = session('cart');
        } else {
            $cart = [];
        }
        // dd($cart);
        $totalAmount = 0;
        foreach ($cart as  $item) {
            $totalAmount += $item['quantity'] * ($item['price_sale'] ?: $item['price_regular']);
        }
        return view('client.shopping-cart', compact('totalAmount'));
    }

    
    public function add()
    {
        // dd(request()->all());
        $product = Product::query()->findOrFail(request('product_id'));
        $productVariant = ProductVariant::query()
            ->with(['color', 'size'])
            ->where([
                'product_id' => request('product_id'),
                'product_color_id' => request('product_color_id'),
                'product_size_id' => request('product_size_id'),
            ])
            ->firstOrFail();
        // dd($productVariant->id);

        if (!isset(session('cart')[$productVariant->id])) {
            $data = $product->toArray()
                + $productVariant->toArray();

            // Đặt quantity từ request vào sau khi đã merge dữ liệu
            $data['quantity'] = request('quantity');

            session()->put('cart.' . $productVariant->id, $data);
        } else {
            $data = session('cart')[$productVariant->id];

            // Cập nhật quantity từ request
            $data['quantity'] += request('quantity');

            session()->put('cart.' . $productVariant->id, $data);
        }


        return redirect()->route('cart.list');
    }

    public function remove($productVariantId)
{
    // Kiểm tra xem giỏ hàng có trong session không
    if (session('cart')) {
        // Xóa sản phẩm khỏi giỏ hàng
        session()->forget('cart.' . $productVariantId);
    }

    // Chuyển hướng về trang giỏ hàng
    return redirect()->route('cart.list')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
}
}
