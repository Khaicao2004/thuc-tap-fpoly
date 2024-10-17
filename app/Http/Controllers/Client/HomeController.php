<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function home(){
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
    // dd($productHotDeals);
    return view('client.index', compact('productHotDeals','productGoodDeals','productNews'));
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
       // dd($relatedProducts->toArray());

       return view('client.shop-details', compact('product', 'colors', 'sizes', 'galleries', 'relatedProducts'));
   }
}
