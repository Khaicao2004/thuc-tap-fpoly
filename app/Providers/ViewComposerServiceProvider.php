<?php

namespace App\Providers;

use App\Models\Catalogue;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('client.*', function ($view) {
            // totalAmout
            $slug = request()->route('slug');
            $totalAmount = 0;
            if (session()->has('cart')) {
                foreach (session('cart') as $item) {
                    $totalAmount += $item['quantity'] * $item['price'];
                }
            }
            // catalogue 
            $catalogue = Catalogue::whereNull('parent_id')
            ->orderBy('id', 'asc')
            ->take(8) 
            ->limit(5) 
            ->with('children.children') 
            ->get();
        // dd( $catalogue);
        $cataloguePro = [];

        foreach ($catalogue as $cat) {
            $cataloguePro[$cat->id] = $cat->products()->where('is_active', true)->get();
        }

        $currentCatalogue = $slug ? Catalogue::where('slug', $slug)->first() : null;

        $products = $currentCatalogue ? Product::where('catalogue_id', $currentCatalogue->id)
            ->orWhereIn('catalogue_id', $currentCatalogue->children()->pluck('id'))
            ->get() : collect(); 
            $view->with([
                'totalAmount' => $totalAmount,
                'catalogue' => $catalogue,
                'cataloguePro'=>$cataloguePro,
                'currentCatalogue'=>$currentCatalogue,
                'products'=>$products
            ]);
        });
    }
}
