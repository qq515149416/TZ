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
            $returnValue = "";
            if(strstr($expression,'html')) {
                $element = '<ul class="clearfix">';
                foreach($contacts['data']->random(10) as $key => $val) {
                    $element.='<li>';
                    $element.='<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$val->qq.'&site=qq&menu=yes">';
                    $element.='<img alt="给我发消息" src="'.asset("/images/button_old_41.gif").'">';
                    $element.=$val->contactname.'</a>';
                    $element.='</li>';
                }
                $element.="</ul>";
                $returnValue = $element;
            }
            if($expression=='"json"') {
                $returnValue = json_encode($contacts['data']);
            }
            if($expression=='"table"') {
                $element = '';
                foreach($contacts['data'] as $key => $val) {
                    $element.='<tr>';
                    $element.='<td>姓名：'.$val->contactname.'</td>';
                    $element.='<td>电话：'.$val->mobile.'</td>';
                    $element.='<td>QQ：'.$val->qq.'</td>';
                    $element.='<td>邮箱：'.$val->email.'</td>';
                    $element.='</tr>';
                }
                $element.="";
                $returnValue = $element;
            }
            return "<?php  echo '$returnValue'; ?>";
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
