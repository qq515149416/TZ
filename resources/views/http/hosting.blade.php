@extends('layouts.layout')

@section('title', $tdk['title'])

@section('keywords', $tdk['keywords'])

@section('description', $tdk['description'])

@section('content')
<div id="tz-server-hosting">
    <!-- banner -->
    <div class="banner">
        <div class="title">
            <h2 class="text">服务器托管</h2>
            <h4 class="sub-text">
                摆脱虚拟主机受软硬件资源的限制，提供高性能的数据中心设备，线路租用和网络带宽，减少企业建设数据中心<br/>
                布设通讯线路等高额费用。您的托付，我们全力以赴!
            </h4>
        </div>
        <div class="collapse-tab">
            <a class="collapse-tab-item heng-yang {{ $page === 'hengyang' ? 'active' : '' }}" href="/tuoguan/hengyang">衡阳服务器托管</a>
            <a class="collapse-tab-item hui-zhou {{ $page === 'huizhou' ? 'active' : '' }}" href="/tuoguan/huizhou">惠州服务器托管</a>
            <a class="collapse-tab-item xi-an {{ $page === 'xian' ? 'active' : '' }}" href="/tuoguan/xian">西安服务器托管</a>
            <!-- <a class="collapse-tab-item hang-zhou" href="#hangzhou" data-toggle="collapse"
               data-target="#hang-zhou"
               aria-expanded="false" aria-controls="hang-zhou">杭州服务器托管</a> -->
        </div>
    </div>
    <!-- 展开部分 -->
    <div class="expand-area">
        <div class="expand-item">
            <h1 class="expand-item-title">{{$data["name"]}}</h1>
            <hr style="height: 1px; background-color: #333; margin-bottom: 10px;"/>
            <p class="expand-item-desc">
                机房概况：{{$data["overview"]}}</p>
            <p class="expand-item-desc">
                机房等级：{{$data["grade"]}}
                <br/>
                <a href="{{$data['detail_url']}}" class="scene-btn">查看机房实景</a>
            </p>
            <p class="expand-item-desc">典型客户：{{$data['customer_representative']}}</p>
            <div class="table-container">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" style="width: calc(100% / 9);">线路</th>
                        <th scope="col" style="width: calc(100% / 9);">规格</th>
                        <th scope="col" style="width: calc(100% / 9);">电流</th>
                        <th scope="col" style="width: calc(100% / 9);">带宽</th>
                        <th scope="col" style="width: calc(100% / 9);">IP数</th>
                        <th scope="col" style="width: calc(100% / 9);">防御</th>
                        <th scope="col" style="width: calc(100% / 9);">月付</th>
                        <th scope="col" style="width: calc(100% / 9);">年付</th>
                        <th scope="col" style="width: calc(100% / 9);">购买</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--******-->
                    @foreach ($data['data'] as $item)
                    <tr>
                        <th>{{ $item['line'] }}</th>
                        <td>{{ $item['specification'] }}</td>
                        <td>{{ $item['current'] }}</td>
                        <td>{{ $item['bandwidth'] }}</td>
                        <td>{{ $item['ip'] }}</td>
                        <td>{{ $item['defense'] }}</td>
                        <td>{{ $item['monthly_payment'] }}</td>
                        <td>{{ $item['annual_fee'] }}</td>
                        <td>
                            <a href="{{ $item['buy'] }}" class="purchase-btn">立即购买</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- <div class="expand-item collapse" id="hang-zhou">
        </div> -->
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
        <div class="title">
            <h2 class="text" style="color: #fff;">服务支持PK</h2>
            <h5 class="sub-text" style="color: #bababa;">专业服务，安心托管</h5>
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
                <!--******-->
                <tr>
                    <th>付款方式</th>
                    <td>服务器上架成功后再付款</td>
                    <td>先付款，后上架</td>
                </tr>
                <!--******-->
                <tr>
                    <th>核心优势</th>
                    <td>精选高品质机房，连通率99.99%，60秒人工服务响应</td>
                    <td>价格</td>
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
            <img src="{{ asset("/images/hosting/deposit-process.png") }}" alt="托管流程图">
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
                    <a class="text" href="javascript: void(0);">什么是服务器托管？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">服务器托管有哪些好处？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">服务器托管的U是什么意思？</a>
                    <a class="date" href="javascript: void(0);">2019.01.19</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">服务器托管BGP机房是什么意思？</a>
                    <a class="date" href="javascript: void(0);">2019.01.18</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">腾正科技的服务器托管怎么样？</a>
                    <a class="date" href="javascript: void(0);">2019.01.17</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">托管一台服务器多少钱？</a>
                    <a class="date" href="javascript: void(0);">2019.01.14</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">托管一台服务器多少钱？</a>
                    <a class="date" href="javascript: void(0);">2019.01.14</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">托管一台服务器多少钱？</a>
                    <a class="date" href="javascript: void(0);">2019.01.14</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">托管一台服务器多少钱？</a>
                    <a class="date" href="javascript: void(0);">2019.01.14</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">托管一台服务器多少钱？</a>
                    <a class="date" href="javascript: void(0);">2019.01.14</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">托管一台服务器多少钱？</a>
                    <a class="date" href="javascript: void(0);">2019.01.14</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">托管一台服务器多少钱？</a>
                    <a class="date" href="javascript: void(0);">2019.01.14</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">托管一台服务器多少钱？</a>
                    <a class="date" href="javascript: void(0);">2019.01.14</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">托管一台服务器多少钱？</a>
                    <a class="date" href="javascript: void(0);">2019.01.14</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">托管一台服务器多少钱？</a>
                    <a class="date" href="javascript: void(0);">2019.01.14</a>
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
