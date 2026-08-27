<?php

namespace App\Providers;

use App\Models\NomorMeja;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Keranjang ada di setiap halaman frontsite, jadi datanya disuplai dari
        // sini daripada di-compact ulang di tiap controller yang merender header.
        View::composer(['components.frontsite.header', 'components.frontsite.bottom-nav'], function ($view) {
            $cart = session()->get('cart');

            $view->with([
                'cart' => $cart
                    ? ['sumQty' => array_sum(array_column($cart, 'qty')), 'data' => $cart]
                    : ['sumQty' => 0, 'data' => []],
                'nomormeja' => session()->get('nomormeja'),
                'nomormejas' => NomorMeja::all(),
            ]);
        });
    }
}
