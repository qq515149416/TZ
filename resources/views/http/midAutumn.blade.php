@extends('layouts.layout')

@section('title', $tdk['title'])

@section('keywords', $tdk['keywords'])

@section('description', $tdk['description'])

@section('content')
<div id="midAutumn" class="row">
    <section>
        <header class="container-title"></header>
        <article class="container-content clearfix">
            <div class="dialog">
                <header class="product-title">
                    高防IP&nbsp;套餐
                </header>
                <article class="product-content">
                    <ul>
                        <li>
                            <span>买&nbsp;|&nbsp;高防IP</span>
                            <span>送WAF&nbsp;&nbsp;1个月</span>
                        </li>
                    </ul>
                    <span class="chips">
                        备注
                    </span>
                    <p>活动内容：双节促销，买高防IP 送WAF，提高企业web站点安全系数。</p>
                    <p>赠送条件：活动时间内购买任一高防Ip产品。</p>
                    <p>赠送详情：1个域名WAF基础防御产品，1个月使用。</p>
                    <p>活动对象：所有新老客户。</p>
                </article>
                <footer class="product-operats">
                    <a class="buy" onclick="randomqq()" href="javascript:;">立即咨询</a>
                </footer>
            </div>
            <div class="dialog">
                <header class="product-title">
                    高防服务器&nbsp;套餐
                </header>
                <article class="product-content">
                    <ul>
                        <li>
                            <span>买&nbsp;|&nbsp;高防服务器</span>
                            <span>送100G防御流量叠加包</span>
                        </li>
                    </ul>
                    <span class="chips">
                        备注
                    </span>
                    <p>活动内容：买1台高防服务器，免费送100G防御流量叠加包。</p>
                    <p>赠送条件：活动时间内购买任一高防服务器。</p>
                    <p>赠送详情：1台服务器免费送1个30天100G防御流量叠加包。</p>
                    <p>活动对象：所有新老客户。</p>
                </article>
                <footer class="product-operats">
                    <a class="buy" onclick="randomqq()" href="javascript:;">立即咨询</a>
                </footer>
            </div>
        </article>
    </section>
    <!-- <section>
        <header class="container-title"></header>
        <article class="container-content">
            <div class="dialog">
                <header class="product-title">
                    腾正云一键商城系统（高性能云主机+商城商务版授权）5折特惠
                </header>
                <article class="product-content">
                    <section>
                        <div class="title">
                            <span class="chips">
                                云服务器配置
                            </span>
                        </div>
                        <div class="config">
                            <div class="config-item">
                                <span class="attr">CPU</span>
                                <span class="val">2核</span>
                            </div>
                            <div class="config-item">
                                <span class="attr">内存</span>
                                <span class="val">4G</span>
                            </div>
                            <div class="config-item">
                                <span class="attr">硬盘</span>
                                <span class="val">40G+50GSSD</span>
                            </div>
                            <div class="config-item">
                                <span class="attr">带宽</span>
                                <span class="val">10M</span>
                            </div>
                            <div class="config-item">
                                <span class="attr">备份集</span>
                                <span class="val">1份</span>
                            </div>
                        </div>
                        <p>
                            +
                        </p>
                        <div class="title">
                            <span class="chips">
                                商城软件授权
                            </span>
                        </div>
                        <div class="h1">
                            1年商务版授权+1年在线技术支持
                        </div>
                        <div class="h2">
                            应用场景：适用于做PC端、移动端电商商城客户
                        </div>
                    </section>
                    <section>
                        <div class="condition-config">
                            <div class="condition-config-item">
                                <span class="attr">地域</span>
                                <span class="val">衡阳地区节点</span>
                            </div>
                            <div class="condition-config-item">
                                <span class="attr">活动对象</span>
                                <span class="val">所有新老客户</span>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="price">
                            <span class="currency">￥</span>
                            <span class="amount">3456</span>
                            元/年
                        </div>
                        <a class="buy" target="_blank" href="https://www.tzcloud.com/cloudbuy.html?pg=23">立即购买</a>
                    </section>
                </article>
            </div>
        </article>
    </section> -->
    <section>
        <header class="container-title"></header>
        <article class="container-content">
            <div class="dialog">
                <header class="product-title">
                    腾正云&nbsp;——&nbsp;国庆促销(&nbsp;新开企业低防秒解云主机送20M带宽&nbsp;)
                </header>
                <article class="product-content">
                    <section>
                        <div class="title">
                            <span class="chips">
                                云服务器配置
                            </span>
                        </div>
                        <div class="config">
                            <div class="config-item">
                                <span class="attr">CPU</span>
                                <span class="val">1核</span>
                            </div>
                            <div class="config-item">
                                <span class="attr">内存</span>
                                <span class="val">2G</span>
                            </div>
                            <div class="config-item">
                                <span class="attr">硬盘</span>
                                <span class="val">40G+20GSSD</span>
                            </div>
                            <div class="config-item">
                                <span class="attr">带宽</span>
                                <span class="val">20M独享</span>
                            </div>
                            <div class="config-item">
                                <span class="attr">线路</span>
                                <span class="val">电信</span>
                            </div>
                        </div>
                        <div class="config simple">
                            <div class="config-item">
                                <span class="attr">防御</span>
                                <span class="val">10G</span>
                            </div>
                            <div class="config-item">
                                <span class="attr">备份集</span>
                                <span class="val">1份</span>
                            </div>
                            <div class="config-item">
                                <span class="attr">IP</span>
                                <span class="val">1个</span>
                            </div>
                        </div>
                        <div class="h2 clearfix">
                            <span>
                                应用场景：
                            </span>
                            <span>
                                访问量较小的个人网站初级阶段。轻量应用服务、建站、学习、为轻量应用专属定制，简单易用。
                            </span>
                        </div>
                    </section>
                    <section>
                        <div class="condition-config">
                            <div class="condition-config-item">
                                <span class="attr">地域</span>
                                <span class="val">衡阳地区节点</span>
                            </div>
                            <div class="condition-config-item">
                                <span class="attr">活动对象</span>
                                <span class="val">新注册用户</span>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="price">
                            <span class="currency">￥</span>
                            <span class="amount">66</span>
                            元/月
                        </div>
                        <a class="buy" target="_blank" href="https://www.tzcloud.com/cloudbuy.html">立即购买</a>
                    </section>
                    <span class="chips tip">
                        续费价格不变
                    </span>
                </article>
            </div>
        </article>
    </section>
</div>
@endsection
