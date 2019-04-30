
@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')


    <div class="banner row">
        <div id="carousel-example-generic" data-interval="2000" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active">
                <span class="progress"></span>
            </li>
            <li data-target="#carousel-example-generic" data-slide-to="1">
                <span class="progress"></span>
            </li>
            <!-- <li data-target="#carousel-example-generic" data-slide-to="2">
                <span class="progress"></span>
            </li> -->
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <!-- <div class="item active">
                <a href="javascript:;" onclick="randomqq()" target="_blank">
                    <img src="{{ asset("/images/banner/gaofangIP.jpg") }}" alt="...">
                    <div class="carousel-caption">
                    </div>
                </a>
            </div> -->
            <!-- <div class="item active">
                <a href="/gaofangchuxiao" target="_blank">
                    <img src="{{ asset("/images/banner/gaofangBanner.jpg") }}" alt="...">
                    <div class="carousel-caption">
                    </div>
                </a>
            </div> -->
            <div class="item active">
                <a href="http://yun.zeisp.com/cloudbuy.html" target="_blank">
                    <img src="{{ asset("/images/banner/yun.jpg") }}" alt="...">
                    <div class="carousel-caption">
                    </div>
                </a>
            </div>
            <!-- <div class="item">
                <a href="/promotion/consumer" target="_blank">
                    <img src="{{ asset("/images/banner/consumer.png") }}" alt="...">
                    <div class="carousel-caption">
                    </div>
                </a>
            </div> -->
            <!-- <div class="item">
                <a href="/promotion/ddk" target="_blank">
                    <img src="{{ asset("/images/banner/ddk.jpg") }}" alt="...">
                    <div class="carousel-caption">
                    </div>
                </a>
            </div> -->
            <div class="item">
                <a href="http://yun.zeisp.com/cloudbuy.html" target="_blank">
                    <img src="{{ asset("/images/banner/xianyun.png") }}" alt="...">
                    <div class="carousel-caption">
                    </div>
                </a>
            </div>
            <!-- <div class="item">
                <a href="http://www.15cdn.com/" target="_blank">
                    <img src="{{ asset("/images/banner/kai.png") }}" alt="...">
                    <div class="carousel-caption">
                    </div>
                </a>
            </div> -->
        </div>

        <!-- Controls -->
        <!-- <a class="left carousel-control" href="javascript:;" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="javascript:;" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a> -->
        </div>
    </div>
    <div class="hot-products row">
        <div class="container clearfix">
            <div class="hot-products-item">
                <a href="/promotion/consumer">
                    <h3>安全防护</h3>
                    <p>抵御SYN、CC、DNS等 多种攻击，实现有效防护</p>
                    <span class="more"></span>
                </a>
            </div>
            <div class="hot-products-item">
                <a href="/page/tz/zytg">
                    <h3>服务器托管</h3>
                    <p>多线路组合，多城布点， 7×24的专人维护以及监控服务</p>
                    <span class="more"></span>
                </a>
            </div>
            <div class="hot-products-item">
                <a href="/page/tz/zygfzy">
                    <h3>服务器租用</h3>
                    <p>品牌服务器，根据行业特点、 客户规模量身打造租用方案</p>
                    <span class="more"></span>
                </a>
            </div>
            <div class="hot-products-item">
                <a href="/dist/highDefense.html">
                    <h3>智能高防IP</h3>
                    <p>隐藏真实源服务器IP，安全 稳定全程保驾护航源服务器</p>
                    <span class="more"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="service row">
        <div class="service-head">
            <div class="container">
                <h2>腾正科技一站式产品服务</h2>
                <p>关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</p>
            </div>
        </div>
        <div class="service-body">
            <div class="service-list container clearfix">
                <div class="row">
                    <div class="service-item col-md-4">
                        <div class="title">
                            <h3>IDC产品</h3>
                            <p>全球顶级数据中心基础服务</p>
                        </div>
                        <div class="body">
                            <div class="product-item">
                                <h4 class="product-item-title">
                                服务器租用
                                </h4>
                                <p class="product-item-description">
                                一站式帮您提供服务器硬件采购服务
                                </p>
                                <div class="product-item-option">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span class="option-btn small">华中</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">华南</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">华东</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">西北</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item">
                                <h4 class="product-item-title">
                                服务器托管
                                </h4>
                                <p class="product-item-description">
                                有效降低维护费用和机房设备投入
                                </p>
                                <div class="product-item-option">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span class="option-btn small">BGP</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">单 线</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">双 线</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">三 线</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item">
                                <h4 class="product-item-title">
                                机柜租用
                                </h4>
                                <p class="product-item-description">
                                安全可靠的机柜租用服务
                                </p>
                                <div class="product-item-option">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="option-btn large">42U&nbsp;&nbsp;&nbsp;&nbsp;100M</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item">
                                <h4 class="product-item-title">
                                带宽租用
                                </h4>
                                <p class="product-item-description">
                                带宽租用线路均由机房核心骨干直连接入
                                </p>
                                <div class="product-item-option">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span class="option-btn small">100M</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">500M</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">1G</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">10G</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item">
                                <h4 class="product-item-title">
                                高防服务器
                                </h4>
                                <p class="product-item-description">
                                G口接入,T级超大流量，抵御DDoS、CC攻击
                                </p>
                                <div class="product-item-option">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span class="option-btn small">100G</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">200G</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">300G</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="option-btn small">500G</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                     <div class="service-item col-md-4">
                        <div class="title">
                            <h3>腾正云</h3>
                            <p>智能计算，无限可能</p>
                        </div>
                        <div class="body">
                            <div class="mark yun">
                                <h3>
                                    <b>云主机</b>  - 入门型
                                </h3>
                                <div class="info">
                                    <p>适用于个人网站初始阶段并发访问量小，经济配置 省钱适用。</p>
                                    <div class="config">
                                        <span class="title">推荐配置： </span>
                                        <ul class="clearfix">
                                            <li>CPU：2核</li>
                                            <li>内存：2G</li>
                                            <li>硬盘：140G</li>
                                            <li>带宽：10M</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panic-buying">
                                    <div class="unit">
                                        <span class="price">139</span>/月
                                    </div>
                                    <a href="#">立即抢购</a>
                                    <div class="backtrack">
                                        <p>隐藏详细信息&nbsp;&nbsp;<span class="glyphicon glyphicon-menu-up"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item">
                                <h4 class="product-item-title">
                                云主机
                                </h4>
                                <p class="product-item-description">
                                存储、计算、监控、安全...您所需要的一切云产品， 腾正云服务器均能为您提供
                                </p>
                                <div class="product-item-option">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span class="option-btn full" data-attrs="[{attr: 'CPU',val: '2核'},{attr: '内存',val: '2G'},{attr: '硬盘',val: '140G'},{attr: '带宽',val: '10M'}]" data-url="http://yun.zeisp.com/" data-title="云主机" data-subtitle="入门型" data-price="139.00" data-dec="适用于个人网站初始阶段并发访问量小，经济配置省钱适用">入门型</span>
                                            <p class="tip">* 适用对象：小型企业官网或者个人站长</p>
                                        </div>
                                        <div class="col-md-12">
                                            <span class="option-btn full" data-attrs="[{attr: 'CPU',val: '4核'},{attr: '内存',val: '4G'},{attr: '硬盘',val: '240G'},{attr: '带宽',val: '20M'}]" data-url="http://yun.zeisp.com/" data-title="云主机" data-subtitle="进阶型" data-price="259.00" data-dec="适合流量适中的网站应用，或简单开发环境、代码存储库等">进阶型</span>
                                            <p class="tip">* 适用对象：地方与行业门户网站</p>
                                        </div>
                                        <div class="col-md-12">
                                            <span class="option-btn full" data-attrs="[{attr: 'CPU',val: '8核'},{attr: '内存',val: '8G'},{attr: '硬盘',val: '240G'},{attr: '带宽',val: '20M'}]" data-url="http://yun.zeisp.com/" data-title="云主机" data-subtitle="专业型" data-price="519.00" data-dec="计算能力满足90%云计算使用者需求，适合企业运营活动、并行计算应用、普通数据处理服务等">专业型</span>
                                            <p class="tip">* 适用对象：网上商城、团购网</p>
                                        </div>
                                        <div class="col-md-12">
                                            <span class="option-btn full" data-attrs="[{attr: 'CPU',val: '8核'},{attr: '内存',val: '16G'},{attr: '硬盘',val: '240G'},{attr: '带宽',val: '20M'}]" data-url="http://yun.zeisp.com/" data-title="云主机" data-subtitle="理想型" data-price="679.00" data-dec="适合对计算性能要求较高的应用场景，如企业运营活动、批量处理、分布式分析、游戏app等">理想型</span>
                                            <p class="tip">* 适用对象：社区SNS/论坛/ERP/OACRM、网络   游戏等其他高端服务</p>
                                        </div>
                                        <div class="col-md-12">
                                            <span class="option-btn full" data-attrs="[{attr: 'CPU',val: '8核'},{attr: '内存',val: '16G'},{attr: '硬盘',val: '240G'},{attr: '带宽',val: '20M'},{attr: '防护',val: '100G'}]" data-url="http://yun.zeisp.com/" data-title="云主机" data-subtitle="西安高防型" data-price="1079.00" data-dec="高可靠、高可用的服务：全自动检测和攻击策略匹配，实时防护，清洗服务可用性99.99%">西安高防型</span>
                                            <p class="tip">* 适用对象：金融、娱乐（游戏）、媒资、电商、政府等   网络安全攻击防护场景</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="service-item col-md-4">
                        <div class="title">
                            <h3>网络安全</h3>
                            <p>15CDN成就"互联网+企业"</p>
                        </div>
                        <div class="body">
                            <div class="mark safety">
                                <h3>
                                    <b>CDN加速</b> - 站长套餐
                                </h3>
                                <div class="info">
                                    <p>月度总流量：2TB</p>
                                    <p>域名数量：1个</p>
                                    <p>产品说明：供网页和小文件加速服务帮助客户提升网站的用户访问速度和服务的高可用性</p>
                                </div>
                                <div class="panic-buying">
                                    <div class="unit">
                                        <span class="price">100</span>/月
                                    </div>
                                    <a href="#">立即抢购</a>
                                    <div class="backtrack">
                                        <p>隐藏详细信息&nbsp;&nbsp;<span class="glyphicon glyphicon-menu-up"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item">
                                <h4 class="product-item-title">
                                CDN 加速
                                </h4>
                                <p class="product-item-description">
                                </p>
                                <div class="product-item-option">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="option-btn middle" data-attrs="[{attr: '月度总流量',val: '2TB'},{attr: '域名数量',val: '1个'}]" data-url="http://www.15cdn.com/" data-title="CDN 加速" data-subtitle="站长套餐" data-price="100" data-dec="供网页和小文件加速服务帮助客户提升网站的用户访问速度和服务的高可用性">站长套餐</span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="option-btn middle" data-attrs="[{attr: '月度总流量',val: '5TB'},{attr: '域名数量',val: '2个'}]" data-url="http://www.15cdn.com/" data-title="CDN 加速" data-subtitle="企业加速" data-price="500" data-dec="网页静态资源优化加速，全站HTTPS保证网站访问安全，适用于文学类站点、小型图片站等">企业加速</span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="option-btn middle" data-attrs="[{attr: '月度总流量',val: '10T'},{attr: '域名数量',val: '3个'}]" data-url="http://www.15cdn.com/" data-title="CDN 加速" data-subtitle="VIP加速" data-price="800" data-dec="图片、文件下载加速分发，多节点融合提高图片显示及用户下载速度，适用各类图库、下载站等">VIP加速</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item">
                                <h4 class="product-item-title">
                                防C盾
                                </h4>
                                <p class="product-item-description">
                                </p>
                                <p class="product-item-description">
                                </p>
                                <div class="product-item-option">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="option-btn middle" data-attrs="[{attr: '防护IP数',val: '20000/小时'},{attr: '防护峰值',val: '100G'},{attr: '域名数量',val: '3个'}]" data-url="http://www.15cdn.com/" data-title="防C盾" data-subtitle="专业版" data-price="999" data-dec="企业网站，论坛，小说站，游戏网站，电子商务平台等">专业版</span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="option-btn middle" data-attrs="[{attr: '防护IP数',val: '100000/小时'},{attr: '防护峰值',val: '150G'},{attr: '域名数量',val: '5个'}]" data-url="http://www.15cdn.com/" data-title="防C盾" data-subtitle="精英版" data-price="5000" data-dec="企业网站，论坛，小说站，游戏网站，电子商务平台等">精英版</span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="option-btn middle" data-attrs="[{attr: '防护IP数',val: '200000/小时'},{attr: '防护峰值',val: '200G'},{attr: '域名数量',val: '10个'}]" data-url="http://www.15cdn.com/" data-title="防C盾" data-subtitle="尊享版" data-price="10000" data-dec="企业网站，论坛，小说站，游戏网站，电子商务平台等">尊享版</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item">
                                <h4 class="product-item-title">
                                DDOS防护
                                </h4>
                                <p class="product-item-description">
                                金盾战略合作防火墙,全面各种防御超大流量DDoS 攻击
                                </p>
                                <div class="product-item-option">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="option-btn large" data-attrs="[]" data-url="http://www.15cdn.com/" data-title="DDOS防护" data-subtitle="TCP攻击" data-price="0" data-dec="配置腾正云高防IP，隐藏源站IP，接入腾正云新一代高防解决方案，防御TCP攻击效果更显著">TCP攻击</span>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="option-btn large" data-attrs="[]" data-url="http://www.15cdn.com/" data-title="DDOS防护" data-subtitle="UDP洪水攻击" data-price="0" data-dec="自主研发安全牵引系统防C盾有效防DDOS，SYN等多种类型攻击，无视CC，UDP攻击，确保用户业务安全，稳定运行">UDP洪水攻击</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item">
                                <h4 class="product-item-title">
                                高防IP
                                </h4>
                                <p class="product-item-description">
                                对不同攻击流量自动启用相应的防护策略，有效抵 御各种DDoS攻击
                                </p>
                                <div class="product-item-option">
                                    <div class="row">
                                        <div class="col-md-4 mt10">
                                            <span class="option-btn middle" data-disabled="false">50G</span>
                                        </div>
                                        <div class="col-md-4 mt10">
                                            <span class="option-btn middle" data-disabled="false">100G</span>
                                        </div>
                                        <div class="col-md-4 mt10">
                                            <span class="option-btn middle" data-disabled="false">200G</span>
                                        </div>
                                        <div class="col-md-4 mt10">
                                            <span class="option-btn middle" data-disabled="false">300G</span>
                                        </div>
                                        <div class="col-md-4 mt10">
                                            <span class="option-btn middle" data-disabled="false">1800G</span>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="advantage row">
        <h2>腾正机房的八大优势</h2>
        <p>业界先驱与创新典范，16000多客户实现业务全面需求见证</p>
        <div class="advantage-list">
            <div class="container">
                <div class="row">
                    <div class="advantage-item col-md-3">
                        <a href="javascript:;">
                            <div class="icon-container">
                                <span class="icon jiedian"></span>
                            </div>
                            <div class="title">
                                节点覆盖全国
                            </div>
                            <div class="dec">
                                网络节点覆盖全国，开通多省N*40G直联链路
                            </div>
                        </a>
                    </div>
                    <div class="advantage-item col-md-3">
                        <a href="javascript:;">
                            <div class="icon-container">
                                <span class="icon chukou"></span>
                            </div>
                            <div class="title">
                                总出口达10T
                            </div>
                            <div class="dec">
                                总出口规模达到10T，带宽资源充足，随时升级G口带宽
                            </div>
                        </a>
                    </div>
                    <div class="advantage-item col-md-3">
                        <a href="javascript:;">
                            <div class="icon-container">
                                <span class="icon fangyu"></span>
                            </div>
                            <div class="title">
                                集群超高防御
                            </div>
                            <div class="dec">
                                大带宽接入和超强防火墙集群，DDOS从此不再是噩梦
                            </div>
                        </a>
                    </div>
                    <div class="advantage-item col-md-3">
                        <a href="javascript:;">
                            <div class="icon-container">
                                <span class="icon jiankong"></span>
                            </div>
                            <div class="title">
                                多节点网络监控
                            </div>
                            <div class="dec">
                                多节点网络监控，随时查看服务器运行状态，故障秒级上报
                            </div>
                        </a>
                    </div>
                    <div class="advantage-item col-md-3 no-margin">
                        <a href="javascript:;">
                            <div class="icon-container">
                                <span class="icon tuandui"></span>
                            </div>
                            <div class="title">
                                成熟技术团队
                            </div>
                            <div class="dec">
                                拥有多年互联网安全技术研究经验的高级网络工程师和高级研发工程师团队
                            </div>
                        </a>
                    </div>
                    <div class="advantage-item col-md-3 no-margin">
                        <a href="javascript:;">
                            <div class="icon-container">
                                <span class="icon fanghu"></span>
                            </div>
                            <div class="title">
                                安全防护体系
                            </div>
                            <div class="dec">
                                全线采用自主研发安全牵引系统和数据安全防护体系，有效保护客户业务数据信息安全
                            </div>
                        </a>
                    </div>
                    <div class="advantage-item col-md-3 no-margin">
                        <a href="javascript:;">
                            <div class="icon-container">
                                <span class="icon dianli"></span>
                            </div>
                            <div class="title">
                                储备电力系统
                            </div>
                            <div class="dec">
                            双路供电，10kv高压柴油发电机组24h燃油储备，2n后备高频UPS供电系统电池备用＞2h
                            </div>
                        </a>
                    </div>
                    <div class="advantage-item col-md-3 no-margin">
                        <a href="javascript:;">
                            <div class="icon-container">
                                <span class="icon xiaofang"></span>
                            </div>
                            <div class="title">
                                星级消防系统
                            </div>
                            <div class="dec">
                                采用先进的有管网式气体消防系统，灭火介质 为FM200混合压缩气体
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="solution row">
        <div class="solution-head">
            <h2>
                解决方案
            </h2>
            <p>
                腾正科技根据不同的行业特性，提出针对有效的行业综合解决方案，帮助您更快的达成业务目标
            </p>
        </div>
        <div class="solution-list">
            <div class="container">
                <div class="solution-prev solution-page">

                </div>
                <div class="solution-next solution-page">

                </div>
                <div class="swiper-container solution-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide swiper-no-swiping">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="solution-item">
                                        <div class="solution-item-dec">
                                            <span class="icon"></span>
                                            <p>游戏解决方案</p>
                                        </div>
                                        <div class="solution-item-content">
                                            <h3>游戏解决方案</h3>
                                            <p>
                                            游戏行业前期通过渠道推广和口碑传播，用户数量增长比较快，需要不定期增加新的游戏服务器或者增加新的游戏大区。腾正科技成熟技术团队专业打造游戏云解决方案，利用自有机房游戏云专属服务器集群、云服务器弹性扩展、负载均衡功能等，完美决运行卡顿、掉线、攻击停服、玩家分析缺失、游戏直播接入困难等常见问题
                                            </p>
                                            <div class="solution-item-button">
                                                <a href="javascript:;">查看详情</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="solution-item">
                                        <div class="solution-item-dec">
                                            <span class="icon"></span>
                                            <p>棋牌解决方案</p>
                                        </div>

                                        <div class="solution-item-content">
                                            <h3>棋牌解决方案</h3>
                                            <p>
                                            棋牌游戏安不安全直接关乎运营商的直接利益，一旦出现游戏频繁遭受恶意攻击，频繁出现外挂这两种情况，不管游戏有多好玩，画面有多美，你的游戏都必死无疑。腾正科技利用高防御系统及云服务器弹性扩展和负载均衡功能，随时增减云服务器，增加缓存服务器、数据库I/O分离、轻松应对海量玩家同时在线和平台信息安全
                                            </p>
                                            <div class="solution-item-button">
                                                <a href="javascript:;">查看详情</a>
                                            </div>
                                         </div>
                                    </div>



                                </div>
                                <div class="col-md-3">
                                    <div class="solution-item">
                                        <div class="solution-item-dec">
                                            <span class="icon"></span>
                                            <p>金融解决方案</p>
                                        </div>
                                        <div class="solution-item-content">
                                            <h3>金融解决方案</h3>
                                            <p>
                                            金融行业网站对金融企业有着举足轻重的作用，攻击多，网页打开速度慢，用户体验下降等是目前金融行业网站的通病。腾正科技根据金融行业的业务特点，为P2P、小贷、典当、担保、众筹等小微金融企业提供个性化定制高防系列解决方案，解决金融行业互联互通、海量访问、数据安全等问题，同时降低企业投入及运维成本
                                            </p>
                                            <div class="solution-item-button">
                                                <a href="javascript:;">查看详情</a>
                                            </div>
                                         </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="solution-item">
                                        <div class="solution-item-dec">
                                            <span class="icon"></span>
                                            <p>流媒体解决方案</p>
                                        </div>
                                        <div class="solution-item-content">
                                            <h3>流媒体解决方案</h3>
                                            <p>
                                            流媒体已被广泛应用于互联网，包括新闻发布，在线直播，视频点播，网络电台，音乐下载等方面。腾正科技自主CDN加速1000+节点网络分发服务，为流媒体输出所需要的巨大数据流量和并发数据流提供了可承受强大的数据处理量的高性能服务器和畅通的网络环境，实现负载均衡、自动分配用户流量、服务器平滑扩展需求
                                            </p>
                                            <div class="solution-item-button">
                                                <a href="javascript:;">查看详情</a>
                                            </div>
                                         </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="swiper-slide swiper-no-swiping">

                            <div class="row">
                                <div class="col-md-3 swiper-index-2">
                                    <div class="solution-item">
                                        <div class="solution-item-dec">
                                            <span class="icon"></span>
                                            <p>移动APP解决方案</p>
                                        </div>
                                        <div class="solution-item-content">
                                            <h3>移动APP解决方案</h3>
                                            <p>
                                            随着无线网络和智能手机的快速普及，种类繁多的移动端应用层出不穷。移动开发者除了需要关注自身应用的逻辑，还需面临如何提升用户的访问速度，如何进行统计分析，如何解决域名劫持和调度不精准等难题。腾正科技推出以移动服务产品为基础的通用移动APP解决方案，旨在为开发者提供快速实现的移动应用基础服务
                                            </p>
                                            <div class="solution-item-button">
                                                <a href="javascript:;">查看详情</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 swiper-index-2">
                                    <div class="solution-item">
                                        <div class="solution-item-dec">
                                            <span class="icon"></span>
                                            <p>教育云解决方案</p>
                                        </div>
                                        <div class="solution-item-content">
                                            <h3>教育云解决方案</h3>
                                            <p>
                                            响应教育局以云计算技术推动东莞教育信息化高速发展的战略规划，吸取目前在建或已建各地教育信息化管理系统的优点，结合东莞市教育实际情况和特点，建设具东莞特点的教育云平台。平台以“统一的基础架构、统一的应用支撑、统一的数据标准、统一的技术架构”为设计原则，构建面向多个使用者的核心方案体系
                                            </p>
                                            <div class="solution-item-button">
                                                <a href="javascript:;">查看详情</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 swiper-index-2">
                                    <div class="solution-item">
                                        <div class="solution-item-dec">
                                            <span class="icon"></span>
                                            <p>政务云解决方案</p>
                                        </div>
                                        <div class="solution-item-content">
                                            <h3>政务云解决方案</h3>
                                            <p>
                                            随着东莞电子政务的快速发展，各单位将越来越多的服务器托管在市电子政务办公共机房内，机房承载能力接近基线。而如何解决系统利用率低，能源消耗高，各种电子政务系统相互隔离，系统间无法有效继承，系统的整体安全性能较差，系统缺乏有效的监管及自治机制等难题成为搭建政务云平台必须要解决的问题
                                            </p>
                                            <div class="solution-item-button">
                                                <a href="javascript:;">查看详情</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 swiper-index-2">
                                    <div class="solution-item">
                                        <div class="solution-item-dec">
                                            <span class="icon"></span>
                                            <p>网站部署方案</p>
                                        </div>
                                        <div class="solution-item-content">
                                            <h3>网站部署方案</h3>
                                            <p>
                                            1V1专席客服7*24小时从产品咨询、主机选型、环境部署、数据迁移、测试、监控、防御、售后运维等提供一条龙服务，帮助用户解决疑难杂症。更有VIP解决方案专家，为您复杂与特殊需求提供量身定制最佳实践方案，把传统的IDC数据中心改造成一个高度简化、标准化、自动化和弹性灵活的云数据中心，助您无忧上云！
                                            </p>
                                            <div class="solution-item-button">
                                                <a href="javascript:;">查看详情</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <div class="case row">
        <h2>客户案例</h2>
        <p>腾正科技本着“客户至上，务实创新”的服务理念，为全球互联网同行以及合作伙伴提供优质的产品和完善的服务</p>
        <div class="case-list">
            <div class="container">
                <div class="case-item clearfix">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="case-item clearfix">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="case-item clearfix">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
    <div class="news">
        <div class="news-head">
            <h2>新闻资讯</h2>
            <p>腾正科技为您提供最新行业资讯、活动公告、产品发布及最前沿最流行的云计算技术</p>
        </div>
        <div class="news-body">
            <div class="new-list clearfix">
                <div class="new-item">
                    <h3>公司新闻</h3>
                    <div class="preview">
                        <a href="/detail/company/{{ $company_news[0]->newsid }}">
                            <div class="type-info">
                                <h4>{{ mb_substr($company_news[0]->titles,0,15,'utf-8') }}</h4>
                                <p>{{ date("Y.m.d",strtotime($company_news[0]->createdate)) }}</p>
                                <span class="more-icon"></span>
                            </div>
                        </a>
                    </div>
                    <ul>
                        @foreach ($company_news as $i => $item)
                            @if ($i > 1 && $i < 6)
                                <li>
                                    <a href="/detail/company/{{ $item->newsid }}" class="title">{{ mb_substr($item->titles,0,15,'utf-8') }}</a>
                                    <a href="/detail/company/{{ $item->newsid }}" class="date">{{ date("Y.m.d",strtotime($item->createdate)) }}</a>
                                </li>
                            @endif
                        @endforeach
                        <!-- <li>
                            <a href="javascript:;" class="title">2019云计算中的6大热门词汇</a>
                            <a href="javascript:;" class="date">2019.01.21</a>
                        </li>
                        <li>
                            <a href="javascript:;" class="title">2019云计算中的6大热门词汇</a>
                            <a href="javascript:;" class="date">2019.01.21</a>
                        </li>
                        <li>
                            <a href="javascript:;" class="title">2019云计算中的6大热门词汇</a>
                            <a href="javascript:;" class="date">2019.01.21</a>
                        </li> -->
                    </ul>
                    <div class="new-item-btn">
                        <a href="/article/company">查看更多</a>
                    </div>
                </div>

                <div class="new-item">
                    <h3>公司公告</h3>
                    <div class="preview">
                        <a href="/detail/placard/{{ $company_announcement[0]->newsid }}">
                            <div class="type-info">
                                <h4>{{ mb_substr($company_announcement[0]->titles,0,15,'utf-8') }}</h4>
                                <p>{{ date("Y.m.d",strtotime($company_announcement[0]->createdate)) }}</p>
                                <span class="more-icon"></span>
                            </div>
                        </a>
                    </div>
                    <ul>
                        @foreach ($company_announcement as $i => $item)
                            @if ($i > 1 && $i < 6)
                                <li>
                                    <!-- {{ $item->titles }} -->
                                    <a href="/detail/placard/{{ $item->newsid }}" class="title">{{ mb_substr($item->titles,0,15,'utf-8') }}</a>
                                    <a href="/detail/placard/{{ $item->newsid }}" class="date">{{ date("Y.m.d",strtotime($item->createdate)) }}</a>
                                </li>
                            @endif
                        @endforeach
                        <!-- <li>
                            <a href="javascript:;" class="title">2019云计算中的6大热门词汇</a>
                            <a href="javascript:;" class="date">2019.01.21</a>
                        </li>
                        <li>
                            <a href="javascript:;" class="title">2019云计算中的6大热门词汇</a>
                            <a href="javascript:;" class="date">2019.01.21</a>
                        </li>
                        <li>
                            <a href="javascript:;" class="title">2019云计算中的6大热门词汇</a>
                            <a href="javascript:;" class="date">2019.01.21</a>
                        </li> -->
                    </ul>
                    <div class="new-item-btn">
                        <a href="/article/placard">查看更多</a>
                    </div>
                </div>

                <div class="new-item">
                    <h3>行业动态</h3>
                    <div class="preview">
                        <a href="/detail/industry/{{ $industry_news[0]->newsid }}">
                            <div class="type-info">
                                <h4>{{ mb_substr($industry_news[0]->titles,0,15,'utf-8') }}</h4>
                                <p>{{ date("Y.m.d",strtotime($industry_news[0]->createdate)) }}</p>
                                <span class="more-icon"></span>
                            </div>
                        </a>
                    </div>
                    <ul>
                        @foreach ($industry_news as $i => $item)
                            @if ($i > 1 && $i < 6)
                                <li>
                                    <a href="/detail/industry/{{ $item->newsid }}" class="title">{{ mb_substr($item->titles,0,15,'utf-8') }}</a>
                                    <a href="/detail/industry/{{ $item->newsid }}" class="date">{{ date("Y.m.d",strtotime($item->createdate)) }}</a>
                                </li>
                            @endif
                        @endforeach
                        <!-- <li>
                            <a href="javascript:;" class="title">2019云计算中的6大热门词汇</a>
                            <a href="javascript:;" class="date">2019.01.21</a>
                        </li>
                        <li>
                            <a href="javascript:;" class="title">2019云计算中的6大热门词汇</a>
                            <a href="javascript:;" class="date">2019.01.21</a>
                        </li>
                        <li>
                            <a href="javascript:;" class="title">2019云计算中的6大热门词汇</a>
                            <a href="javascript:;" class="date">2019.01.21</a>
                        </li> -->
                    </ul>
                    <div class="new-item-btn">
                        <a href="/article/industry">查看更多</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
