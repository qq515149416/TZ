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
</div>

@endsection
