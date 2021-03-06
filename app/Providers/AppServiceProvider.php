<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Admin\Models\Others\Contacts;
use App\Admin\Models\News\LinksModel;
use App\Admin\Models\News\CarouselModel;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // TODO
        $webState = getenv('APP_KEY');//获取ENV文件中Key值
        if ($webState) {
            $oContacts = new Contacts();
            $contacts = $oContacts->index();
            // dd($contacts["data"]->random()->all());
            View::share('contacts', $contacts["data"]->sortBy(function ($product, $key) use($contacts) {
                return $contacts["data"]->random();
            }));
            // View::share('contacts', $contacts["data"]);
            View::share('links', LinksModel::where('type', 1)->orderBy('links_order', 'desc')->get());
            View::share('search_links', LinksModel::where('type', 2)->orderBy('links_order', 'desc')->get());
            View::share('product_links', LinksModel::where('type', 3)->orderBy('links_order', 'desc')->get());
            //
            Blade::directive('join', function ($expression) {
                return "<?php echo implode('<br />',$expression); ?>";
            });
            Blade::directive("getContacts", function ($expression) {
                $index = new Contacts();
                $contacts = $index->index();
                $returnValue = "";
                if (strstr($expression, 'html')) {
                    $element = '<ul class="clearfix">';
                    // foreach($contacts['data']->random(10) as $key => $val) {
                    foreach ($contacts['data'] as $key => $val) {

                        $element .= '<li>';
                        $element .= '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=' . $val->qq . '&site=qq&menu=yes">';
                        $element .= '<img alt="给我发消息" src="' . asset("/images/button_old_41.gif") . '">';
                        $element .= $val->contactname . '</a>';
                        $element .= '</li>';
                    }
                    $element .= "</ul>";
                    $returnValue = $element;
                }
                if ($expression == '"json"') {
                    $returnValue = json_encode($contacts['data']);
                }
                if ($expression == '"table"') {
                    $element = '';
                    foreach ($contacts['data'] as $key => $val) {
                        $element .= '<tr>';
                        $element .= '<td>姓名：' . $val->contactname . '</td>';
                        $element .= '<td>电话：' . $val->mobile . '</td>';
                        $element .= '<td>QQ：' . $val->qq . '</td>';
                        $element .= '<td>邮箱：' . $val->email . '</td>';
                        $element .= '</tr>';
                    }
                    $element .= "";
                    $returnValue = $element;
                }
                return "<?php  echo '$returnValue'; ?>";
            });
            Blade::component('layouts.aboutus', 'aboutusLayout');
            Blade::include('http.productTemplate.tabpanel', 'tabpanel');
        }else{
            echo "项目未启用";
        }


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
