<?php

namespace App\Admin\Controllers\Search;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Search\SearchModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use XS;
use XSDocument;


class SearchController extends Controller
{
    use ModelForm;
    
    /**
     * 搜索结果
     * @param  string $search 搜索条件
     * @return array         搜索结果
     */
    public function doSearch($search){
        if(!$search){
            return $search_result = [];
        }
        $business = $this->xsdocuemnt('business',$search);//直接查询业务
        $orders  = $this->xsdocuemnt('orders',$search);//查询订单资源
        if(!empty($business) && !empty($orders)){//当业务和资源的搜索索引存在时进行同时查询
            $xs_result = array_merge($business,$orders);
        } elseif(!empty($business) && empty($orders)){//当只存在业务时，查询业务
            $xs_result = $business;
        } elseif(empty($business) && !empty($orders)){//当只存在资源时，搜索资源
            $xs_result = $orders;
        } 
        if(empty($xs_result)){
            $customer = $this->xsdocuemnt('customer',$search);
            if(!empty($customer)){
                $xs_result = $this->xsdocuemnt('business',$customer[0]['id']);
                if(empty($xs_result)){
                    return $search_result = [];
                }
            } else {
                return $search_result = [];
            }
           
        }
        $model = new SearchModel();
        $search_result = $model->doSearch($xs_result);
        return $search_result;
    }

    /**
     * 通过检索文件搜索对应的数据信息
     * @param  string $document         需搜索的检索文件名，默认business
     * @param  string $search_condition 搜索的条件
     * @return array                   返回搜索结果
     */
    public function xsdocuemnt($document = 'business',$search_condition = ''){
        $xunsearch = new XS($document);
        return $xunsearch->search->setQuery($search_condition)->search();
    }
}
