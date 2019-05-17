@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

    <div id="datacenter" class="row">
        <header class="banner">
            <div class="container">
                <h2>数据中心</h2>
                <p>自有机房，全网骨干网络接入，超过1T总宽带接入，电信、联通、双线、三线、BPG共5种线路选择立足于华南，依托丰富的网络资源和安全防护多元化业务发展</p>
                <a href="javascript:;">立即申请</a>
                <nav>
                    <ul>
                        <li>
                            <a class="{{ $page === 'huizhou' ? 'aticve' : '' }}" href="/datacenter/huizhou">
                                惠州数据中心
                            </a>
                        </li>
                        <li>
                            <a class="{{ $page === 'hengyang' ? 'aticve' : '' }}" href="/datacenter/hengyang">
                                衡阳数据中心
                            </a>
                        </li>
                        <li>
                            <a class="{{ $page === 'xian' ? 'aticve' : '' }}" href="/datacenter/xian">
                                西安数据中心
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <section class="main">
            <h3>惠州数据中心</h3>
            <div class="data clearfix">
                <div class="tz-thumbnail pull-left">
                    <div class="swiper-container" id="thumbnail">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ asset("/images/room/huizhou01.jpg") }}" alt="..." />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset("/images/room/huizhou01.jpg") }}" alt="..." />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset("/images/room/huizhou01.jpg") }}" alt="..." />
                            </div>
                        </div>
                        <!-- 如果需要分页器 -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="info pull-right">
                    <ul>
                        <li>
                            <span class="title">数据中心级别</span>
                            <span class="value">{!! $data['level'] !!}</span>
                        </li>
                        <li>
                            <span class="title">机房面积</span>
                            <span class="value">{{ $data['area'] }}</span>
                        </li>
                        <li>
                            <span class="title">机柜总数</span>
                            <span class="value">{{ $data['total'] }}</span>
                        </li>
                        <li>
                            <span class="title">出口总带宽</span>
                            <span class="value">{{ $data['bandwidth'] }}</span>
                        </li>
                        <li>
                            <span class="title">防火墙设备</span>
                            <span class="value">{{ $data['firewall'] }}</span>
                        </li>
                        <li>
                            <span class="title">电力设备</span>
                            <span class="value">{{ $data['power'] }}</span>
                        </li>
                        <li>
                            <span class="title">数据中心地址</span>
                            <span class="value">{{ $data['address'] }}</span>
                        </li>
                    </ul>
                    <nav>
                        <a href="javascript:;">下载机房信息</a>
                        <a href="javascript:;">租用</a>
                        <a href="javascript:;">机柜</a>
                        <a href="javascript:;">托管</a>
                        <a href="javascript:;">防御</a>
                        <a href="javascript:;">宽带</a>
                    </nav>
                </div>
            </div>
            <section class="quality">
                <h3>星级机房&nbsp;&nbsp;品质保障</h3>
                <ul class="clearfix">
                    <li>
                        <img src="{{ asset("/images/datacenter/quality_icon_01.png") }}" alt="" />
                        <h4>
                            电力供应
                        </h4>
                        <p>
                            双路市电输入，2个独立变电站，两路电源互为热备；供电路采用A/B路物理隔离安全模式，配置2N冗余热备份UPS供电系统，单路UPS系统配备15分钟蓄电池，保障电源不间断供应
                        </p>
                    </li>
                    <li>
                        <img src="{{ asset("/images/datacenter/quality_icon_02.png") }}" alt="" />
                        <h4>
                            无尘恒温设施
                        </h4>
                        <p>
                            恒温恒湿机房专用中央空调，实现恒温恒湿，保障机房温度：23±2度；机房湿度：45％～65％；机房防尘、除尘清洁，确保空气0.5nm的尘粒少于18000粒/升的无尘机房环境
                        </p>
                    </li>
                    <li class="last">
                        <img src="{{ asset("/images/datacenter/quality_icon_03.png") }}" alt="" />
                        <h4>
                            动环监控系统
                        </h4>
                        <p>
                            动力环境监控系统实现了对数据中心基础设施的集中监控和管理，如对冷水机组，冷冻水，冷却水设备的启停控制，手自动状态，运行状态机故障报警等进行监控，对供回水管路上的温度，压力进行检测，确保数据中心的正常运行
                        </p>
                    </li>
                    <li>
                        <img src="{{ asset("/images/datacenter/quality_icon_04.png") }}" alt="" />
                        <h4>
                            安全消防系统
                        </h4>
                        <p>
                            机房安装超20个高清摄像头对机房出入口、机房各机架等进行实时监视，7*24小时专人电视墙系统监控；进入大楼保安严密，严格执行进出登记制度；消防采用FM-200气体灭火系统配置烟火感应器，保证在火灾发生之前发出告警
                        </p>
                    </li>
                    <li>
                        <img src="{{ asset("/images/datacenter/quality_icon_05.png") }}" alt="" />
                        <h4>
                            三层安防系统
                        </h4>
                        <p>
                            数据中心安防系统分三层，一层布置红外入侵检测，防尾随门，360°全方位图像监控，并配有7*24小时保安值班；二层安检扫描系统，身份验证系统；三层分区指纹门禁系统和360°全方面图像监控系统，全方位保障数据安全
                        </p>
                    </li>
                    <li class="last">
                        <img src="{{ asset("/images/datacenter/quality_icon_06.png") }}" alt="" />
                        <h4>
                            防御追踪系统
                        </h4>
                        <p>
                            数据中心均配有木马查杀实时追踪，DDOS攻击实时追踪，全球网络攻击实时追踪，钓鱼网站实时追踪，全球网站漏洞实时追踪，APT攻击实时追踪系统，全面提升网络数据安全等级
                        </p>
                    </li>
                </ul>
                <section class="problem">
                    <h3>IDC常见问题</h3>
                    <p>关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</p>
                    <div class="problem-list clearfix">
                        <dl>
                            <dt class="clearfix">
                                <span class="pull-left">最新活动</span>
                                <a class="pull-right" href="#">查看更多>></a>
                            </dt>
                            <dd>
                                <a href="#">西安高防服务器限时抢购</a>
                            </dd>
                            <dd>
                                <a href="#">腾正云全新升级，免费体验通知</a>
                            </dd>
                            <dd>
                                <a href="#">腾正云价格调整公告</a>
                            </dd>
                            <dd>
                                <a href="#">腾正云免费体验 下单买一送一</a>
                            </dd>
                        </dl>
                        <dl>
                            <dt class="clearfix">
                                <span class="pull-left">产品帮助</span>
                                <a class="pull-right" href="#">查看更多>></a>
                            </dt>
                            <dd>
                                <a href="#">西安高防服务器限时抢购</a>
                            </dd>
                            <dd>
                                <a href="#">腾正云全新升级，免费体验通知</a>
                            </dd>
                            <dd>
                                <a href="#">腾正云价格调整公告</a>
                            </dd>
                            <dd>
                                <a href="#">腾正云免费体验 下单买一送一</a>
                            </dd>
                        </dl>
                        <dl>
                            <dt class="clearfix">
                                <span class="pull-left">备案指南</span>
                                <a class="pull-right" href="#">查看更多>></a>
                            </dt>
                            <dd>
                                <a href="#">西安高防服务器限时抢购</a>
                            </dd>
                            <dd>
                                <a href="#">腾正云全新升级，免费体验通知</a>
                            </dd>
                            <dd>
                                <a href="#">腾正云价格调整公告</a>
                            </dd>
                            <dd>
                                <a href="#">腾正云免费体验 下单买一送一</a>
                            </dd>
                        </dl>
                    </div>

                </section>
            </section>
        </section>
        <section class="jumbotron footer">
            <h4>业界先驱与创新典范，16000多客户实现业务全面需求见证</h4>
            <a href="javascript:;">立即咨询</a>
        </section>
    </div>

@endsection
