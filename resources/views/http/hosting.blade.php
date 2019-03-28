@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div id="tz-server-hosting">
    <!-- banner -->
    <div class="banner">
        <div class="title" style="color: #fff;">
            <h2 class="text">服务器托管</h2>
            <h4 class="sub-text">您的托付，我们全力以赴！</h4>
        </div>
        <div class="bottom">
            <a class="btn-link" href="javascript: void(0);">衡阳服务器托管</a>
            <a class="btn-link" href="javascript: void(0);">惠州服务器托管</a>
            <a class="btn-link" href="javascript: void(0);">西安服务器托管</a>
            <a class="btn-link" href="javascript: void(0);">杭州服务器托管</a>
        </div>
    </div>
    <!-- 性能pk -->
    <div class="performance-pk">
        <div class="title" style="color: #333;">
            <h2 class="text">机房性能PK</h2>
            <h5 class="sub-text">高品质骨干机房，10000+家知名企业的选择见证</h5>
        </div>
        <div class="table-container container">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width: 10%;">项目</th>
                    <th scope="col" style="width: 45%;">腾正机房</th>
                    <th scope="col" style="width: 45%;">其他非专业机房</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th rowspan="2">机柜</th>
                    <td>42U机柜</td>
                    <td>42U机柜</td>
                </tr>
                <tr>
                    <td>只允许放18U设备，确保服务器散热</td>
                    <td>为了节省成本，不考虑高温对服务器的影响超U填放</td>
                </tr>
                <!--******-->
                <tr>
                    <th>恒温</th>
                    <td>冷热分离，确保服务器最佳运行温度22℃±2℃</td>
                    <td>大型中央空调，服务器温度无法保证恒温</td>
                </tr>
                <!--******-->
                <tr>
                    <th>带宽</th>
                    <td>总出口规模达到10T，带宽资源充足，随时升级G口带宽</td>
                    <td>网络出口小，访问速度和后期扩展得不到保障</td>
                </tr>
                <!--******-->
                <tr>
                    <th>防御</th>
                    <td>金盾最新防火墙+独立防CC防火墙，专业抵御DDOS、CC、WAF攻击</td>
                    <td>普通防火墙，易被各种DDoS攻击和黑蛇入侵</td>
                </tr>
                <!--******-->
                <tr>
                    <th>能效</th>
                    <td>T3+数据中心的能效：PUE≤1.36</td>
                    <td>普通数据中心的能耗：PUE≥1.50</td>
                </tr>
                <!--******-->
                <tr>
                    <th>配电</th>
                    <td>双路供电（不同电站送电）+柴油发电机组+UPS模块组</td>
                    <td>单路供电，柴油发电机和UPS不支持1备1</td>
                </tr>
                <!--******-->
                <tr>
                    <th>故障率</th>
                    <td>可用性99.99%，机房设施年平均故障时间52.56分钟</td>
                    <td>可用性<98%、年平均故障时间大于17小时</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- 服务支持pk -->
    <div class="service-pk">
        <div class="title" style="color: #fff;">
            <h2 class="text">服务支持PK</h2>
            <h5 class="sub-text">专业服务，安心托管</h5>
        </div>
        <div class="table-container container">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width: 15%;">项目</th>
                    <th scope="col" style="width: 45%;">腾正服务器托管</th>
                    <th scope="col" style="width: 45%;">其他公司服务器托管</th>
                </tr>
                </thead>
                <tbody>
                <!--******-->
                <tr>
                    <th>上架</th>
                    <td>免费上架安装</td>
                    <td>免费上架安装</td>
                </tr>
                <!--******-->
                <tr>
                    <th>系统安装</th>
                    <td>首次免费安装系统</td>
                    <td>首次免费安装系统</td>
                </tr>
                <!--******-->
                <tr>
                    <th rowspan="2">合作方式</th>
                    <td>可租用设备、机位、带宽、IP，可年付也可以月付</td>
                    <td>只是年托或是月托服务</td>
                </tr>
                <tr>
                    <td>没有技术还可以选择代维服务</td>
                    <td>没有技术还可以选择代维服务</td>
                </tr>
                <!--******-->
                <tr>
                    <th>防御支持</th>
                    <td>单独CC防火墙，免费CC防护</td>
                    <td>无独立的CC防御系统，或有也需要付费购买</td>
                </tr>
                <!--******-->
                <tr>
                    <th rowspan="3">技术支持</th>
                    <td>自有机房，每个机房配备3—6名工程师时刻待命</td>
                    <td>非自有机房，服务需要中转，甚至找不到人</td>
                </tr>
                <tr>
                    <td>硬件故障可提供备用服务器</td>
                    <td>无法保证实时响应，或是有响应，无法处理问题</td>
                </tr>
                <tr>
                    <td>7&times;24小时电话、QQ、手机端工单系统技术支持</td>
                    <td>无法保证实时响应，或是有响应，无法处理问题</td>
                </tr>
                <!--******-->
                <tr>
                    <th>资质支持</th>
                    <td>跨地区ISP\IDC资质支持，备案以及经营性备案全部支持</td>
                    <td>非自有资质或是资质受区域限制，无法提供有力支撑</td>
                </tr>
                <!--******-->
                <tr>
                    <th>解决方案</th>
                    <td>专业、高效量身定制托管服务方案</td>
                    <td>非一手品质运营资源，沟通易脱节，无法保障方案可行性</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- 托管流程 -->
    <div class="deposit-process">
        <div class="title" style="color: #333;">
            <h2 class="text">托管流程</h2>
            <h5 class="sub-text">专业服务器托管服务商，网络出口够大，后期扩展更有保障</h5>
            <div style="height: 320px;">
                <img src="{{ asset("/images/hosting/deposit-process.png") }}" alt="托管流程图">
            </div>
        </div>
    </div>
    <!-- 常见问题 -->
    <div class="common-question">
        <div class="title">
            <h2 class="text">服务器托管常见问题</h2>
            <h5 class="sub-text">关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</h5>
        </div>
        <div class="list-container">
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);"><span>什么是服务器托管？</span></a>
                    <span class="date">2019.01.21</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- 立即咨询 -->
    <div class="consult">
        <div class="title">
            <h2 class="text">服务器托管-腾正科技IDC运营专家</h2>
        </div>
        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
    </div>
</div>
@endsection
