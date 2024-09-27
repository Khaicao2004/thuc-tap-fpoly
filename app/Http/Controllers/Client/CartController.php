<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function list()
    {
        // session()->forget('cart');
        if ((session('cart'))) {
            $cart = session('cart');
        } else {
            $cart = [];
        }
        // dd($cart);
        $totalAmount = 0;
        foreach ($cart as  $item) {
            $totalAmount += $item['quantity'] * $item['price'];
        }
        // dd($totalAmount);
        return view('client.shopping-cart', compact('totalAmount'));
    }


    public function add()
    {
        try {
            $product = Product::query()->findOrFail(request('product_id'));
            $productVariant = ProductVariant::query()
                ->with(['color', 'size'])
                ->where([
                    'product_id' => request('product_id'),
                    'product_color_id' => request('product_color_id'),
                    'product_size_id' => request('product_size_id'),
                ])
                ->firstOrFail();
            $quantityToAdd  = request()->input('quantity');

            // Lấy giỏ hàng hiện tại từ session
            $cart = session()->get('cart', []);
            // dd($cart);
            // Lấy số lượng hiện có trong giỏ hàng của sản phẩm này
            $currentQuantityInCart = isset($cart[$productVariant->id]) ? $cart[$productVariant->id]['quantity'] : 0;
            // Tính tổng số lượng sau khi thêm mới
            $newTotalQuantity = $currentQuantityInCart + $quantityToAdd;
            // dd($newTotalQuantity);
            $inventory = Inventory::where('product_variant_id', $productVariant->id)->first();
            // dd($inventory);
            if ($inventory && $newTotalQuantity > $inventory->quantity) {
                return back()->with([
                    'alert-type' => 'error',
                    'alert-message' => 'Số lượng sản phẩm còn lại không đủ hoặc đã hết hàng.'
                ]);
            }
            // Nếu sản phẩm chưa có trong giỏ hàng, khởi tạo dữ liệu mới
            if (!isset($cart[$productVariant->id])) {
                $data = $product->toArray() + $productVariant->toArray();  // Kết hợp dữ liệu sản phẩm và biến thể
                $data['quantity'] = $quantityToAdd;  // Đặt số lượng bằng số lượng vừa thêm
            } else {
                // Nếu sản phẩm đã có trong giỏ hàng, chỉ cập nhật số lượng
                $data = $cart[$productVariant->id];
                $data['quantity'] = $newTotalQuantity;  // Cập nhật với tổng số lượng mới
            }

            // Lưu lại vào session
            $cart[$productVariant->id] = $data;
            session()->put('cart', $cart);  // Lưu toàn bộ giỏ hàng vào session


            return back()->with([
                'alert-type' => 'success',
                'alert-message' => 'Sản phẩm đã được thêm vào giỏ hàng.'
            ]);
        } catch (\Exception $exception) {
            Log::error('Lỗi thêm vào giỏ hàng' . $exception->getMessage());
            return back()->with([
                'alert-type' => 'error',
                'alert-message' => 'Có lỗi xảy ra xin đợi ít phút.'
            ]);
        }
    }


    public function remove($variantId)
    {
        try {
            $cart = session()->get('cart');

            if (isset($cart[$variantId])) {
                unset($cart[$variantId]);
                session()->put('cart', $cart);

                $totalAmount = array_reduce($cart, function ($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0);

                return response()->json(['success' => true, 'totalAmount' => number_format($totalAmount)]);
            }

            return response()->json(['success' => false], 404);
        } catch (\Exception $e) {
            // Trả về chi tiết lỗi để debug
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $variantId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1', // Đảm bảo quantity là số nguyên và lớn hơn 0
        ]);

        // Tìm sản phẩm trong giỏ hàng
        $cart = session()->get('cart');
        if (isset($cart[$variantId])) {
            $quantity = $request->input('quantity');

            // Lấy thông tin sản phẩm từ cơ sở dữ liệu
            $productVariant = ProductVariant::find($variantId);
            $inventory = Inventory::where('product_variant_id', $productVariant->id)->first();

            // Tính tổng số lượng sản phẩm trong giỏ hàng
            $currentProductQuantityInCart = $cart[$variantId]['quantity'];

            // Tính tổng số lượng sản phẩm trong giỏ hàng ngoại trừ sản phẩm hiện tại
            $currentCartQuantity = 0;
            foreach ($cart as $item) {
                $currentCartQuantity += $item['quantity'];
            }

            // Tính số lượng tối đa có thể thêm vào giỏ hàng
            $maxAvailableQuantity = $inventory ? $inventory->quantity : 0;

            // Kiểm tra số lượng trong kho
            if (($currentCartQuantity - $currentProductQuantityInCart + $quantity) > $maxAvailableQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng sản phẩm còn lại không đủ hoặc đã hết hàng.'
                ]);
            }

            // Cập nhật số lượng
            $cart[$variantId]['quantity'] = $quantity;

            // Lưu lại giỏ hàng
            session()->put('cart', $cart);

            // Tính toán lại tổng
            $totalAmount = 0; // Tính tổng tiền
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'adjustedQuantity' => $cart[$variantId]['quantity'],
                'itemTotal' => $cart[$variantId]['price'] * $cart[$variantId]['quantity'],
                'totalAmount' => $totalAmount,
                'message' => 'Cập nhật thành công.',
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Sản phẩm không tìm thấy.']);
    }
}
