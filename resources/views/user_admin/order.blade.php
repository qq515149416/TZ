@extends('layouts.user')

@section('title', '新用户后台')

@section('tab')
    <ul class="px-0 py-0 mx-0 my-0 top-nav d-none d-md-flex d-lg-flex justify-content-center flex-fill">
        <li class="mr-4">
            <a class="px-4 py-2 rounded font-medium" href="/user/server">服务器</a>
        </li>
        <li>
            <a class="px-4 py-2 rounded active font-medium" href="/user/order">订单</a>
        </li>
    </ul>
@endsection

@section('mobile_tab')
<ul class="px-0 py-0 mx-0 my-0 top-nav d-md-none d-lg-none d-flex flex-fill">
    <li class="flex-fill">
        <a class="px-4 py-3 font-medium" href="/user/server">服务器</a>
    </li>
    <li class="flex-fill">
        <a class="px-4 py-3 active font-medium" href="/user/order">订单</a>
    </li>
</ul>
@endsection

@section('content')

<div id="order" class="container-fluid px-4">
    <div class="paper bg-white mt-4 py-3 px-4 rounded">
        <div class="filter d-flex justify-content-end">
            <form class="form-inline">
                <div class="form-group mb-1 mt-3">
                    <input type="text" class="form-control font-regular" id="payDate" placeholder="支付开始时间 / 支付结束时间">
                </div>
                <div class="form-group mx-sm-3 mb-1 mt-3">
                    <input type="text" class="form-control font-regular" id="orderDate" placeholder="下单开始时间 / 下单结束时间">
                </div>
                <div class="form-group mr-sm-3 mb-1 mt-3">
                    <input type="text" class="form-control font-regular" id="orderId" placeholder="请输入订单编号">
                </div>
                <button type="submit" class="btn btn-primary px-3 mb-1 mt-3 ml-2 ml-md-0 ml-lg-0 font-regular">搜索</button>
            </form>
        </div>
        <table 
        class="data font-heavy mt-3" 
        id="table_data" 
        data-url="/home/customer/orderList"
        data-response-handler="process_data"
        data-pagination-loop="false" 
        data-page-size="10" 
        data-pagination="true" 
        data-toggle="table"
        data-click-to-select="true" 
        data-mobile-responsive="true"
        data-check-on-init="true"
        data-row-style="rowStyle"
        data-locale="zh-CN">
        <thead>
                <tr>
                    <th data-checkbox="true"></th>
                    <th data-field="order_sn">订单编号</th>
                    <th data-field="machineroom_name">所属机房</th>
                    <th data-field="order_type">订单类型</th>
                    <th data-field="resource_type">产品类型</th>
                    <th data-field="resource">产品名称</th>
                    <th data-field="payable_money">订单总价</th>
                    <th data-field="created_at">下单时间</th>
                    <th data-field="pay_time">支付时间</th>
                    <th data-field="order_status">支付状态</th>                           
                    <th data-field="operat" data-formatter="showFormatter">操作</th>
                </tr>
        </thead>
        <!-- <tbody class="font-regular">
            <tr>
                <td></td>
                <td>2019062738118577</td>
                <td>广东惠州</td>
                <td>购买</td>
                <td>服务器</td>
                <td>服务器-00000000000000</td>
                <td>￥145.00</td>
                <td>2019/01/01 00:00:00</td>
                <td>2020/01/01 00:00:00</td>
                <td>已支付</td>                         
                <td>
                    <span class="view" data-toggle="modal" data-target="#orderDetailModal">查看</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2019062738118577</td>
                <td>广东惠州</td>
                <td>购买</td>
                <td>服务器</td>
                <td>服务器-00000000000000</td>
                <td>￥145.00</td>
                <td>2019/01/01 00:00:00</td>
                <td>2020/01/01 00:00:00</td>
                <td>已支付</td>                         
                <td>
                    <span class="view">查看</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2019062738118577</td>
                <td>广东惠州</td>
                <td>购买</td>
                <td>服务器</td>
                <td>服务器-00000000000000</td>
                <td>￥145.00</td>
                <td>2019/01/01 00:00:00</td>
                <td>2020/01/01 00:00:00</td>
                <td>已支付</td>                         
                <td>
                    <span class="view">查看</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2019062738118577</td>
                <td>广东惠州</td>
                <td>购买</td>
                <td>服务器</td>
                <td>服务器-00000000000000</td>
                <td>￥145.00</td>
                <td>2019/01/01 00:00:00</td>
                <td>2020/01/01 00:00:00</td>
                <td>已支付</td>                         
                <td>
                    <span class="view">查看</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2019062738118577</td>
                <td>广东惠州</td>
                <td>购买</td>
                <td>服务器</td>
                <td>服务器-00000000000000</td>
                <td>￥145.00</td>
                <td>2019/01/01 00:00:00</td>
                <td>2020/01/01 00:00:00</td>
                <td>已支付</td>                         
                <td>
                    <span class="view">查看</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2019062738118577</td>
                <td>广东惠州</td>
                <td>购买</td>
                <td>服务器</td>
                <td>服务器-00000000000000</td>
                <td>￥145.00</td>
                <td>2019/01/01 00:00:00</td>
                <td>2020/01/01 00:00:00</td>
                <td>已支付</td>                         
                <td>
                    <span class="view">查看</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2019062738118577</td>
                <td>广东惠州</td>
                <td>购买</td>
                <td>服务器</td>
                <td>服务器-00000000000000</td>
                <td>￥145.00</td>
                <td>2019/01/01 00:00:00</td>
                <td>2020/01/01 00:00:00</td>
                <td>已支付</td>                         
                <td>
                    <span class="view">查看</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2019062738118577</td>
                <td>广东惠州</td>
                <td>购买</td>
                <td>服务器</td>
                <td>服务器-00000000000000</td>
                <td>￥145.00</td>
                <td>2019/01/01 00:00:00</td>
                <td>2020/01/01 00:00:00</td>
                <td>已支付</td>                         
                <td>
                    <span class="view">查看</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2019062738118577</td>
                <td>广东惠州</td>
                <td>购买</td>
                <td>服务器</td>
                <td>服务器-00000000000000</td>
                <td>￥145.00</td>
                <td>2019/01/01 00:00:00</td>
                <td>2020/01/01 00:00:00</td>
                <td>已支付</td>                         
                <td>
                    <span class="view">查看</span>
                </td>
            </tr>
        </tbody> -->
        </table>
    </div>
</div>

@endsection