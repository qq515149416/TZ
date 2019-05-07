@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div id="tz-server-rent-content">
  <!-- banner -->
  <div class="banner">
    <div class="title" style="color: #fff;">
      <p class="text">服务器租用</p>
      <p class="sub-text">为您提供定制化硬件采购解决方案，满足您不同时期业务发展需求！</p>
    </div>
    <div class="bottom">
        <a class="btn-link {{ $page == 'dianxin' ? 'active' : '' }}" href="/zuyong/dianxin">电信服务器租用</a>
        <a class="btn-link {{ $page == 'liantong' ? 'active' : '' }}" href="/zuyong/liantong">联通服务器租用</a>
        <a class="btn-link {{ $page == 'shuangxian' ? 'active' : '' }}" href="/zuyong/shuangxian">双线服务器租用</a>
        <a class="btn-link {{ $page == 'sanxian' ? 'active' : '' }}" href="/zuyong/sanxian">三线服务器租用</a>
        <!-- <a class="btn-link {{ $page == 'bgp' ? 'active' : '' }}" href="/zuyong/bgp">BGP服务器租用</a> -->
    </div>
  </div>
  <!-- 热销产品 -->
  <div class="hot-product">
    <div class="title">
      <p class="text">热销产品</p>
      <p class="sub-text">超值特惠多种高性能组合套餐，您高性能应用场景的需求</p>
    </div>
    <div class="content">
      <img class="d-block" src="{{ asset("/images/serverRent/rectangle.png") }}">
      <div style="margin-top: 95px;">
        <div class="item">
          <div class="front">
            <img src="{{ asset("/images/serverRent/hzsx.png") }}" alt="惠州双线">
            <p class="desc">惠州双线 50G防御</p>
            <p class="price"><span style="font-size: 30px;">900</span> 元/月</p>
          </div>
          <div class="back">
            <div class="card">
              <div class="card-body">
                <p class="card-title">惠州双线 50G防御</p>
                <hr style="margin-top: 20px; margin-bottom: 30px;"/>
                <div class="card-text">
                  <p class="desc">
                    CPU：八核16线程 Xeon E5530 * 2
                    <br/>
                    内存：8G
                    <br/>
                    硬盘：300G SAS/1T SATA
                    <br/>
                    带宽：G口（20M独享）
                  </p>
                  <hr style="margin-top: 30px; margin-bottom: 30px;"/>
                  <p class="price">
                    <span style="font-size: 36px;font-weight: bold;">900</span> 元/月
                  </p>
                  <a class="detail-link" href="javascrpt: void(0);">了解详情</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="front">
            <img src="{{ asset("/images/serverRent/hysx.png") }}" alt="衡阳双线">
            <p class="desc">衡阳双线 40G防御</p>
            <p class="price"><span style="font-size: 30px;">900</span> 元/月</p>
          </div>
          <div class="back">
            <div class="card">
              <div class="card-body">
                <p class="card-title">衡阳双线 40G防御</p>
                <hr style="margin-top: 20px; margin-bottom: 30px;"/>
                <div class="card-text">
                  <p class="desc">
                    CPU：Xeon E5530 * 2/L5630 * 2
                    <br/>
                    内存：8G
                    <br/>
                    硬盘：1T SATA
                    <br/>
                    带宽：G口（20M独享）
                  </p>
                  <hr style="margin-top: 30px; margin-bottom: 30px;"/>
                  <p class="price">
                    <span style="font-size: 36px;font-weight: bold;">900</span> 元/月
                  </p>
                  <a class="detail-link" href="javascrpt: void(0);">了解详情</a>
                </div>
            </div>
        </div>
        <div class="item">
          <div class="front">
            <img src="{{ asset("/images/serverRent/gffwq.png") }}" alt="高防服务器">
            <p class="desc">高防320G抗D+无限CC</p>
            <p class="price"><span style="font-size: 30px;">3500</span> 元/月</p>
          </div>
          <div class="back">
            <div class="card">
              <div class="card-body">
                <p class="card-title">高防320G抗D+无限CC</p>
                <hr style="margin-top: 20px; margin-bottom: 30px;"/>
                <div class="card-text">
                  <p class="desc">
                    CPU：八核16线程 Xeon E5570 * 2
                    <br/>
                    内存：16G
                    <br/>
                    硬盘：240G（固态硬盘）
                    <br/>
                    带宽：G口（100M独享）
                  </p>
                  <hr style="margin-top: 30px; margin-bottom: 30px;"/>
                  <p class="price">
                    <span style="font-size: 36px;font-weight: bold;">3500</span> 元/月
                  </p>
                  <a class="detail-link" href="javascrpt: void(0);">了解详情</a>
                </div>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="front">
            <img src="{{ asset("/images/serverRent/hzdx.png") }}" alt="惠州电信">
            <p class="desc">惠州电信(100M活动促销)</p>
            <p class="price"><span style="font-size: 30px;">1299</span> 元/月</p>
          </div>
          <div class="back">
            <div class="card">
              <div class="card-body">
                <p class="card-title">惠州电信(100M活动促销)</p>
                <hr style="margin-top: 20px; margin-bottom: 30px;"/>
                <div class="card-text">
                  <p class="desc">
                    CPU：八核16线程 Xeon E5530 * 2
                    <br/>
                    内存：8G
                    <br/>
                    硬盘：300G SAS/1T SATA
                    <br/>
                    带宽：G口（100M独享）
                  </p>
                  <hr style="margin-top: 30px; margin-bottom: 30px;"/>
                  <p class="price">
                    <span style="font-size: 36px;font-weight: bold;">1299</span> 元/月
                  </p>
                  <a class="detail-link" href="javascrpt: void(0);">了解详情</a>
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
