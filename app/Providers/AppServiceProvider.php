<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Admin\Models\Others\Contacts;

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
        Blade::directive("getContacts", function($expression) {
            $index = new Contacts();
            $contacts = $index->index();
            $element = '<ul class="clearfix">';
            foreach($contacts['data'] as $key => $val) {
                $element.='<li>';
                $element.='<a href="http://wpa.qq.com/msgrd?v=3&uin='.$val->qq.'&site=qq&menu=yes">';
                $element.='<img alt="给我发消息" src="'.asset("/images/button_old_41.gif").'">';
                $element.=$val->contactname.'</a>';
                $element.='</a></li>';
            }
            $element.="</ul>";
            return "<?php echo '$element'; ?>";
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
