<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算
use Encore\Admin\Facades\Admin;

/**
 * 后台业务模型
 */
class BusinessModel extends Model
{
    use SoftDeletes;
    protected $table = 'tz_business';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['client_id', 'client_name', 'sales_id', 'sales_name', 'order_number', 'business_number', 'business_type', 'machine_number', 'resource_detail', 'money', 'length', 'endding_time', 'business_status', 'business_note', 'remove_status', 'remove_reason', 'check_note', 'created_at', 'updated_at'];

    /**
     * 创建业务数据
     * @param  array $insert 需要创建业务的数据
     * @return array         返回创建业务时的id和状态及提示信息
     */
    public function insertBusiness($insert)
    {
        if (!$insert) {
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '业务无法创建！！';
            return $return;
        }
        //业务编号的生成规则：前两位（1-3的随机数）+ 年月日（如:20180830） + 时间戳的后5位数 + 7-9随机数（业务编号产生）
        $business_sn               = mt_rand(1, 3) . date("Ymd", time()) . substr(time(), 8, 2) . mt_rand(7, 9);
        $insert['business_number'] = $business_sn;
        $insert['business_status'] = 0;
        $client = DB::table('tz_users')->where(['id'=>$insert['client_id'],'status'=>2])->select('id','name','email')->first();
        if(!$client){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '客户不存在或账号未验证/异常,请确认后再创建业务!';
            return $return;
        }
        $insert['client_name'] = $client->name?$client->name:$client->email;
        // 对应业务员的信息
        $sales_id             = Admin::user()->id;
        $insert['sales_id']   = $sales_id;
        $insert['sales_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
        DB::beginTransaction();//开启事务处理
        $row                  = DB::table('tz_business')->insertGetId($insert);
        if ($row == 0) {
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '业务创建失败';
            return $return;
        }
        if($insert['business_type'] == 1 || $insert['business_type'] == 2){
            $machine = DB::table('idc_machine')->where(['machine_num'=>$insert['machine_number']])->update(['used_status'=>2]);
            if($machine == 0){
                DB::rollBack();
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg']  = '业务创建失败!';
                return $return;
            }
        }
        $relevance = DB::table('tz_business_relevance')->insert(['type'=>1,'business_id'=>$insert['business_number'],'created_at'=>date('Y-m-d H:i:s',time())]);
        if($relevance != 0){
            DB::commit();
            $return['data'] = $row;
            $return['code'] = 1;
            $return['msg']  = '业务创建成功，待审核';
        }  else {
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '业务创建失败!!';
        } 
            
        return $return;

    }

    /**
     * 信安部门查看业务数据获取
     * @return array 返回相关的数据和状态及提示信息
     */
    public function securityBusiness()
    {
        $result = $this->orderBy('created_at','desc')->get(['id', 'client_id', 'client_name', 'sales_id', 'sales_name', 'order_number', 'business_number', 'business_type', 'machine_number', 'resource_detail', 'business_status', 'money', 'length', 'business_note','created_at']);
        if (!$result->isEmpty()) {
            $business_status = [-1 => '取消', -2 => '审核不通过', 0 => '审核中', 1 => '未付款使用', 2 => '付款使用中', 3 => '未付用', 4 => '锁定中', 5 => '到期', 6 => '退款'];
            $business_type   = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
            foreach ($result as $check => $check_value) {
                $result[$check]['status'] = $business_status[$check_value['business_status']];
                $result[$check]['type']   = $business_type[$check_value['business_type']];
            }
            $return['data'] = $result;
            $return['code'] = 1;
            $return['msg']  = '相关业务数据获取成功';
        } else {
            $return['data'] = '暂无业务数据';
            $return['code'] = 0;
            $return['msg']  = '暂无业务数据';
        }

        return $return;
    }
// DB::beginTransaction();
// DB::rollBack();
// DB::commit();
    /**
     * 信安部门对业务进行审核操作
     * @param  array $where 业务的业务编号和业务的id
     * @return array        返回相关的数据和状态及提示信息
     */
    public function checkBusiness($where)
    {
        if (!$where) {
            // 没有审核数据
            $return['data'] = '无法进行审核';
            $return['code'] = 0;
            $return['msg']  = '无法进行审核';
            return $return;
        }
        // 根据业务号查询需要审核的业务数据
        $check_where = ['business_number' => $where['business_number']];
        $check       = DB::table('tz_business')->where($check_where)->select('client_id', 'business_number', 'client_name', 'sales_id', 'sales_name', 'business_type', 'machine_number', 'money', 'length','resource_detail')->first();
        if (empty($check)) {
            // 不存在对应的业务数据直接返回
            $return['data'] = '该业务不存在,无法进行审核操作';
            $return['code'] = 0;
            $return['msg']  = '该业务不存在,无法进行审核操作';
            return $return;
        }
        // 当不是机柜时且当审核为通过时先对机器的使用状态进行判断
        if($check->business_type != 3 && $where['business_status'] == 1) {
            // 审核通过前验证业务机器是否未使用，如果是使用直接返回提示
            $machine_where['machine_num'] = $check->machine_number;
            $machine_where['used_status'] = 2;
            $machine_status               = DB::table('idc_machine')->where($machine_where)->select('id', 'machine_num', 'used_status')->first();
            if (empty($machine_status)) {
                $where['business_status'] = '-2';
                $where['check_note']      = '不通过原因:该业务对应的机器已经被使用，请重新选择机器!';
            }

        }
        // 业务表审核时更新的字段
        $business['business_status'] = $where['business_status'];
        $business['check_note']      = $where['check_note'];
        if ($where['business_status'] != 1) {
            DB::beginTransaction();
            // 审核为不通过时直接进行业务的状态更改
            $row = DB::table('tz_business')->where($check_where)->update($business);
            if($row == 0){
                DB::rollBack();
                $return['data'] = '审核失败';
                $return['code'] = 0;
                $return['msg']  = '审核失败!';
                return $return;
            }
            if($check->business_type != 3){
               $machine = DB::table('idc_machine')->where(['machine_num'=>$check->machine_number])->update(['used_status'=>0]);
               if($machine == 0){
                     DB::rollBack();
                    $return['data'] = '审核失败';
                    $return['code'] = 0;
                    $return['msg']  = '审核失败!!';
                    return $return;
               } 
            }
            DB::commit();
            $return['data'] = '';
            $return['code'] = 1;
            if (isset($where['check_note'])) {
                $return['msg'] = '审核不通过,原因:'.$where['check_note'];
            } else {
                $return['msg'] = '审核不通过';
            }
            return $return;
        }

        // 如果审核为通过则继续进行订单表的生成
        DB::beginTransaction();//开启事务处理
        //业务开始时间
        $start_time = Carbon::now()->toDateTimeString();
        //到期时间的计算
        $end_time = Carbon::parse('+' . $check->length . ' months')->toDateTimeString();
        // 订单号的生成规则：前两位（4-6的随机数）+ 年月日（如:20180830） + 时间戳的后2位数 + 1-3随机数
        $order_sn                 = mt_rand(4, 6) . date("Ymd", time()) . substr(time(), 8, 2) . mt_rand(1, 3);
        $business['order_number'] = $order_sn;
        $business['start_time']   = $start_time;
        $business['endding_time'] = $end_time;
        $business['updated_at']   = Carbon::now()->toDateTimeString();
        $business_row             = DB::table('tz_business')->where($check_where)->update($business);
        if ($business_row == 0) {
            // 业务审核失败
            DB::rollBack();
            $return['data'] = '审核失败';
            $return['code'] = 0;
            $return['msg']  = '审核失败!!';
            return $return;
        }
        // 业务审核成功继续进行订单表的生成
        $order['order_sn']      = $order_sn;
        $order['business_sn']   = $check->business_number;
        $order['customer_id']   = $check->client_id;
        $order['customer_name'] = $check->client_name;
        $order['business_id']   = $check->sales_id;
        $order['business_name'] = $check->sales_name;
        $order['resource_type'] = $check->business_type;
        $order['order_type']    = 1;
        $order['machine_sn']    = $check->machine_number;
        $order['price']         = $check->money;//单价
        $order['duration']      = $check->length;//时长
        $order['resource']      = $check->machine_number;//机器的话为IP/机柜则为机柜编号
        $order['end_time']      = $end_time;
        $order['payable_money'] = bcmul((string)$order['price'], (string)$order['duration'], 2);//应付金额
        $order['created_at']    = Carbon::now()->toDateTimeString();
        // $order['month']         = (int)date('Ym', time());
        $order_row              = DB::table('tz_orders')->insert($order);//生成订单
        if ($order_row == 0) {
            // 订单生成失败
            DB::rollBack();
            $return['data'] = '审核失败';
            $return['code'] = 0;
            $return['msg']  = '审核失败!!!';
            return $return;
        }
        if ($order['resource_type'] == 1 || $order['resource_type'] == 2) {
            // 如果是租用/托管机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
            $machine['own_business'] = $order['business_sn'];
            $machine['business_end'] = $order['end_time'];
            $machine['used_status']  = 1;
            $row                     = DB::table('idc_machine')->where('machine_num', $order['machine_sn'])->update($machine);
            if (!$row) {
                DB::rollBack();
                $return['data'] = '审核失败';
                $return['code'] = 0;
                $return['msg']  = '审核失败!!!!';
                return $return;
            }
            $ip_id = json_decode($check->resource_detail)->ip_id;
            $row = DB::table('idc_ips')->where('id',  $ip_id)->update(['own_business' => $order['business_sn'],'mac_num'=>$order['machine_sn']]);

        } else {
            // 如果是租用机柜的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
            $own_business = DB::table('idc_cabinet')->where('cabinet_id', $order['machine_sn'])->value('own_business');
            if($own_business){
                $machine['own_business'] = $own_business.','.$order['business_sn'];
            } else {
                $machine['own_business'] = $order['business_sn'];
            }
            $machine['business_end'] = $order['end_time'];
            $machine['use_state']    = 1;
            $row                     = DB::table('idc_cabinet')->where('cabinet_id', $order['machine_sn'])->update($machine);
        }
        if ($row != 0) {
            // 订单生成成功且对应资源的业务编号及状态修改成功，事务进行提交处理
            DB::commit();
            $return['data'] = $order_sn;
            $return['code'] = 1;
            $return['msg']  = '审核成功,通知业务员及时联系客户进行支付,单号:' . $order_sn;
        } else {
            DB::rollBack();
            $return['data'] = '审核失败';
            $return['code'] = 0;
            $return['msg']  = '审核失败!!!!!';
        }
        return $return;
    }

    /**
     * 业务员手动对客户的业务进行启用状态，针对后付费客户群体
     * @param  [type] $enable [description]
     * @return [type]         [description]
     */
    public function enableBusiness($enable)
    {
        if ($enable) {
            $row = $this->where(['id'=>$enable['id']])->update($enable);
            if ($row != false) {
                $return['code'] = 1;
                $return['msg']  = '业务启用成功';
            } else {
                $return['code'] = 1;
                $return['msg']  = '业务启用失败';
            }
        } else {
            $return['code'] = 0;
            $return['msg']  = '无法启用该业务';
        }
        return $return;
    }


    /**
     * 业务员和管理员查看对应客户的业务数据
     * @param  array $show 客户的id即业务表的client_id字段
     * @return array        返回相关的数据和状态提示及信息
     */
    public function showBusiness($show)
    {
        if ($show) {
            $result = $this->where($show)->where('remove_status','<',4)->orderBy('created_at','desc')->get(['id', 'client_id', 'client_name', 'sales_id', 'sales_name', 'order_number', 'business_number', 'business_type', 'machine_number', 'resource_detail', 'business_status', 'money', 'length', 'start_time', 'endding_time', 'business_note']);
            if (!$result->isEmpty()) {
                $business_status = [-1 => '取消', -2 => '审核不通过', 0 => '审核中', 1 => '未付款使用', 2 => '付款使用中', 3 => '未付用', 4 => '锁定中', 5 => '到期', 6 => '退款'];
                $business_type   = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
                foreach ($result as $check => $check_value) {
                    $result[$check]['status'] = $business_status[$check_value['business_status']];
                    $result[$check]['type']   = $business_type[$check_value['business_type']];
                }
                $return['data'] = $result;
                $return['code'] = 1;
                $return['msg']  = '相关业务数据获取成功';
            } else {
                $return['data'] = '暂无业务数据';
                $return['code'] = 0;
                $return['msg']  = '暂无业务数据';
            }

            return $return;
        }
    }

    /**
     * 根据业务id删除业务数据
     * @param  [type] $delete_id [description]
     * @return [type]            [description]
     */
    public function deleteBusiness($delete_id)
    {
        //查找对应业务数据
        $deltet_data = $this->find($delete_id['delete_id']);
        if (!$deltet_data) {
            $return['code'] = 0;
            $return['msg']  = '无法删除对应数据!';
            return $return;
        }
        DB::beginTransaction();//开启事务处理DB::commit();DB::rollBack();
        if($deltet_data->business_status > 0){//当删除的业务数据为审核通过时，对对应资源进行释放操作
            switch ($deltet_data->business_type) {
            case 1:
                $updated['own_business'] = '';
                $updated['business_end'] = NULL;
                $updated['used_status'] = 0;
                $row = DB::table('idc_machine')->where(['machine_num'=>$deltet_data->machine_number,'own_business'=>$deltet_data->business_number])->update($updated);
                break;
            case 2:
                $updated['own_business'] = '';
                $updated['business_end'] = NULL;
                $updated['used_status'] = 0;
                $row = DB::table('idc_machine')->where(['machine_num'=>$deltet_data->machine_number,'own_business'=>$deltet_data->business_number])->update($updated);
                break;
            case 3:
                $cabinet = DB::table('idc_cabinet')->where(['cabinet_id'=>$deltet_data->machine_number])->select('own_business')->first();
                $array = explode(',',$cabinet->own_business);//先将原本的业务数据转换为数组
                $key = array_search($deltet_data->business_number,$array);//查找要删除的业务编号在数组的位置的键
                array_splice($array,$key,1);//根据查找的对应键进行删除
                $own_business = implode(',',$array);//将数组转换为字符串
                $row = DB::table('idc_cabinet')->where(['cabinet_id'=>$deltet_data->machine_number])->update(['own_business'=>$own_business]);
                break;
            }
            if($row == 0){
                DB::rollBack();
                $return['code'] = 0;
                $return['msg']  = '资源未释放,删除失败!';
                return $return;
            }
        }

        //查找业务关联订单
        $order_data = DB::table('tz_business')
            ->join('tz_orders', 'tz_business.business_number', '=', 'tz_orders.business_sn')
            ->where('tz_business.id', $delete_id['delete_id'])
            ->select('tz_orders.order_sn')
            ->get();
        //删除对应业务数据
        $result = DB::table('tz_business')->where('id', $delete_id['delete_id'])->update(['deleted_at'=>date('Y-m-d H:i:s')]);
        if ($result == 0) {
            DB::rollBack();
            $return['code'] = 0;
            $return['msg']  = '删除失败!';
            return $return;
        }
        DB::commit();
        //存在关联订单
        if ($order_data) {
            $return['msg'] = '删除数据成功,关联订单号为:';
            foreach ($order_data as $key => $value) {
                $return['msg'] = $return['msg'] . $value->order_sn . ',';
            }
            $return['msg'] = rtrim($return['msg'], ',');
        } else {
            // 无关联订单
            $return['msg'] = '删除数据成功';
        }
        $return['code'] = 1;
        return $return;
    }


    /**
     * 查找用户准备过期的业务
     * (过期前5天)
     *
     * endding_time:业务结束 时间
     * @author ZhanJun
     */
    public function selectOverdueBusiness()
    {
        //判断  时间区间
        $data = $this
            ->where([                              //选定条件
                'business_status' => 2,                         //业务状态为已审核
//            'client_id'       => $userId,                  //用户ID
            ])
            ->whereBetween('endding_time', [date('Y-m-d H:i:s'), date('Y-m-d H:i:s', strtotime("+5 day"))]) //条件 :  时间区间为  过期前5天  到过期当天
            ->get();

        return $data;

    }

}
