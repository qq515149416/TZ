@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div class="tz-cabinet-rent" id="huizhou-cabinet">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">机柜租用</h2>
                <h5 class="sub-text">
                    自主机房，全网骨干网络接入，超过1T总宽带接入，提供安全可靠的机柜租用方案，<br/>
                    电信、联通、双线、三线、BPG共5种线路选择
                </h5>
            </div>
            <a class="apply-btn" href="javascript: void(0);">立即申请</a>
        </div>
        <div class="tab">
            <a class="tab-item active" href="/cabinetRent/huizhou">惠州机柜租用</a>
            <a class="tab-item" href="/cabinetRent/hengyang">衡阳机柜租用</a>
            <a class="tab-item" href="/cabinetRent/xian">西安机柜租用</a>
        </div>
    </div>
    <!--保障-->
    <div class="guarantee">
        <h2 class="title" style="color: #fff;">专业服务 六大保障</h2>
        <img class="d-block" src="{{ asset("/images/cabinetRent/white-rectangle.png") }}" />
        <div class="item-container">
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/huizhou/guarantee-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">安全服务</h5>
                    <p class="desc">
                        为客户提供攻击防御流量清洗、异地容灾备份、无缝移机服务、服务器状态监控服务，抵御黑客入侵及各种DDOS、CC、SYN、UPD等恶意攻击。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/huizhou/guarantee-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">软件服务</h5>
                    <p class="desc">
                        协助用户部署服务器系统环境，例如：WEB、RTP、DNS、MAIL、数据库、防火墙等，同时在用户授权的情况下，定期为用户坚持常用软件的运行情况和故障排查。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/huizhou/guarantee-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">技术支持</h5>
                    <p class="desc">
                        自主研发IDC自动化运维系统，为客户提供365&times;24小时运维技术支持，并设有VIP快速服务通道，能及时完善地处理任何故障，协助用户提交网站备案。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/huizhou/guarantee-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">硬件服务</h5>
                    <p class="desc">
                        提供7&times;24小时启动服务，协助用户进行服务器、电力及网络的部署，协助更换或添加服务器配件等。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/huizhou/guarantee-icon-5.png") }}" />
                <div class="text">
                    <h5 class="title">开源节流</h5>
                    <p class="desc">
                        与单独构建机房和租用专线上网相比，机柜租用降低了企业运营成本，提升了后期维护效率。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/huizhou/guarantee-icon-6.png") }}" />
                <div class="text">
                    <h5 class="title">灵活部署</h5>
                    <p class="desc">
                        自有机房，即开即用，随时可扩展网络托管设备，助您快速实现业务部署，抢占市场先机。
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--常见问题-->
    <div class="common-question">
        <h2 class="title">机柜租用常见问题</h2>
        <h5 class="sub-title">关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</h5>
        <div class="list-container">
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">什么是机柜租用？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用好吗？ </a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用怎么收费？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用哪个公司好？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
            </ul>
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">电信机柜租用多少钱一年？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用好吗？ </a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用怎么收费？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用哪个公司好？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
            </ul>
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用影响价格的因素有哪些？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用好吗？ </a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用怎么收费？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用哪个公司好？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
            </ul>
        </div>
    </div>
    <!--咨询-->
    <div class="consult">
        <h2 class="title">
            机柜大带宽租用，安全稳定、成本可控！
        </h2>
        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
    </div>
</div>
@endsection