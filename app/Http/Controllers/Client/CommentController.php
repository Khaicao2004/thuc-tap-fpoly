<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreCommentRequest $request)
{

    $user = auth()->user();
    $product = Product::findOrFail($request->product_id);

    $hasPurchased = OrderItem::whereHas('order', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->whereHas('productVariant', function ($query) use ($product) {
        $query->where('product_id', $product->id);
    })->exists();

    if (!$hasPurchased) {
        return redirect()->back()->withErrors('Bạn cần mua sản phẩm trước khi bình luận.');
    }   

    Comment::create([
        'user_id' => auth()->id(),
        'product_id' => $request->product_id,
        'content' => $request->input('content'),
        'rating' => $request->input('rating'),
    ]);

    return redirect()->back()->with('success', 'Bình luận của bạn đã được gửi.');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $product = Product::with('comments')->findOrFail($id);

    // Lấy các sản phẩm liên quan dựa trên danh mục của sản phẩm hiện tại
    $relatedProducts = Product::with(['comments'])
        ->withCount(['comments as ratingCount'])
        ->withAvg(['comments as averageRating'], 'rating')
        ->where('category_id', $product->category_id) // Điều kiện lọc theo category
        ->where('id', '!=', $product->id) // Loại trừ sản phẩm hiện tại
        ->get();

    // Trả về view cùng với dữ liệu sản phẩm và sản phẩm liên quan
    return view('client.product.show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
