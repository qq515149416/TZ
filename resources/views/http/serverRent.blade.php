@extends('layouts.layout')

@section('title', $tdk['title'])

@section('keywords', $tdk['keywords'])

@section('description', $tdk['description'])

@section('content')
<div id="tz-server-rent-content">
    <!-- banner -->
    <div class="banner {{ $page==='gaofang' ? 'gaofang' : ''  }}">
        @if ($page!=='gaofang')
        <div class="title" style="color: #fff;">
            <p class="text">{{ $productData['title'] }}</p>
            <p class="sub-text">{{ $productData['description'] }}</p>
        </div>
        @endif
        @if ($page!=='gaofang')
        <div class="bottom">
            <a class="btn-link {{ $page == 'dianxin' ? 'active' : '' }}" href="/zuyong/dianxin/hunan">电信服务器租用</a>
            <a class="btn-link {{ $page == 'liantong' ? 'active' : '' }}" href="/zuyong/liantong/hunan">联通服务器租用</a>
            <a class="btn-link {{ $page == 'shuangxian' ? 'active' : '' }}" href="/zuyong/shuangxian/hunan">双线服务器租用</a>
            <a class="btn-link {{ $page == 'sanxian' ? 'active' : '' }}" href="/zuyong/sanxian/hunan">三线服务器租用</a>
            <!-- <a class="btn-link {{ $page == 'bgp' ? 'active' : '' }}" href="/zuyong/bgp">BGP服务器租用</a> -->
        </div>
        @endif
    </div>
    <!-- 热销产品 -->
    <div class="hot-product">
        <div class="title">
            <p class="text">{{ $page==='gaofang' ? '高防服务器热销产品' : '热销产品'  }}</p>
            <p class="sub-text">超值特惠多种高性能组合套餐，满足您核心应用场景需求</p>
        </div>
        <div class="content">
            <img class="d-block" src="{{ asset("/images/serverRent/rectangle.png") }}">
            <div style="margin-top: 95px;">
                @foreach ($productData['data'] as $item)
                    <div class="item">
                        <div class="front">
                            <img src="{{ $page!=='gaofang' ? asset("/images/serverRent/hzsx.png") : asset("/images/serverRent/gffwq.png") }}" alt="惠州双线">
                            <p class="desc">
                                @if ($item['top'])
                                <span style="font-weight: bold;color: #f00;">[促销]</span>
                                @endif
                                {{ $item['name'] }}
                            </p>
                            <p class="price">
                            @if ($item['price']==='在线购买')
                            <span style="font-size: 30px;">在线购买</span>
                            @else
                            <span style="font-size: 30px;">{{ $item['price'] }}</span> 元/月
                            @endif
                            </p>
                        </div>
                        <div class="back">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title">
                                        @if ($item['top'])
                                        <span style="font-weight: bold;color: #f00;">[促销]</span>
                                        @endif
                                        {{ $item['name'] }}
                                    </p>
                                    <hr style="margin-top: 20px; margin-bottom: 30px;"/>
                                    <div class="card-text">
                                        <p class="desc">


                                            @if (array_key_exists('ddos',$item))
                                                DDOS防护：{{ $item['ddos'] }}
                                            @else
                                                CPU：{{ $item['cpu'] }}
                                                <br/>
                                                内存：{{ $item['ram'] }}
                                                <br/>
                                                硬盘：{{ $item['hardDisk'] }}
                                                <br/>
                                                带宽：{{ $item['bandwidth'] }}
                                                @if ($item['defense']!==0)
                                                <br/>
                                                防御：{{ $item['defense'] }}
                                                @endif
                                            @endif
                                        </p>
                                        <hr style="margin-top: 30px; margin-bottom: 30px;"/>
                                        <p class="price">
                                            @if ($item['price']==='在线购买')
                                            <span style="font-size: 36px;font-weight: bold;">在线购买</span>
                                            @else
                                            <span style="font-size: 36px;font-weight: bold;">{{ $item['price'] }}</span> 元/月
                                            @endif
                                        </p>
                                        <a class="detail-link" href="javascript: void(0);" onclick="randomqq()">了解详情</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- 产品优势 -->
    <div class="product-adv">
        <div class="title">
            <p class="text">产品优势</p>
            <p class="sub-text">多样化的产品，帮您实现更丰富的业务需求</p>
        </div>
        <div class="content">
            <div style="margin-top: 60px;">
                <div class="item" style="margin-right: 460px;">
                    <img src="{{ asset("/images/serverRent/high-safe-icon.png") }}" alt="高安全">
                    <div class="item-content">
                        <h5 class="title">高安全</h5>
                        <P class="desc">
                            高防御的网络架构，有效防御DDOS，<br/>
                            CC，UDP，SYN等多种类型的攻击，确保<br/>
                            用户网络安全稳定运营
                        </P>
                    </div>
                </div>
                <div class="item" style="margin-right: 10px;">
                    <img src="{{ asset("/images/serverRent/strong-perf-icon.png") }}" alt="强性能">
                    <div class="item-content">
                        <h5 class="title">强性能</h5>
                        <P class="desc">
                            采用海外高端品牌服务器，戴尔，惠普，<br/>
                            浪潮，实现用户数据的高效处理
                        </P>
                    </div>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <div class="item" style="margin-right: 472px;">
                    <img src="{{ asset("/images/serverRent/fast-icon.png") }}" alt="快速度">
                    <div class="item-content">
                        <h5 class="title">快速度</h5>
                        <P class="desc">
                            自建IDC数据中心，带宽资源充足，已形<br/>
                            成骨干网为节点的互联网网络架构，实<br/>
                            现用户快速流畅的访问体验
                        </P>
                    </div>
                </div>
                <div class="item" style="margin-right: 22px;">
                    <img src="{{ asset("/images/serverRent/quickly-response-icon.png") }}" alt="秒响应">
                    <div class="item-content">
                        <h5 class="title">秒响应</h5>
                        <P class="desc">
                            技术驻点机房7*24*365技术支持，全<br/>
                            年无休，贴心细致的售前咨询和及时的<br/>
                            售后服务，及时为客户排忧解难
                        </P>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 服务支持 -->
    <div class="service-support">
        <div class="title" style="color: #fff;">
            <p class="text">服务支持</p>
            <p class="sub-text">提供业内专业的技术支持</p>
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
            <p class="text">服务器租用常见问题</p>
            <p class="sub-text">关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</p>
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
        <div class="title" style="color: #fff; margin-bottom: 20px;">
            <p class="text">服务器租用-腾正科技IDC运营专家</p>
        </div>
        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
    </div>
</div>
@endsection
