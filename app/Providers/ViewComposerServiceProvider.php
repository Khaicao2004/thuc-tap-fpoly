<?php

namespace App\Providers;

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
            $totalAmount = 0;
            if (session()->has('cart')) {
                foreach (session('cart') as $item) {
                    $totalAmount += $item['quantity'] * $item['price'];
                }
            }
            // catalogue 
            // $catalogues = Catalogue::query()->where('is_active', true)->get();
            // dd($catalogues->toArray());
            $view->with([
                'totalAmount' => $totalAmount,
                // 'catalogues' => $catalogues
            ]);
        });
    }
}
