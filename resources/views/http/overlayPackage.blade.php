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

    <div class="function">
        <header class="introduction-title font-heavy">
            DDoS 防御流量叠加包功能
        </header>
        <ul class="function-list">
            <li class="clearfix">
                <div class="pull-left">
                    <img src="{{ asset("/images/overlayPackage/function_icon_3.png") }}" />
                </div>
                <div class="pull-right">
                    <h5>防御弹性扩展</h5>
                    <p>按不同业务及发展需求按天、按周、按月即买即用，防护阈值可随时弹性调整，在整个调整过程中服务无中断。</p>
                </div>
            </li>
            <li class="clearfix">
                <div class="pull-left">
                    <img src="{{ asset("/images/overlayPackage/function_icon_1.png") }}" />
                </div>
                <div class="pull-right">
                    <h5>自动全面防护</h5>
                    <p>根据攻击的流量和连接数阀值来自动触发攻击防护，对威胁进行阻断过滤，确保源站稳定安全&业务正常运行。</p>
                </div>
            </li>
            <li class="clearfix">
                <div class="pull-left">
                    <img src="{{ asset("/images/overlayPackage/function_icon_2.png") }}" />
                </div>
                <div class="pull-right">
                    <h5>支持不同业务</h5>
                    <p>支持网站和非网站业务，如各类大型游戏、支付金融平台、流媒体、政企等各类易受攻击且需高防御业务行业。</p>
                </div>
            </li>
            <li class="clearfix">
                <div class="pull-left">
                    <img src="{{ asset("/images/overlayPackage/function_icon_4.png") }}" />
                </div>
                <div class="pull-right">
                    <h5>全景数据分析</h5>
                    <p>提供多纬度实时统计报表，如流量报表、DDoS和CC防护清洗报表、流量图等，让您及时获得当前服务详情。</p>
                </div>
            </li>
        </ul>
    </div>

    <div class="scenes">
        <header class="introduction-title font-heavy">
            应用场景
        </header>
        <ul class="scenes-list">
            <li>
                <h5 class="font-heavy">
                    网站类业务
                </h5>
                <span class="font-medium">适用行业：金融、电商、企业门户类网站</span>
                <p class="font-medium">网站类业务是最容易受到攻击的，因为黑客可通过DNS解析轻松获取网站服务器的真实IP，然后对服务器IP进行大流量ddos/cc攻击，导致网站访问缓慢或直接瘫痪。</p>
            </li>
            <li>
                <h5 class="font-heavy">
                    游戏类业务
                </h5>
                <span class="font-medium">适用行业：各类型端游、手游等网络游戏产品，各类型应用程序产品</span>
                <p class="font-medium">游戏类是攻击最严重的行业，同行恶意竞争者通过各种攻击手段，让大批量游戏玩家频繁掉线，玩游戏卡顿，攻击停服，甚至无法登陆接入游戏，最终让大批玩家流失。</p>
            </li>
        </ul>
    </div>
    <div class="help">
        <header class="introduction-title font-heavy">
            DDoS防御流量叠加包使用图解
        </header>
        <div class="help-content">

        </div>
    </div>

    <div class="consult">
        <div class="title" style="margin-bottom: 20px;">
            <h2 class="text" style="color: #fff;">腾正高防专家，在岗 1 分钟，安全 60 秒</h2>
        </div>
        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
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
