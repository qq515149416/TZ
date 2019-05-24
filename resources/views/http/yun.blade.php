@extends('layouts.layout')

@section('title', $data['title'])

@section('keywords', $data['keywords'])

@section('description', $data['description'])

@section('content')

<div id="tz_yun" class="row">
    <div class="banner">
        <h2>
            腾正云服务器
        </h2>
        <p>
            腾正云服务器配备高性能存储，旨在为用户提供优质、高效、弹性伸缩的云计算服务。云服务器采用由数据切片技术构建的三层存储功能，切实保护客户数据的安全。同时可弹性扩展的资源用量，为客户业务在高峰期的顺畅保驾护航；灵活多样的计费方式，为客户最大程度的节省IT运营成本，提高资源的有效利用率。
        </p>
        <nav>
            <ul>
                <li>
                    <a class="aticve" href="/yun/huizhou">
                        惠州云服务器
                    </a>
                </li>
                <li>
                    <a href="/yun/hengyang">
                        衡阳云服务器
                    </a>
                </li>
                <li>
                    <a href="/yun/xian">
                        西安云服务器
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="package">
        <h3>
            推荐套餐
        </h3>
        <ul class="list clearfix">
            <li>
                <header>
                    <h4>
                        广东地区
                    </h4>
                </header>
                <section>
                    <h5>
                        游戏弹性云
                    </h5>
                    <p>
                        腾正云应用领先的云技术，高性能物理设施打造高可用产品
                    </p>
                </section>
                <section>
                    <ul>
                        <li>弹性云服务器</li>
                        <li>基础云服务器</li>
                        <li>高级云服务器</li>
                    </ul>
                </section>
                <div class="price">
                    <span class="value">39</span>
                    元&nbsp;/&nbsp;月起
                </div>
                <a href="javascript:;">立即选购</a>
            </li>
            <li>
                <header>
                    <h4>
                        湖南地区
                    </h4>
                </header>
                <section>
                    <h5>
                    基础配置
                    </h5>
                    <p>
                    系统安装配置、快照备份与恢复、系统端口开启与关闭、系统参数调整与优化、磁盘扩展、分区、挂载
                    </p>
                </section>
                <section>
                    <ul>
                        <li>环境配置</li>
                        <li>安全加固</li>
                        <li>系统设置</li>
                    </ul>
                </section>
                <div class="price">
                    <span class="value">99</span>
                    元&nbsp;/&nbsp;月起
                </div>
                <a href="javascript:;">立即选购</a>
            </li>
            <li>
                <header>
                    <h4>
                    陕西地区
                    </h4>
                </header>
                <section>
                    <h5>
                        全国机房任你挑
                    </h5>
                    <p>
                        全国机房看中哪个,托去哪里
                    </p>
                </section>
                <section>
                    <ul>
                        <li>系统设置</li>
                        <li>环境配置</li>
                        <li>安全加固</li>
                    </ul>
                </section>
                <div class="price">
                    <span class="value">599</span>
                    元&nbsp;/&nbsp;月起
                </div>
                <a href="javascript:;">立即选购</a>
            </li>
            <li>
                <header>
                    <h4>
                        企业类型
                    </h4>
                </header>
                <section>
                    <h5>
                        企业类型
                    </h5>
                    <p>
                        价格最低,性能最稳定
                    </p>
                </section>
                <section>
                    <ul>
                        <li>系统设置</li>
                        <li>环境配置</li>
                        <li>安全加固</li>
                    </ul>
                </section>
                <div class="price">
                    <span class="value">199</span>
                    元&nbsp;/&nbsp;月起
                </div>
                <a href="javascript:;">立即选购</a>
            </li>
            <li>
                <header>
                    <h4>
                        游戏类型
                    </h4>
                </header>
                <section>
                    <h5>
                        游戏类型
                    </h5>
                    <p>
                        无视DDOS,无视恶意扫描,无视CC等一系列攻击,T级防御
                    </p>
                </section>
                <section>
                    <ul>
                        <li>低端游戏</li>
                        <li>中端游戏</li>
                        <li>高端游戏</li>
                    </ul>
                </section>
                <div class="price">
                    <span class="value">279</span>
                    元&nbsp;/&nbsp;月起
                </div>
                <a href="javascript:;">立即选购</a>
            </li>
        </ul>
    </div>
    <div class="advantage">
        <h3>
            产品优势
        </h3>
        <p>多样化的产品，帮您实现更丰富的业务需求</p>
        <div class="swiper-container" id="product">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <ul class="clearfix">
                        <li>
                            <div class="icon">
                            </div>
                            <h4>
                            跨机房热迁移服务
                            </h4>
                            <p>
                            打破地域限制，轻松应对时间空间带来的运营困扰，最快仅需5分钟，即可将数据从一机房迁移至另一机房。
                            </p>
                        </li>
                        <li>
                            <div class="icon">
                            </div>
                            <h4>
                            资源自由调整
                            </h4>
                            <p>
                            用户可根据云服务器实际应用情况随时调整内存，硬盘，带宽，IP等资源，以应对支撑业务的需求，提高业务的安全性及稳定性。
                            </p>
                        </li>
                        <li>
                            <div class="icon">
                            </div>
                            <h4>
                            三层存储技术
                            </h4>
                            <p>
                            缓存、沉淀、备份层，三层分别对数据进行处理、缓存与灾备，三层间实时同步，数据安全性达到99.999%，高可用性达到99.99%。
                            </p>
                        </li>
                        <li>
                            <div class="icon">
                            </div>
                            <h4>
                            云防御
                            </h4>
                            <p>
                            采用自带硬防节点，西安云服务器可享免费100G防御，最高实现3.4T防御峰值，有效防御DDoS、CC等恶意攻击，保障用户网络安全。
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="swiper-slide">
                    <ul class="clearfix">
                        <li>
                            <div class="icon">
                            </div>
                            <h4>
                                性能可靠，确保业务稳定
                            </h4>
                            <p>
                            云服务器在硬件级别上实现云主机之间的完全隔离；采用高端服务器进行部署，同时采用集中的管理与监控，确保业务稳定可靠。
                            </p>
                        </li>
                        <li>
                            <div class="icon">
                            </div>
                            <h4>
                            灵活部署，助您一键上云
                            </h4>
                            <p>
                            针对不同行业、领域的企业级用户，以专业成熟的一站式行业云解决方案，帮助用户快速应用云计算。
                            </p>
                        </li>
                        <li>
                            <div class="icon">
                            </div>
                            <h4>
                            支持完整备份
                            </h4>
                            <p>
                            用户可通过控制台手动设置（系统+数据）完整备份，通过备份恢复，可快速恢复备份时间点的数据状态，确保数据的完整性。
                            </p>
                        </li>
                        <li>
                            <div class="icon">
                            </div>
                            <h4>
                            全网骨干网接入
                            </h4>
                            <p>
                            腾正云使用电信骨干网接入，有效解决南北互联互通问题。同时自身具有容灾性，保障线路安全稳定让用户体验到最佳的访问速度。
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- 如果需要分页器 -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="features">
        <h3>
            产品功能
        </h3>
        <ul>
            <li>
                <div class="feature">
                    计算
                </div>
                <div class="dec-item">
                    <p class="table-item">丰富的实例规格，灵活扩容，支撑用户业务发展</p>
                    <p class="table-item">广东、湖南、陕西、吉林、浙江五大节点，满足用户多样化需求</p>
                </div>
                <div class="dec-item">
                    <p>云服务器提供丰富的实例规格(CPU、内存）和带宽、云盘选择，支持随时升级，满足各种业务需求。99.99%的高可用性，为业务的稳定运行提供保障</p>
                </div>
            </li>
            <li>
                <div class="feature">
                    存储
                </div>
                <div class="dec-item">
                    <p>
                        三层存储技术，支撑用户数据自动生成备份，切实保障用户数据安全，满足不同的I/O性能要求
                    </p>
                </div>
                <div class="dec-item">
                    <p>采用腾正云三层存储革新技术，自动分层缓存、沉淀、备份数据保障用户数据完整性、可用性，数据安全性高达99.999%</p>
                </div>
            </li>
            <li>
                <div class="feature">
                    安全
                </div>
                <div class="dec-item">
                    <p class="table-item">网络安全、服务器安全等基础防护</p>
                    <p class="table-item">云监控监测，实时预警</p>
                </div>
                <div class="dec-item">
                    <p>提供DDoS防护、DNS劫持检测、入侵检测、漏洞扫描、网页木马检测、登录防护等安全服务对服务器的监控报警服务，提供实时监控，性能高低一目了然</p>
                </div>
            </li>
            <li>
                <div class="feature">
                    管理
                </div>
                <div class="dec-item">
                    <p>提供控制台、远程终端和 API 等多种管理方式，给您完全管理权限</p>
                </div>
                <div class="dec-item">
                    <p>提供web控制台、API两种方式，能够轻松的开通、关闭、重启、升级云服务器；提供CPU、内存、硬盘IO的实时监控和报表，随时了解云服务器运行情况</p>
                </div>
            </li>
            <li>
                <div class="feature">
                    <span>网络</span>
                </div>
                <div class="dec-item">
                    <p>全网骨干网接入，承诺独享，多运营商覆盖</p>
                </div>
                <div class="dec-item">
                    <p>覆盖多个地区的极速公网体验，提供灵活的网络规划选择</p>
                </div>
            </li>
        </ul>
    </div>
    <div class="yun-map">
        <div class="idx_box_wp index-partners">
        <div class="map-bg">
        <div class="zzidc-auto">
        <div class="zzidc-tit">
        <h2 class="gfff">多个数据中心·秒级响应全球</h2>
        <div class="line-row"></div>
        </div>
        <div class="map-main">
        <div class="map-left">
        <div class="circle-tit"> 即将部署节点 </div>
        <div class="marker-tit"> 已部署节点 </div>
        <div class="dz-list">
        <div class="dz-item">浙江</div>
        <div class="dz-item">辽宁</div>
        <div class="dz-item">陕西</div>
        <div class="dz-item">湖南</div>
        <div class="dz-item">广东</div>
        </div>
        </div>
        <style>
        .ntkj{width: 132px;height: 44px;position: absolute;z-index: 100;color: #fff;}
        </style>
        <!--即将部署节点-->
        <!--节点开始-->
        <div class="circlebox" style="left: 370px;top: 120px;"><span class="circle2"></span><span class="pulse2"></span></div>
        <div class="ntkj" style="left: 390px;top: 113px;">美国</div>
        <!--节点结束-->
        <!--节点开始-->
        <div class="circlebox" style="right: 240px;top: 207px;"><span class="circle2"></span><span class="pulse2"></span></div>
        <div class="ntkj" style="right: 90px;top: 204px;">香港</div>
        <!--节点结束-->
        <!--节点开始-->
        <div class="circlebox" style="right: 180px;top: 165px;"><span class="circle2"></span><span class="pulse2"></span></div>
        <div class="ntkj" style="right: 30px;top: 155px;">日本</div>
        <!--节点结束-->
        <!--节点开始-->
        <div class="circlebox" style="right: 235px;top: 171px;"><span class="circle2"></span><span class="pulse2"></span></div>
        <div class="ntkj" style="right: 85px;top: 162px;">浙江</div>
        <!--节点结束-->
        <!--节点开始-->
        <div class="circlebox" style="right: 225px;top: 161px;"><span class="circle2"></span><span class="pulse2"></span></div>
        <div class="ntkj" style="right: 130px;top: 148px;">上海</div>
        <!--节点结束-->
        <!--节点开始-->
        <div class="circlebox" style="right: 210px;top: 145px;"><span class="circle2"></span><span class="pulse2"></span></div>
        <div class="ntkj" style="right: 88px;top: 118px;">辽宁</div>
        <!--节点结束-->
        <!--已部署节点-->
        <!--节点开始-->
        <div class="circlebox" style="left: 940px;top: 142px;"><span class="circle"></span><span class="pulse"></span></div>
        <div class="ntkj" style="right: 170px;top: 135px;">陕西</div>
        <!--节点结束-->
        <!--节点开始-->
        <div class="circlebox" style="left: 948px;top: 177px;"><span class="circle"></span><span class="pulse"></span></div>
        <div class="ntkj" style="right: 160px;top: 170px;">湖南</div>
        <!--节点结束-->
        <!--节点开始-->
        <div class="circlebox" style="left: 959px;top: 191px;"><span class="circle"></span><span class="pulse"></span></div>
        <div class="ntkj" style="right: 90px;top: 184px;">广东</div>
        <!--节点结束-->
        </div>
        </div>
        </div>
        </div>
    </div>
    <div class="problem">
        <h3>云主机常见问题</h3>
        <p>关注腾正，关注IDC，关注云计算，关注信息安全,关注互联网动向</p>
        <div class="list clearfix">
            <ul>
                <li>
                    <a href="javascript:;" class="pull-left">什么是云主机？</a>
                    <a href="javascript:;" class="pull-right">2019.01.21</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">云服务器和云虚拟主机有什么区别？</a>
                    <a href="javascript:;" class="pull-right">2019.01.21</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">云服务器和云虚拟主机的区别、利弊？</a>
                    <a href="javascript:;" class="pull-right">2019.01.22</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">云主机哪家好？怎么选择？</a>
                    <a href="javascript:;" class="pull-right">2019.01.15</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">香港云主机哪个牌子好？</a>
                    <a href="javascript:;" class="pull-right">2019.01.15</a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="javascript:;" class="pull-left">什么是云主机？</a>
                    <a href="javascript:;" class="pull-right">2019.01.21</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">云服务器和云虚拟主机有什么区别？</a>
                    <a href="javascript:;" class="pull-right">2019.01.21</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">云服务器和云虚拟主机的区别、利弊？</a>
                    <a href="javascript:;" class="pull-right">2019.01.22</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">云主机哪家好？怎么选择？</a>
                    <a href="javascript:;" class="pull-right">2019.01.15</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">香港云主机哪个牌子好？</a>
                    <a href="javascript:;" class="pull-right">2019.01.15</a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="javascript:;" class="pull-left">什么是云主机？</a>
                    <a href="javascript:;" class="pull-right">2019.01.21</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">云服务器和云虚拟主机有什么区别？</a>
                    <a href="javascript:;" class="pull-right">2019.01.21</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">云服务器和云虚拟主机的区别、利弊？</a>
                    <a href="javascript:;" class="pull-right">2019.01.22</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">云主机哪家好？怎么选择？</a>
                    <a href="javascript:;" class="pull-right">2019.01.15</a>
                </li>
                <li>
                    <a href="javascript:;" class="pull-left">香港云主机哪个牌子好？</a>
                    <a href="javascript:;" class="pull-right">2019.01.15</a>
                </li>
            </ul>
        </div>

    </div>
    <section class="jumbotron footer">
        <h4><span>懂防御，更懂服务！</span> —— 加入腾正云，助力快速业务部署</h4>
        <a href="javascript:;">立即咨询</a>
    </section>
</div>

@endsection
