<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::directive('join', function ($expression) {
            return "<?php echo implode('<br />',$expression); ?>";
        });
        Blade::component('layouts.aboutus', 'aboutusLayout');
        Blade::include('http.productTemplate.tabpanel', 'tabpanel');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
