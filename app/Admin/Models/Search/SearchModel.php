<?php

namespace App\Admin\Models\Search;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class SearchModel extends Model
{
    use SoftDeletes;
    protected $table = 'tz_business';

    /**
     * 用于资源时分类
     * @param  array $array 需要分类的数据
     * @param  int $state 分类的条件
     * @return [type]        [description]
     */
    private function filter($array,$state){
        $this->state = $state;
        $result = [];
        $arr = array_filter($array,function($var) {
            return $var->resource_type == $this->state;
        });
        foreach ($arr as $key => $value) {
            array_push($result,$value);
        }
        return $result;
    } 

   /**
     * 进行对应业务的搜索
     * @param  array $xs_result 搜索所需的条件
     * @return array           返回搜索的结果
     *///->whereBetween('business_status',[0,4])
    public function doSearch($xs_result){
        if(!$xs_result){
            return $search_result = [];
        }
        $search_result = [];
        //$result_key  = 0;
        foreach($xs_result as $xs_key => $xs_value){
            $business = $this->where(['business_number'=>$xs_value['business_sn']])->whereBetween('remove_status',[0,1])->select('id','client_id','sales_id','business_number','business_type','machine_number','resource_detail','money','client_id','length','start_time','endding_time','business_status')->first();
            if(!empty($business)){
                $business = $business->toArray();
                $business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜'];
                $business_status = ['-1'=>'取消','-2'=>'审核不通过',0=>'审核中',1=>'未付款使用',2=>'付款使用中',3=>'到期未付款',4=>'锁定中',5=>'到期',6=>'退款'];
                $business['type'] = $business_type[$business['business_type']];//业务类型
                $business['status'] = $business_status[$business['business_status']];//业务状态
                $resource = $this->searchResources($business['business_number']);
                $ovalue->business_name = DB::table('admin_users')->where(['id'=>$business['sales_id']])->value('name');
                $ovalue->customer_name = $email;
                $customer = DB::table('tz_users')->where(['id'=>$business['client_id']])->select('name','email','nickname','msg_qq','msg_phone','remarks')->first();
                if(!empty($customer)){
                    $qq = isset($customer->msg_qq)?$customer->msg_qq:'';
                    $phone = isset($customer->msg_phone)?$customer->msg_phone:'';
                    $email = $customer->email ? $customer->email : $customer->name;
                    $email = $email ? $email : $customer->nickname;
                    $business['client_name'] = '用户:'.$email.
                                                'QQ:'.$qq.
                                                '手机:'.$phone.
                                                '备注:'.$customer->remarks;
                }
                $ip = [];
                $total_bandwidth = 0;
                $total_protected = 0;
                if(!empty($resource['IP'])){//IP
                    foreach($resource['IP'] as $key=>$value){
                        array_push($ip,$value->resource);
                    }
                }
                if(!empty($resource['bandwidth'])){//带宽
                    foreach($resource['bandwidth'] as $key=>$value){
                        $total_bandwidth = bcadd($total_bandwidth,$value->resource); 
                    }
                }
                if(!empty($resource['protected'])){//防护
                    foreach($resource['protected'] as $key=>$value){
                        $total_protected = bcadd($total_protected,$value->resource); 
                    }
                }
                $resource_detail = json_decode($business['resource_detail']);
                if($business['business_type'] != 3 ){
                    array_push($ip,$resource_detail->ip_detail);//IP
                    $total_bandwidth = bcadd($total_bandwidth,$resource_detail->bandwidth);//带宽
                    $total_protected = bcadd($total_protected,$resource_detail->protect);//防护
                    $business['cabinet'] = $resource_detail->cabinets;
                    $business['machineroom_name'] = $resource_detail->machineroom_name;
                    $business['machineroom_id'] = $resource_detail->machineroom_id;
                } else {
                    $business['cabinet'] = $resource_detail->cabinet_id;
                    $business['machineroom_name'] = $resource_detail->machineroom_name;
                    $business['machineroom_id'] = $resource_detail->machineroom_id;
                }
                $business['ip'] = $ip;
                $business['protect'] = $total_protected;
                $business['bandwidth'] = $total_bandwidth;
            }
            if(!empty($business)){//当查询到对应的业务时将业务编号作为下标生成新的数组，防止同个业务数据出现多次
                $search_result['S'.$business['business_number']] = $business;
            }
   
        }
        return $search_result;
    }

    /**
     * 业务所绑定的资源信息查找
     * @param  string $business_sn 资源所绑定的业务编号
     * @return array              返回业务绑定的所有资源
     */
    public function searchResources($business_sn){
        $all_resource = DB::table('tz_orders')->where(['business_sn'=>$business_sn,'remove_status'=>0])->where('resource_type','>','3')->whereNull('deleted_at')->orderBy('end_time','desc')->select('machine_sn','resource')->get()->groupBy('machine_sn')->toArray();
        $resource_keys = array_keys($all_resource);//获取分组后的资源编号
        foreach($resource_keys as $key=>$value){
            $order['machine_sn'] = $value;
            $resource[$key] = DB::table('tz_orders')->where($order)->where('order_status','<',4)->whereNull('deleted_at')->orderBy('end_time','desc')->select('resource_type','machine_sn','resource')->first();
        }
        $orders = ['IP'=>$this->filter($resource,4),'cpu'=>$this->filter($resource,5),'harddisk'=>$this->filter($resource,6),'memory'=>$this->filter($resource,7),'bandwidth'=>$this->filter($resource,8),'protected'=>$this->filter($resource,9),'cdn'=>$this->filter($resource,10)];
        return $orders;
    }
}
