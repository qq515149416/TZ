@extends('layouts.user')

@section('title', '新用户后台')

@section('content')
<div id="index" class="container-fluid pt-3 px-4 mb-5">
    <div class="row">
        <div class="col col-lg-3">
            <div class="paper jumbotron-fluid rounded bg-white pl-4 py-4 mb-2 mb-lg-0">
                <div class="media ml-1">
                    <img src="{{ asset("/user_assets/html_img/avatar.png") }}" class="mr-3 align-self-center" alt="用户头像">
                    <div class="media-body user-info">
                        <h5 class="mt-0 font-bold mb-3">黄某某<span class="font-medium status badge badge-light ml-2">已认证</span></h5>
                        <p class="font-medium my-0 mb-1">账号：123456@163.com</p>
                        <p class="font-medium my-0 mb-1">联系电话：12345678901</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-lg-3">
            <div class="paper jumbotron-fluid rounded bg-white px-4 py-4 mb-2 mb-lg-0">
                <div class="balance-title d-flex justify-content-between align-items-center">
                    <span>账号余额</span>
                    <button type="button" class="btn btn-primary font-medium" data-toggle="modal" data-target="#rechargeModal">充&nbsp;值</button>
                </div>
                <div class="balance mt-3">
                    8888.88
                </div>
            </div>
        </div>
        <div class="w-100 d-block d-md-none d-lg-none">
        </div>
        <div class="col">
            <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                <div class="row">
                    <div class="col text-center border-right">
                        <a class="text-decoration-none" href="javascript:;">
                            <span class="user-detail-icon discount mt-2">
                            </span>
                            <span class="user-detail-text font-medium d-block mt-2 pt-2">
                                优惠票券
                            </span>
                        </a>
                    </div>
                    <div class="col text-center border-right">
                        <a class="text-decoration-none" href="/user/order">
                            <span class="user-detail-icon order mt-2">
                            </span>
                            <span class="user-detail-text font-medium d-block mt-2 pt-2">
                                我的订单
                            </span>
                        </a>
                    </div>
                    <div class="col text-center border-right">
                        <a class="text-decoration-none" href="javascript:;">
                            <span class="user-detail-icon transaction mt-2">
                            </span>
                            <span class="user-detail-text font-medium d-block mt-2 pt-2">
                                交易明细
                            </span>
                        </a>
                    </div>
                    <div class="col text-center">
                        <a class="text-decoration-none" href="javascript:;">
                            <span class="user-detail-icon invoice mt-2">
                            </span>
                            <span class="user-detail-text font-medium d-block mt-2 pt-2">
                                发票管理
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-lg-3 mt-3">
        <div class="col col-lg-3">
            <div class="row">
                <div class="col">
                    <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                        <div class="paper-title border-bottom font-medium pt-3 pb-4">
                            基本信息
                        </div>
                        <div class="paper-content font-medium">
                            <p class="my-0 mt-4 pt-1 d-flex justify-content-between user-mailbox" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                                <span class="text-truncate">常用邮箱&nbsp;&nbsp;123456@qq.com</span>
                                <span class="text-primary">已绑定</span>
                            </p>
                            <p class="my-0 mt-4 pt-1 d-flex justify-content-between user-phone" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                                <span class="text-truncate">手机号码&nbsp;&nbsp;12345678901</span>
                                <span class="text-primary">已绑定</span>
                            </p>
                            <p class="mt-4 pt-1 d-flex justify-content-between user-qq" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                                <span class="text-truncate">QQ号码&nbsp;&nbsp;123456</span>
                                <span class="text-primary">已绑定</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-100 pt-lg-3 mt-3"></div>
                <div class="col">
                    <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                        <div class="paper-title border-bottom font-medium pt-3 pb-4">
                            你的专属客服
                        </div>
                        <div class="paper-content font-medium">
                            <h5 class="font-bold my-4 py-1 sales-name">帅东</h5>
                            <p class="my-0 mb-3 pb-1 sales-qq">QQ号码&nbsp;&nbsp;888402334</p>
                            <p class="my-0 sales-phone">手机号码&nbsp;&nbsp;187190389901</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 d-block d-md-none d-lg-none mb-3">
        </div>
        <div class="col">
            <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                <div class="paper-title border-bottom font-medium pt-3 pb-4">
                    我的产品
                </div>
                <div class="paper-content font-medium pt-2 pb-3">
                    <div class="media product-item mt-5">
                        <img src="{{ asset("/user_assets/html_img/server_icon.png") }}" class="align-self-center ml-lg-3 mr-3 pr-lg-3" alt="...">
                        <div class="media-body">
                            <h5 class="mx-0 mb-3 font-heavy">服务器</h5>
                            <p class="font-regular mx-0">腾正云服务器旨在为用户提供优质、高效、弹性伸缩的云计算服务。采用由数据切片技术构建的三层存储功能，切实保护客户数据的安全；弹性扩展的资源用量，为业务高峰期的顺畅保驾护航；灵活多样的计费方式，为客户节省IT运营成本，提高资源有效利用率。</p>
                            <div class="mt-3 d-flex d-lg-block idc-status">
                                <span class="font-medium status badge badge-light">运行中：1</span>
                                <span class="font-medium status badge badge-light ml-2">需续费：0</span>
                            </div>
                        </div>
                    </div>
                    <div class="media product-item mt-5 mb-5">
                        <img src="{{ asset("/user_assets/html_img/gaofang_icon.png") }}" class="align-self-center ml-lg-3 mr-3 pr-lg-3" alt="...">
                        <div class="media-body">
                            <h5 class="mx-0 mb-3 font-heavy">高防IP</h5>
                            <p class="font-regular mx-0">腾正DDoS高防IP是针对互联网服务器（包括非腾正云主机）在遭受大流量DDoS攻击后导致服务不可用的情况下，推出的付费增值服务，用户可通过配置高防IP，将攻击流量引流到高防IP，确保源站的稳定可靠，保障用户的访问质量和对内容提供商的黏度。</p>
                            <div class="mt-3 d-flex d-lg-block dip-status">
                                <span class="font-medium status badge badge-light">运行中：1</span>
                                <span class="font-medium status badge badge-light ml-2">需续费：0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
