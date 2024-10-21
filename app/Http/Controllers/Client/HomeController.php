<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Blog;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $productHotDeals = Product::where('is_active', true)
            ->where('is_hot_deal', true)
            ->limit(6)
            ->get();
        $productGoodDeals = Product::where('is_active', true)
            ->where('is_good_deal', true)
            ->limit(6)
            ->get();
        $productNews = Product::where('is_active', true)
            ->where('is_new', true)
            ->limit(6)
            ->get();
        return view('client.index', compact('productHotDeals', 'productGoodDeals', 'productNews'));
    }
    public function detail($slug)
    {
        $product = Product::with('variants')
            ->where('slug', $slug)->first();

        $colors = ProductColor::query()->pluck('name', 'id')->all();
        $sizes = ProductSize::query()->pluck('name', 'id')->all();
        $galleries = ProductGallery::where('product_id', $product->id)->pluck('image', 'id');

        // Lấy sản phẩm liên quan
        // Lấy 5 bài viết tin tức mới nhất
        $blogs = Blog::query()->latest()->take(3)->get();
        // Trả về view và truyền dữ liệu sản phẩm cùng với tin tức
        return view('client.index', compact('productHotDeals', 'productGoodDeals', 'productNews', 'blogs'));
    }
    public function detail($slug)
    {
        $product = Product::query()->with('variants')->where('slug', $slug)->first();
        $colors = ProductColor::query()->pluck('name', 'id')->all();
        $sizes = ProductSize::query()->pluck('name', 'id')->all();
        $galleries = ProductGallery::query()->where('product_id', $product->id)->pluck('image', 'id');

        $relatedProducts = Product::query()
            ->where('catalogue_id', $product->catalogue_id) // sản phẩm cùng danh mục
            ->where('id', '!=', $product->id) // không lấy chính sản phẩm đang xem
            ->limit(4) // giới hạn lấy 4 sản phẩm
            ->get();

        $ratingCounts = [
            '5' => Comment::where('product_id', $product->id)->where('rating', 5)->count(),
            '4' => Comment::where('product_id', $product->id)->where('rating', 4)->count(),
            '3' => Comment::where('product_id', $product->id)->where('rating', 3)->count(),
            '2' => Comment::where('product_id', $product->id)->where('rating', 2)->count(),
            '1' => Comment::where('product_id', $product->id)->where('rating', 1)->count(),
        ];
        // Lấy bình luận (comments) và đánh giá của sản phẩm
        $comments = Comment::where('product_id', $product->id)->with('user')->get();

        $totalRatings = ($ratingCounts['5'] * 5) + ($ratingCounts['4'] * 4) + ($ratingCounts['3'] * 3) + ($ratingCounts['2'] * 2) + ($ratingCounts['1'] * 1);
        $ratingCount = array_sum($ratingCounts);

        // Tính trung bình đánh giá
        $averageRating = $ratingCount > 0 ? $totalRatings / $ratingCount : 0;


        // Kiểm tra nếu người dùng đã đăng nhập và đã đánh giá sản phẩm hay chưa
        $userRating = null;
        if (auth()->check()) {
            $userRating = Comment::where('product_id', $product->id)
                ->where('user_id', auth()->id())
                ->value('rating');
        }

        return view('client.shop-details', compact(
            'product',
            'colors',
            'sizes',
            'galleries',
            'relatedProducts',
            'comments',
            'averageRating',
            'userRating',
            'ratingCount',
            'ratingCounts'
        ));
    }

    public function rating()
{
    $products = Product::where('is_active', true)
        ->with('comments') // Đảm bảo rằng bạn đã thiết lập quan hệ comments với model Product
        ->get();

    foreach ($products as $product) {
        $ratingCounts = [
            '5' => $product->comments()->where('rating', 5)->count(),
            '4' => $product->comments()->where('rating', 4)->count(),
            '3' => $product->comments()->where('rating', 3)->count(),
            '2' => $product->comments()->where('rating', 2)->count(),
            '1' => $product->comments()->where('rating', 1)->count(),
        ];

        $totalRatings = ($ratingCounts['5'] * 5) + ($ratingCounts['4'] * 4) + ($ratingCounts['3'] * 3) + ($ratingCounts['2'] * 2) + ($ratingCounts['1'] * 1);
        $ratingCount = array_sum($ratingCounts);

        // Tính trung bình đánh giá
        $averageRating = $ratingCount > 0 ? $totalRatings / $ratingCount : 0;

        // Gán trung bình đánh giá vào sản phẩm
        $product->averageRating = $averageRating;
    }

    $productHotDeals = $products->where('is_hot_deal', true)->take(6);
    $productGoodDeals = $products->where('is_good_deal', true)->take(6);
    $productNews = $products->where('is_new', true)->take(6);

    return view('client.index', compact('productHotDeals', 'productGoodDeals', 'productNews'));
}
}
