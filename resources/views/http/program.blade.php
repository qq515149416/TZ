@extends('layouts.layout')

@section('title', '服务器租用，服务器托管，专业IDC服务商')

@section('content')
<div id="tz-program">
  <!-- banner -->
  <div class="banner">
    <div class="title" style="color: #fff;">
      <p class="text">游戏云解决方案</p>
      <p class="sub-text">
        成熟技术团队专业打造游戏云解决方案，帮助游戏客户完美解决运行卡顿、掉线、攻击停服、
        <br/>
        玩家分析缺失、游戏直播接入困难等常见问题
      </p>
    </div>
    <a class="apply-btn" href="javascript: void(0);">立即申请</a>
    <div class="btn-link">
      <a class="btn-link-item" href="javascript: void(0);">游戏</a>
      <a class="btn-link-item" href="javascript: void(0);">棋牌</a>
      <a class="btn-link-item" href="javascript: void(0);">金融</a>
      <a class="btn-link-item" href="javascript: void(0);">流媒体</a>
      <a class="btn-link-item" href="javascript: void(0);">移动APP</a>
      <a class="btn-link-item" href="javascript: void(0);">教育云</a>
      <a class="btn-link-item" href="javascript: void(0);">政务云</a>
      <a class="btn-link-item" href="javascript: void(0);">智慧城市</a>
    </div>
  </div>
  <div class="content">
    <div class="problem">
      <p class="title">游戏云面临的问题</p>
      <img class="d-block" src="{{ asset("/images/program/rectangle.png") }}">
      <div class="card-container">
        <div class="card">
          <div class="card-title">
            <img class="icon" src="{{ asset("/images/program/icon1.png") }}">
            <span class="text">计算性能不够，游戏卡顿？</span>
          </div>
          <div class="card-body">
            <ul>
              <li>百万级PPS的云服务器</li>
              <li>资源独享的专属机</li>
              <li>超高性能的物理机</li>
            </ul>
          </div>
        </div>
        <div class="card">
          <div class="card-title">
            <img class="icon" src="{{ asset("/images/program/icon2.png") }}">
            <span class="text">网络不稳定，玩家掉线？</span>
          </div>
          <div class="card-body">
            <ul>
              <li>资源优势10+线BGP网络</li>
              <li>万兆冗余内网，绝无单点</li>
              <li>高性能的外网共享带宽</li>
            </ul>
          </div>
        </div>
        <div class="card">
          <div class="card-title">
            <img class="icon" src="{{ asset("/images/program/icon3.png") }}">
            <span class="text">游戏大推，大量玩家访问？</span>
          </div>
          <div class="card-body">
            <ul>
              <li>20+万IOPS的高性能本地盘</li>
              <li>数万IOPS的高可靠云磁盘</li>
              <li>极致性能的缓存、数据库</li>
            </ul>
          </div>
        </div>
        <div class="card">
          <div class="card-title">
            <img class="icon" src="{{ asset("/images/program/icon4.png") }}">
            <span class="text">游戏安全，如何保障？</span>
          </div>
          <div class="card-body">
            <ul>
              <li>高防抗D服务</li>
              <li>HTTPS加密负载均衡</li>
              <li>VPN/专线安全数据传输</li>
            </ul>
          </div>
        </div>
        <div class="card">
          <div class="card-title">
            <img class="icon" src="{{ asset("/images/program/icon5.png") }}">
            <span class="text">游戏服，监控及故障恢复？</span>
          </div>
          <div class="card-body">
            <ul>
              <li>用户自定义报警</li>
              <li>云服务器秒级热迁移</li>
              <li>物理机宕机，游戏分钟级恢复</li>
            </ul>
          </div>
        </div>
        <div class="card">
          <div class="card-title">
            <img class="icon" src="{{ asset("/images/program/icon6.png") }}">
            <span class="text">计算性能不够，游戏卡顿？</span>
          </div>
          <div class="card-body">
            <ul>
              <li>百万级PPS的云服务器</li>
              <li>资源独享的专属机</li>
              <li>超高性能的物理机</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
