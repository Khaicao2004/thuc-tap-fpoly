<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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

        // Lấy 5 bài viết tin tức mới nhất
        $blogs = Blog::query()->latest()->take(3)->get();

        // Trả về view và truyền dữ liệu sản phẩm cùng với tin tức
        return view('client.index', compact('productHotDeals', 'productGoodDeals', 'productNews', 'blogs'));
    }

    public function detail($slug)
    {
        $product = Product::with('variants')
            ->where('slug', $slug)->first();
        $colors = ProductColor::query()->pluck('name', 'id')->all();
        $sizes = ProductSize::query()->pluck('name', 'id')->all();
        $galleries = ProductGallery::where('product_id', $product->id)->pluck('image', 'id');
        $relatedProducts = Product::query()
            ->where('catalogue_id', $product->catalogue_id) // sản phẩm cùng danh mục
            ->where('id', '!=', $product->id) // không lấy chính sản phẩm đang xem
            ->limit(4) // giới hạn lấy 4 sản phẩm
            ->get();
        return view('client.shop-details', data: compact('product', 'colors', 'sizes', 'galleries', 'relatedProducts'));
    }
}
