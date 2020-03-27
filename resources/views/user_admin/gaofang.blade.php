@extends('layouts.user')

@section('title', '新用户后台')

@section('content')

<div id="gaofang" class="container-fluid px-4">

    <div class="paper bg-white mt-4 py-3 px-4 rounded">
        <div class="server-tab">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs px-3 pb-4 pt-3" role="tablist">
                <li role="presentation" class="pr-3">
                    <a href="#all" class="px-3 py-2 font-medium active" data-filter="all" aria-controls="all" role="tab" data-toggle="tab">全&nbsp;部</a>
                </li>
                <li role="presentation" class="pr-3 mt-3 mt-md-0 mt-lg-0">
                    <a href="#xian" class="px-3 py-2 font-medium" data-filter="陕西西安" aria-controls="xian" role="tab" data-toggle="tab">西&nbsp;安</a>
                </li>
                <li role="presentation" class="pr-3">
                    <a href="#huizhou" class="px-3 py-2 font-medium disabled" data-filter="广东惠州" aria-controls="huizhou" role="tab" data-toggle="tab">惠&nbsp;州</a>
                </li>
                <li role="presentation" class="pr-3">
                    <a href="#hengyang" class="px-3 py-2 font-medium disabled" data-filter="湖南衡阳" aria-controls="hengyang" role="tab" data-toggle="tab">衡&nbsp;阳</a>
                </li>
            </ul>
        </div>
        <div class="filter d-flex justify-content-between align-items-end">
            <button type="button" class="btn btn-primary add-product">
            <svg class="bi bi-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 3.5a.5.5 0 01.5.5v4a.5.5 0 01-.5.5H4a.5.5 0 010-1h3.5V4a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M7.5 8a.5.5 0 01.5-.5h4a.5.5 0 010 1H8.5V12a.5.5 0 01-1 0V8z" clip-rule="evenodd"/>
            </svg>
            购买高防 IP
            </button>
            <form class="form-inline" autocomplete="off">
                <div class="form-group mb-1 mt-3 mr-sm-3">
                    <select class="form-control py-0" id="type">
                        <option>IP地址</option>
                        <option>业务状态</option>
                    </select>
                </div>
                <div class="form-group mr-sm-3 mb-1 mt-3">
                    <input type="text" class="form-control font-regular" id="orderId" placeholder="请输入IP精确查询">
                </div>
                <button type="submit" class="btn btn-primary px-3 mb-1 mt-3 ml-2 ml-md-0 ml-lg-0 font-regular">搜索</button>
            </form>
        </div>
        <table 
        class="data font-heavy mt-3" 
        id="table_data" 
        data-url="/home/defenseIp/getInfo"
        data-response-handler="process_data"
        data-pagination-loop="false" 
        data-page-size="10" 
        data-pagination="true" 
        data-pagination-detail-h-align="right"
        data-toggle="table"
        data-pagination-loop="false"
        data-mobile-responsive="true"
        data-check-on-init="true"
        data-row-style="rowStyle"
        data-locale="zh-CN">
        <thead>
                <tr>
                    <th data-field="business_number">业务编号</th>
                    <th data-field="machine_room_name">线路</th>
                    <th data-field="defense_ip">IP</th>
                    <th data-field="target_ip">目标IP</th>
                    <th data-field="protection_value">防御值</th>
                    <th data-field="price">单价</th>
                    <th data-field="status_cn">业务状态</th>
                    <th data-field="end_at">到期时间</th>                         
                    <th data-field="operat" data-formatter="operatFormatter">操作</th>
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