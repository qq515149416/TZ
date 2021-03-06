@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div id="overseas" class="row">
    <div class="banner">
        <div class="version-heart">
            <h3>海外服务器<span>| 全球服务器租用</span></h3>
            <div class="description">
                <ul>
                    <li>高品质标准：T级机房，接入国际骨干</li>
                    <li>多配置可选：配置丰富，多配置扩展</li>
                    <li>高性价比：性能＞价格，谁用谁知道</li>
                </ul>
            </div>
            <div class="bottom">
                @foreach ($son_nav as $nav)
                <a class="btn-link" href="{{ $nav->url }}">{{ $nav->name }}</a>
                @endforeach
                <!-- <a class="btn-link" href="javascript:;">欧洲服务器</a> -->
                <!-- <a class="btn-link" href="javascript:;">美洲服务器</a> -->
                <!-- <a class="btn-link" href="javascript:;">非洲服务器</a> -->

            </div>
        </div>
    </div>
    <!-- 热销产品 -->
    <div class="hot-product">
        <div class="title">
            <h2 class="text">热销产品</h2>
            <h5 class="sub-text">超值特惠多种高性能组合套餐，满足您核心应用场景需求</h5>
        </div>
        <div class="content">
            <div class="d-block-container version-heart">
                @foreach ($data->filter(function ($value, $key) {
                    return $value->more && array_key_exists('discount',$value->more) && $value->more['discount'];
                }) as $item)
                @if ($loop->index < 4)
                <!-- {{ $item->machine_room_id->name }} -->
                <div class="item">
                    <div class="card">
                        <div class="card-head">
                            <h4 class="card-title">
                                @if (count(explode('-',$item->machine_room_id->name)) > 1)
                                    {{ explode('-',$item->machine_room_id->name)[0] }}
                                @else
                                    {{ $item->machine_room_id->name }}
                                @endif
                                <span>下单即享<em>{{ $item->more['discount'] }}</em>折</span>
                            </h4>
                            <div class="price">
                                <div>
                                    <span class="amount">{{ (int)$item->price }}</span>
                                    <span class="unit">{{ $item->unit }}</span>
                                </div>
                                <div>
                                    <span class="original-price">
                                        (原价：<del>{{ (int)$item->more['original_price'] }}{{ $item->unit }}</del>)
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <ul class="desc">
                                    <li>
                                        <span>
                                            CPU：{{ $item->cpu }}
                                        </span>
                                        <span>
                                            型号：{{ $item->type }}
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            内存：{{ $item->ram }}
                                        </span>
                                        <span>
                                            硬盘类型：{{ $item->hard_disk_type }}
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            I P 数量：{{ $item->ips }}
                                        </span>
                                        <span>
                                            硬盘大小：{{ $item->hard_disk_size }}
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            线程：{{ $item->thread }}
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            支持硬件升级：{{ $item->upgrade  ? '支持':'不支持' }}
                                        </span>
                                    </li>
                                    <li class="clearfix">
                                        <p>
                                            带宽：

                                        </p>
                                        <p>
                                            @foreach (explode(',',$item->bandwidth) as $item_bandwidth)
                                                @if (count(explode('\\',$item_bandwidth)) > 1)
                                                · {{ explode('\\',$item_bandwidth)[0] }}<br />
                                                    {{ explode('\\',$item_bandwidth)[1] }}<br />
                                                @else
                                                · {{ $item_bandwidth }}<br />
                                                @endif
                                            @endforeach
                                        </p>
                                    </li>
                                </ul>
                                <a class="detail-link" href="javascript: void(0);">了解详情</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach


            </div>
        </div>
    </div>
    <!-- 产品优势 -->
    <div class="product-adv">
        <div class="title">
            <h2 class="text">产品优势</h2>
            <h5 class="sub-text">多样化的产品，帮您实现更丰富的业务需求</h5>
        </div>
        <div class="content">
            <div style="margin-top: 60px;">
                <div class="item" style="margin-right: 460px;">
                    <img src="{{ asset("/images/overseas/overseas_network_icon.png") }}" alt="网络保障">
                    <div class="item-content">
                        <h5 class="title">网络保障</h5>
                        <P class="desc">
                            采用双核心，全冗余架构，多线路骨干网<br />
                            接入具备充足带宽，网络畅通无阻。
                        </P>
                    </div>
                </div>
                <div class="item" style="margin-right: 10px;">
                    <img src="{{ asset("/images/overseas/overseas_safety_icon.png") }}" alt="安全保障">
                    <div class="item-content">
                        <h5 class="title">安全保障</h5>
                        <P class="desc">
                            国际高标准数据机房，安全可靠的存放<br/>
                            环境，7*24小时严格监控与准入证件审<br/>
                            查。
                        </P>
                    </div>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <div class="item" style="margin-right: 450px;">
                    <img src="{{ asset("/images/overseas/overseas_technology_icon.png") }}" alt="快速度">
                    <div class="item-content">
                        <h5 class="title">技术保障</h5>
                        <P class="desc">
                            服务器支持一键重启，实时流量监控机<br/>
                            房7*24认证工程师驻点技术支持，保障<br/>
                            机器稳定运行。
                        </P>
                    </div>
                </div>
                <div class="item" style="margin-left: 14px;">
                    <img src="{{ asset("/images/overseas/overseas_quality_icon.png") }}" alt="品质保障">
                    <div class="item-content">
                        <h5 class="title">品质保障</h5>
                        <P class="desc">
                            采用国际一线服务器戴尔、惠普、华为<br/>
                            等，提供高性能服务器，实现用户数据的<br/>
                            高效处理。
                        </P>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 服务支持 -->
    <div class="service-support">
        <div class="title">
            <h2 class="text" style="color: #fff;">服务支持</h2>
            <h5 class="sub-text" style="color: #bababa;">提供业内专业的技术支持</h5>
        </div>
        <div class="table-container container">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width: 15%;"></th>
                    <th scope="col" style="width: 36%;">增值服务项</th>
                    <th scope="col" style="width: 17%;">网络服务器</th>
                    <th scope="col" style="width: 17%;">服务时间</th>
                    <th scope="col" style="width: 15%;">服务价格</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th rowspan="3">IDC 技术支持</th>
                    <td>贴心服务，专人接待负责连接调试</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <tr>
                    <td>专业维护机制</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <tr>
                    <td>重启服务</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <!--******-->
                <tr>
                    <th rowspan="3">系统管理服务</th>
                    <td>系统优势</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <tr>
                    <td>免费CC防护</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <tr>
                    <td>免费故障排查处理</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <!--******-->
                <tr>
                    <th rowspan="3">IDC 技术支持</th>
                    <td>良好的机房设施，网络安全稳定</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <tr>
                    <td>电信骨干网接入，网络连通率高达99.99%</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <tr>
                    <td>专业互联网安全团队</td>
                    <td>是</td>
                    <td>5&times;8小时</td>
                    <td>免费</td>
                </tr>
                <!--******-->
                <tr>
                    <th rowspan="4">其他</th>
                    <td>免费网络流量报告</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <tr>
                    <td>全天候维护工程师团队</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <tr>
                    <td>监控管理</td>
                    <td>是</td>
                    <td>7&times;24小时</td>
                    <td>免费</td>
                </tr>
                <tr>
                    <td>良好的服务等级</td>
                    <td>是</td>
                    <td>5&times;8小时</td>
                    <td>免费</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 常见问题 -->
    <div class="common-question">
        <div class="title">
            <h2 class="text">服务器租用常见问题</h2>
            <h5 class="sub-text">关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</h5>
        </div>
        <div class="list-container">
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">网页游戏服务器租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="consult">
        <div class="title" style="margin-bottom: 20px;">
            <h2 class="text" style="color: #fff;">腾正海外服务器租用-帮您实现全球快速安全的资源部署</h2>
        </div>
        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
    </div>

</div>
@endsection
