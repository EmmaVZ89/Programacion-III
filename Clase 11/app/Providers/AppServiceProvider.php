<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//AGREGO EL PAGINADOR
use Illuminate\Pagination\Paginator;

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
        //AGREGO EL PAGINADOR DE BOOTSTRAP
        Paginator::useBootstrap();
    }
}
