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
        $xs_result = $this->xsdocuemnt('business',$search);
        if(empty($xs_result)){
            $xs_result = $this->xsdocuemnt('orders',$search);
            if(empty($xs_result)){
                $xs_result = $this->xsdocuemnt('customer',$search);
                if(!empty($xs_result)){
                    $xs_result = $this->xsdocuemnt('business',$xs_result[0]['id']);
                    if(empty($xs_result)){
                        return $search_result = [];
                    }
                } else {
                    return $search_result = [];
                }
            }
        }
        if(empty($xs_result)){
            return $search_result = [];
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
