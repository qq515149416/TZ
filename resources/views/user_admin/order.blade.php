@extends('layouts.user')

@section('title', '新用户后台')

@section('tab')
    <ul class="px-0 py-0 mx-0 my-0 top-nav d-none d-md-flex d-lg-flex justify-content-center flex-fill">
        <li class="mr-4">
            <a class="px-4 py-2 rounded font-medium" href="javascript:;">服务器</a>
        </li>
        <li>
            <a class="px-4 py-2 rounded active font-medium" href="javascript:;">订单</a>
        </li>
    </ul>
@endsection

@section('mobile_tab')
<ul class="px-0 py-0 mx-0 my-0 top-nav d-md-none d-lg-none d-flex flex-fill">
    <li class="flex-fill">
        <a class="px-4 py-3 font-medium" href="javascript:;">服务器</a>
    </li>
    <li class="flex-fill">
        <a class="px-4 py-3 active font-medium" href="javascript:;">订单</a>
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
                    <input type="password" class="form-control font-regular" id="orderDate" placeholder="下单开始时间 / 下单结束时间">
                </div>
                <div class="form-group mr-sm-3 mb-1 mt-3">
                    <input type="password" class="form-control font-regular" id="orderId" placeholder="请输入订单编号">
                </div>
                <button type="submit" class="btn btn-primary px-3 mb-1 mt-3 font-regular">搜索</button>
            </form>
        </div>
        <table 
        class="data font-heavy mt-3" 
        id="table_data" 
        data-pagination-loop="false" 
        data-page-size="5" 
        data-pagination="true" 
        data-toggle="table"
        data-click-to-select="true" 
        data-mobile-responsive="true"
        data-check-on-init="true"
        data-locale="zh-CN">
        <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th>订单编号</th>
                    <th>所属机房</th>
                    <th>订单类型</th>
                    <th>产品类型</th>
                    <th>产品名称</th>
                    <th>订单总价</th>
                    <th>下单时间</th>
                    <th>支付时间</th>
                    <th>支付状态</th>                           
                    <th>操作</th>
                </tr>
        </thead>
        <tbody class="font-regular">
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
        </tbody>
        </table>
    </div>
</div>

@endsection