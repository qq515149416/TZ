@extends('layouts.layout')

@section('title', '西安带宽租用-独享带宽租用-大带宽租用-服务器带宽价格[腾正科技]')

@section('keywords', '西安带宽租用，独享带宽租用，大带宽租用，服务器带宽价格，G口带宽租用')

@section('description', '腾正自主西安T3+级机房，T级集群防火墙，高质量G口、万兆大带宽资源接入，提供安全可靠价格优惠的百M、千兆、万兆、G口大带宽租用及独享带宽租用服务，咨询热线0769-22226555')

@section('content')
<div class="tz-bandwidth-rent" id="xian-bandwidth">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">大带宽租用</h2>
                <h5 class="sub-text">
                    五大机房大带宽资源保证 · 安全可靠的大带宽租用服务 · 高质量G口、万兆大带宽资源接入
                </h5>
            </div>
            <a class="apply-btn" href="javascript: void(0);">立即申请</a>
        </div>
        <div class="tab">
            <a class="tab-item" href="/bandwidth-rent/huizhou">惠州带宽租用</a>
            <a class="tab-item" href="/bandwidth-rent/hengyang">衡阳带宽租用</a>
            <a class="tab-item active" href="/bandwidth-rent/xian">西安带宽租用</a>
        </div>
    </div>
    <!--机房-->
    <div class="machine-room">
        <h2 class="title black">陕西西安机房</h2>
        <div class="intro">
            <div id="carousel-album" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-album" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-album" data-slide-to="1"></li>
                    <li data-target="#carousel-album" data-slide-to="2"></li>
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="{{ asset("/images/bandwidthRent/xian/room-photo-1.jpg") }}" alt="陕西西安机房照片1"/>
                        <div class="mask"></div>
                    </div>
                    <div class="item">
                        <img src="{{ asset("/images/bandwidthRent/xian/room-photo-2.jpg") }}" alt="陕西西安机房照片2"/>
                        <div class="mask"></div>
                    </div>
                    <div class="item">
                        <img src="{{ asset("/images/bandwidthRent/xian/room-photo-3.jpg") }}" alt="陕西西安机房照片3"/>
                        <div class="mask"></div>
                    </div>
                </div>
            </div>
            <div class="desc">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td style="width: 190px;">数据中心级别</td>
                        <td>准<span style="font-family: 'pingFangHeavy'; color: #f00101;"> T4 </span>级机房</td>
                    </tr>
                    <tr>
                        <td>机房面积</td>
                        <td>53851平方米</td>
                    </tr>
                    <tr>
                        <td>机柜总数</td>
                        <td>5000个，42U国际标准机柜</td>
                    </tr>
                    <tr>
                        <td>出口总带宽</td>
                        <td>10T，直连互联网骨干点</td>
                    </tr>
                    <tr>
                        <td>防火墙设备</td>
                        <td>T级集群防火墙</td>
                    </tr>
                    <tr>
                        <td>电力设备</td>
                        <td>从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统</td>
                    </tr>
                    <tr>
                        <td>数据中心地址</td>
                        <td>陕西省西咸新区沣西新城</td>
                    </tr>
                    </tbody>
                </table>
                <div class="btn-container">
                    <a class="button" href="javascript: void(0);">查看详情</a>
                    <a class="button" href="javascript: void(0);">在线咨询</a>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col" style="width: calc(100% / 7);">数据中心</th>
                <th scope="col" style="width: calc(100% / 7);">线路</th>
                <th scope="col" style="width: calc(100% / 7);">带宽</th>
                <th scope="col" style="width: calc(100% / 7);">月付</th>
                <th scope="col" style="width: calc(100% / 7);">年付</th>
                <th scope="col" style="width: calc(100% / 7.88);">购买</th>
            </tr>
            </thead>
            <tbody>
            <!--******-->
            <tr>
                <th>西安数据中心</th>
                <td>电信</td>
                <td>100M</td>
                <td>2400元/月</td>
                <td>-</td>
                <td>
                    <a href="javascript: void(0);" class="purchase-btn">立即购买</a>
                </td>
            </tr>
            <!--******-->
            <tr>
                <th>西安数据中心</th>
                <td>电信</td>
                <td>500M</td>
                <td>12000元/月</td>
                <td>-</td>
                <td>
                    <a href="javascript: void(0);" class="purchase-btn">立即购买</a>
                </td>
            </tr>
            <!--******-->
            <tr>
                <th>西安数据中心</th>
                <td>电信</td>
                <td>1G</td>
                <td>-</td>
                <td>28万元/年</td>
                <td>
                    <a href="javascript: void(0);" class="purchase-btn">立即购买</a>
                </td>
            </tr>
            <!--******-->
            <tr>
                <th>西安数据中心</th>
                <td>电信</td>
                <td>10G（万兆口）</td>
                <td>-</td>
                <td>250万元/年</td>
                <td>
                    <a href="javascript: void(0);" class="purchase-btn">立即购买</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!--服务保障-->
    <div class="guarantee">
        <h2 class="title white">专业服务 六大保障</h2>
        <div class="item-container">
            <div class="item">
                <img class="icon" src="{{ asset("/images/bandwidthRent/guarantee-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">安全服务</h5>
                    <p class="desc">
                        为客户提供攻击防御流量清洗、异地容灾备份、无缝移机服务、服务器状态监控服务，抵御黑客入侵及各种DDOS、CC、SYN、UPD等恶意攻击。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/bandwidthRent/guarantee-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">软件服务</h5>
                    <p class="desc">
                        协助用户部署服务器系统环境，例如：WEB、RTP、DNS、MAIL、数据库、防火墙等，同时在用户授权的情况下，定期为用户坚持常用软件的运行情况和故障排查。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/bandwidthRent/guarantee-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">技术支持</h5>
                    <p class="desc">
                        自主研发IDC自动化运维系统，为客户提供365&times;24小时运维技术支持，并设有VIP快速服务通道，能及时完善地处理任何故障，协助用户提交网站备案。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/bandwidthRent/guarantee-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">硬件服务</h5>
                    <p class="desc">
                        提供7&times;24小时启动服务，协助用户进行服务器、电力及网络的部署，协助更换或添加服务器配件等。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/bandwidthRent/guarantee-icon-5.png") }}" />
                <div class="text">
                    <h5 class="title">开源节流</h5>
                    <p class="desc">
                        与单独构建机房和租用专线上网相比，机柜租用降低了企业运营成本，提升了后期维护效率。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/bandwidthRent/guarantee-icon-6.png") }}" />
                <div class="text">
                    <h5 class="title">灵活部署</h5>
                    <p class="desc">
                        自有机房，即开即用，随时可扩展网络托管设备，助您快速实现业务部署，抢占市场先机。
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--相关资质证书-->
    <div class="certificate">
        <h2 class="title white">相关资质证书</h2>
        <div id="carousel-cert" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel-cert" data-slide-to="0" class="active"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="wrapper">
                        <div class="cert horizontal">
                            <div class="image horizontal">
                                <img src="{{ asset("/images/bandwidthRent/广播电视节目制作经营许可证.png") }}" alt="广播电视节目制作经营许可证" />
                            </div>
                            <h5 class="title">广播电视节目制作经营许可证</h5>
                        </div>
                        <div class="cert">
                            <div class="image">
                                <img src="{{ asset("/images/bandwidthRent/固定网国内数据传送业务经营许可证.png") }}" alt="固定网国内数据传送业务经营许可证" />
                            </div>
                            <h5 class="title">固定网国内数据传送业务经营许可证</h5>
                        </div>
                        <div class="cert">
                            <div class="image">
                                <img src="{{ asset("/images/bandwidthRent/腾正增值电信业务经营许可证.png") }}" alt="腾正增值电信业务经营许可证" />
                            </div>
                            <h5 class="title">腾正增值电信业务经营许可证</h5>
                        </div>
                        <div class="cert">
                            <div class="image">
                                <img src="{{ asset("/images/bandwidthRent/网络文化经营许可证.png") }}" alt="网络文化经营许可证" />
                            </div>
                            <h5 class="title">网络文化经营许可证</h5>
                        </div>
                        <div class="cert">
                            <div class="image">
                                <img src="{{ asset("/images/bandwidthRent/质量管理体系认证.png") }}" alt="质量管理体系认证" />
                            </div>
                            <h5 class="title">质量管理体系认证</h5>
                        </div>
                        <div class="cert">
                            <div class="image">
                                <img src="{{ asset("/images/bandwidthRent/腾正防火墙系统.png") }}" alt="腾正防火墙系统" />
                            </div>
                            <h5 class="title">腾正防火墙系统</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--常见问题-->
    <div class="common-question">
        <h2 class="title">大带宽租用常见问题</h2>
        <h5 class="sub-title">关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</h5>
        <div class="list-container">
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">什么是大带宽租用？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">大带宽租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">大带宽服务器可以为我们带来什么？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">大带宽租用多少钱一年？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">带宽租用影响价格的因素有哪些？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
            </ul>
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">大带宽租用多少钱一年？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">大带宽租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">大带宽服务器可以为我们带来什么？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">大带宽租用多少钱一年？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">带宽租用影响价格的因素有哪些？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
            </ul>
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">带宽租用影响价格的因素有哪些？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">大带宽租用如何选择？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">大带宽服务器可以为我们带来什么？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">大带宽租用多少钱一年？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">带宽租用影响价格的因素有哪些？</a>
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
