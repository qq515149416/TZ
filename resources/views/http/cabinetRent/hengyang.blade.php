@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div class="tz-cabinet-rent" id="hengyang-cabinet">
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
            <a class="tab-item" href="/cabinet-rent/huizhou">惠州机柜租用</a>
            <a class="tab-item active" href="/cabinet-rent/hengyang">衡阳机柜租用</a>
            <a class="tab-item" href="/cabinet-rent/xian">西安机柜租用</a>
        </div>
    </div>
    <!--机房-->
    <div class="machine-room">
        <h2 class="title black">湖南衡阳机房</h2>
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
                        <img src="{{ asset("/images/cabinetRent/hengyang/room-photo-1.jpg") }}" alt="湖南衡阳机房照片1"/>
                        <div class="mask"></div>
                    </div>
                    <div class="item">
                        <img src="{{ asset("/images/cabinetRent/hengyang/room-photo-2.jpg") }}" alt="湖南衡阳机房照片2"/>
                        <div class="mask"></div>
                    </div>
                    <div class="item">
                        <img src="{{ asset("/images/cabinetRent/hengyang/room-photo-3.jpg") }}" alt="湖南衡阳机房照片3"/>
                        <div class="mask"></div>
                    </div>
                </div>
            </div>
            <div class="desc">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td style="width: 190px;">数据中心级别</td>
                        <td>准<span style="font-weight: 600; color: #f00101;"> T3 </span>级机房</td>
                    </tr>
                    <tr>
                        <td>机房面积</td>
                        <td>3000平方米</td>
                    </tr>
                    <tr>
                        <td>机柜总数</td>
                        <td>1288个，42U国际标准机柜</td>
                    </tr>
                    <tr>
                        <td>出口总带宽</td>
                        <td>860G，直连中国电信骨干网</td>
                    </tr>
                    <tr>
                        <td>防火墙设备</td>
                        <td>200G集群防火墙</td>
                    </tr>
                    <tr>
                        <td>电力设备</td>
                        <td>两路市电，UPS艾默生力博特Hipluse系统，美国卡特2000KVA柴油发电机组</td>
                    </tr>
                    <tr>
                        <td>数据中心地址</td>
                        <td>湖南省衡阳市石鼓区蒸水桥北互联网数据中心</td>
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
                <th scope="col" style="width: calc(100% / 7.2);">数据中心</th>
                <th scope="col" style="width: calc(100% / 7.2);">规格</th>
                <th scope="col" style="width: calc(100% / 7.2);">电流</th>
                <th scope="col" style="width: calc(100% / 7.2);">带宽</th>
                <th scope="col" style="width: calc(100% / 7.2);">IP数</th>
                <th scope="col" style="width: calc(100% / 7.2);">月付</th>
                <th scope="col" style="width: calc(100% / 6.8);">购买</th>
            </tr>
            </thead>
            <tbody>
            <!--******-->
            <tr>
                <th>衡阳电信</th>
                <td>42U</td>
                <td>≤12A</td>
                <td>100M独享</td>
                <td>18个</td>
                <td>7000</td>
                <td>
                    <a href="javascript: void(0);" class="purchase-btn">立即购买</a>
                </td>
            </tr>
            <!--******-->
            <tr>
                <th>衡阳双线</th>
                <td>42U</td>
                <td>≤12A</td>
                <td>100M独享</td>
                <td>18对</td>
                <td>9500</td>
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
                <img class="icon" src="{{ asset("/images/cabinetRent/guarantee-icon-1.png") }}" />
                <div class="text">
                    <h5 class="title">安全服务</h5>
                    <p class="desc">
                        为客户提供攻击防御流量清洗、异地容灾备份、无缝移机服务、服务器状态监控服务，抵御黑客入侵及各种DDOS、CC、SYN、UPD等恶意攻击。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/guarantee-icon-2.png") }}" />
                <div class="text">
                    <h5 class="title">软件服务</h5>
                    <p class="desc">
                        协助用户部署服务器系统环境，例如：WEB、RTP、DNS、MAIL、数据库、防火墙等，同时在用户授权的情况下，定期为用户坚持常用软件的运行情况和故障排查。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/guarantee-icon-3.png") }}" />
                <div class="text">
                    <h5 class="title">技术支持</h5>
                    <p class="desc">
                        自主研发IDC自动化运维系统，为客户提供365&times;24小时运维技术支持，并设有VIP快速服务通道，能及时完善地处理任何故障，协助用户提交网站备案。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/guarantee-icon-4.png") }}" />
                <div class="text">
                    <h5 class="title">硬件服务</h5>
                    <p class="desc">
                        提供7&times;24小时启动服务，协助用户进行服务器、电力及网络的部署，协助更换或添加服务器配件等。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/guarantee-icon-5.png") }}" />
                <div class="text">
                    <h5 class="title">开源节流</h5>
                    <p class="desc">
                        与单独构建机房和租用专线上网相比，机柜租用降低了企业运营成本，提升了后期维护效率。
                    </p>
                </div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/cabinetRent/guarantee-icon-6.png") }}" />
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
                                <img src="{{ asset("/images/cabinetRent/广播电视节目制作经营许可证.png") }}" alt="广播电视节目制作经营许可证" />
                            </div>
                            <h5 class="title">广播电视节目制作经营许可证</h5>
                        </div>
                        <div class="cert">
                            <div class="image">
                                <img src="{{ asset("/images/cabinetRent/固定网国内数据传送业务经营许可证.png") }}" alt="固定网国内数据传送业务经营许可证" />
                            </div>
                            <h5 class="title">固定网国内数据传送业务经营许可证</h5>
                        </div>
                        <div class="cert">
                            <div class="image">
                                <img src="{{ asset("/images/cabinetRent/腾正增值电信业务经营许可证.png") }}" alt="腾正增值电信业务经营许可证" />
                            </div>
                            <h5 class="title">腾正增值电信业务经营许可证</h5>
                        </div>
                        <div class="cert">
                            <div class="image">
                                <img src="{{ asset("/images/cabinetRent/网络文化经营许可证.png") }}" alt="网络文化经营许可证" />
                            </div>
                            <h5 class="title">网络文化经营许可证</h5>
                        </div>
                        <div class="cert">
                            <div class="image">
                                <img src="{{ asset("/images/cabinetRent/质量管理体系认证.png") }}" alt="质量管理体系认证" />
                            </div>
                            <h5 class="title">质量管理体系认证</h5>
                        </div>
                        <div class="cert">
                            <div class="image">
                                <img src="{{ asset("/images/cabinetRent/腾正防火墙系统.png") }}" alt="腾正防火墙系统" />
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
        <h2 class="title">机柜租用常见问题</h2>
        <h5 class="sub-title">关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</h5>
        <div class="list-container">
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">什么是机柜租用？</a>
                    <a class="date" href="javascript: void(0);">2019.01.21</a>
                </li>
                <li class="list-group-item">
                    <a class="text" href="javascript: void(0);">机柜租用好吗？</a>
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
                    <a class="text" href="javascript: void(0);">机柜租用好吗？</a>
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
                    <a class="text" href="javascript: void(0);">机柜租用好吗？</a>
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