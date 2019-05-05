@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div id="tz-cdn" class="tz-cdn-content">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">15CDN</h2>
                <h5 class="sub-text">
                    网站打不开怎么办？网站访问速度慢怎么办？15CDN一站式内容智能分发加速首选<br/>
                    为您的客户体验速度插上一对腾飞的翅膀！
                </h5>
            </div>
            <a class="apply-btn" href="javascript: void(0);">立即申请</a>
        </div>
        <div class="tab">
            <a class="tab-item" href="javascript: void(0);">静态内容加速</a>
            <a class="tab-item" href="javascript: void(0);">下载分发加速</a>
            <a class="tab-item" href="javascript: void(0);">动态加速网络</a>
            <a class="tab-item" href="javascript: void(0);">流媒体点播加速</a>
            <a class="tab-item" href="javascript: void(0);">流媒体直播加速</a>
            <!--            <a class="tab-item" href="/15cdn/sca">静态内容加速</a>-->
            <!--            <a class="tab-item" href="/15cdn/dd">下载分发加速</a>-->
            <!--            <a class="tab-item" href="/15cdn/dsa">动态加速网络</a>-->
            <!--            <a class="tab-item" href="/15cdn/smlba">流媒体点播加速</a>-->
            <!--            <a class="tab-item" href="/15cdn/smvoda">流媒体直播加速</a>-->
        </div>
    </div>
    <!--套餐推荐-->
    <div class="package">
        <h2 class="title">套餐推荐</h2>
        <p class="sub-title">品质保障，价格美丽，CDN 加速首选！</p>
        <div class="desc">
            内容分发网络（CDN）将源站内容分发至最接近网民的节点，使用户可就近获得所需内容，提高网民访问的响应速度和成功率，提升网民体验度。15CDN致力为广大<br/>
            用户提供高效、稳定、安全的CDN服务，产品自带智能分发加速、攻击防护、加快收录于一体，确保您的站点快速、安全、稳定运行。
        </div>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width: 20%;"></th>
                    <th scope="col">加速-特惠体验</th>
                    <th scope="col">加速-企业版</th>
                    <th scope="col">加速-特惠体验</th>
                </tr>
                </thead>
                <tbody>
                <!--******-->
                <tr class="divider">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <!--******-->
                <tr>
                    <th>域名数量月度总流量</th>
                    <td>1T</td>
                    <td>5T</td>
                    <td>10T</td>
                </tr>
                <!--******-->
                <tr class="divider">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <!--******-->
                <tr>
                    <th>原价域名数量</th>
                    <td>1个</td>
                    <td>2个</td>
                    <td>3个</td>
                </tr>
                <!--******-->
                <tr class="divider">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <!--******-->
                <tr>
                    <th>产品说明</th>
                    <td style="padding-top: 20px; padding-bottom: 20px;">产品说明提供网页和小文件加速服务帮助客户提升网站的用户访问速度和服务的高可用性</td>
                    <td>网页静态资源优化加速，全站HTTPS保证网站访问安全，适用于文学类站点、小型图片站等</td>
                    <td>图片、文件下载加速分发，多节点融合提高图片显示及用户下载速度，适用各类图库、下载站等</td>
                </tr>
                <!--******-->
                <tr class="divider">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <!--******-->
                <tr>
                    <th>活动价格</th>
                    <td style="padding-top: 20px; padding-bottom: 20px;">
                        <p class="price">100元/月</p>
                        <a href="javascript: void(0);" class="purchase-btn">立即购买</a>
                    </td>
                    <td>
                        <p class="price">500元/月</p>
                        <a href="javascript: void(0);" class="purchase-btn">立即购买</a>
                    </td>
                    <td>
                        <p class="price">800元/月</p>
                        <a href="javascript: void(0);" class="purchase-btn">立即购买</a>
                    </td>
                </tr>
                </tbody>
            </table>
<!--            <table class="table table-bordered">-->
<!--                <thead>-->
<!--                    <tr>-->
<!--                        <th scope="col" style="width: 216px;"></th>-->
<!--                        <th scope="col" style="width: calc((100% - 216px) / 4);">防护IP</th>-->
<!--                        <th scope="col" style="width: calc((100% - 216px) / 4);">域名数量</th>-->
<!--                        <th scope="col" style="width: calc((100% - 216px) / 4);">产品说明</th>-->
<!--                        <th scope="col" style="width: calc((100% - 216px) / 4);">活动价格</th>-->
<!--                    </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                <!--******-->-->
<!--                <tr class="divider">-->
<!--                    <td></td>-->
<!--                    <td></td>-->
<!--                    <td></td>-->
<!--                    <td></td>-->
<!--                    <td></td>-->
<!--                </tr>-->
<!--                <!--******-->-->
<!--                <tr>-->
<!--                    <th>定制版</th>-->
<!--                    <td style="padding-top: 20px; padding-bottom: 20px;">不 限</td>-->
<!--                    <td>不 限</td>-->
<!--                    <td>-->
<!--                        企业网站，论坛，小说站，游<br/>-->
<!--                        戏网站，电子商务平台等-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        <p class="price">不限</p>-->
<!--                        <a href="javascript: void(0);" class="purchase-btn" style="width: 163px;">立即购买</a>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                </tbody>-->
<!--            </table>-->
        </div>
    </div>
</div>
@endsection
