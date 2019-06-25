@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

<div id="overlayPackage">
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">防御流量叠加包</h2>
                <h5 class="sub-text">
                腾正高防推出防御流量叠加包（只限西安高防机房IP地址），IP是针对互联网应用服务在遭受大流量DDoS
                攻击后导致服务不可用的情况下，推出弹性的付费服务，用户可按天、按周、按月购买防御流量叠加包，将应用IP防御峰值叠加提升，确保源站的稳定可靠。
                </h5>
            </div>
            <!-- <a class="apply-btn" href="https://www.15cdn.com/">立即申请</a> -->
        </div>
        <div class="tab">
            <a class="tab-item" href="javascript:;">湖南衡阳机房 (敬请期待)</a>
            <a class="tab-item" href="javascript:;">广东惠州机房 (敬请期待)</a>
            <a class="tab-item active" href="javascript:;">陕西西安机房</a>
        </div>
    </div>
    <div class="main-content">
        <header class="title font-bold">
            DDoS 防御流量叠加包
        </header>
        <p class="sub-title font-medium">
            想您所需，做您所想，腾正高防御流量叠加包按需付费即开即用
        </p>
        <div class="data-table">
            <div class="table-tr">
                <div class="table-th font-medium">
                    名称
                </div>
                <div class="table-th font-medium">
                    天数
                </div>
                <div class="table-th font-medium">
                    价格
                </div>
                <div class="table-th font-medium">
                    购买
                </div>
            </div>
            @foreach ($overlay as $item)
            <div class="table-tr">
                <div class="table-th font-medium">
                    {{ $item->name }}
                </div>
                <div class="table-td font-medium">
                    {{ $item->validity_period }}天
                </div>
                <div class="table-td font-medium">
                    ￥{{ $item->price }}
                </div>
                <div class="table-td font-medium">
                    <a class="buy" data-toggle="modal" data-target="#buyOverlayPackage" data-id="{{ $item->id }}" data-price="{{ $item->price }}" data-time="{{ $item->validity_period }}" data-name="{{ $item->name }}" href="#">
                        立刻购买
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="feature">
        <header class="feature-title introduction-title font-heavy">
            DDoS 防御流量叠加包特点
        </header>
        <div class="feature-content">
            <div class="feature-container">
                <div class="list">
                    <div class="item">
                        <img src="{{ asset("/images/overlayPackage/feature_num_1.png") }}" />
                        <h5 class="font-heavy">高可用服务</h5>
                        <p class="font-regular">针对攻击流量自动启用相应防护策略，防御能力可达99.99%</p>
                    </div>
                    <div class="item">
                        <img src="{{ asset("/images/overlayPackage/feature_num_2.png") }}" />
                        <h5 class="font-heavy">超高性价比</h5>
                        <p class="font-regular">提供按天/周/月弹性付费模式，降低企业运维成本</p>
                    </div>
                </div>
                <div class="list">
                    <img src="{{ asset("/images/overlayPackage/feature_icon.png") }}" />
                </div>
                <div class="list">
                    <div class="item">
                        <img src="{{ asset("/images/overlayPackage/feature_num_3.png") }}" />
                        <h5 class="font-heavy">即开即用</h5>
                        <p class="font-regular">系统毫秒自动开通，无需人工介入，可重复购买</p>
                    </div>
                    <div class="item">
                        <img src="{{ asset("/images/overlayPackage/feature_num_4.png") }}" />
                        <h5 class="font-heavy">使用范围</h5>
                        <p class="font-regular">腾正防御流量叠加包，只限西安高防机房IP地址</p>
                    </div>
                </div>
            </div>
        </div>
    </div>




<!-- 叠加包购买 -->
<div class="modal fade" id="buyOverlayPackage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="buyOverlayPackageLabel">叠加包购买</h4>
      </div>
      <div class="modal-body">
        <div class="show-info">

        </div>
        <input type="number" id="buy_num" class="form-control" placeholder="购买数量">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary buy">购买</button>
      </div>
    </div>
  </div>
</div>


</div>

@endsection
