@extends('layouts.user')

@section('title', '新用户后台')

@section('content')
<div class="container-fluid pt-3 px-4 mb-5">
    <div class="row">
        <div class="col-3">
            <div class="paper jumbotron-fluid rounded bg-white pl-4 py-4">
                <div class="media ml-1">
                    <img src="{{ asset("/user_assets/html_img/avatar.png") }}" class="mr-3 align-self-center" alt="用户头像">
                    <div class="media-body">
                        <h5 class="mt-0 font-bold mb-3">黄某某<span class="font-medium status badge badge-light ml-2">已认证</span></h5>
                        <p class="font-medium my-0 mb-1">账号：123456@163.com</p>
                        <p class="font-medium my-0 mb-1">联系电话：12345678901</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                <div class="balance-title d-flex justify-content-between align-items-center">
                    <span>账号余额</span>
                    <button type="button" class="btn btn-primary font-medium">充&nbsp;值</button>
                </div>
                <div class="balance mt-3">
                    8888.88
                </div>
            </div>
        </div>
        <div class="col">
            <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                <div class="row">
                    <div class="col text-center border-right">
                        <span class="user-detail-icon discount mt-2">
                        </span>
                        <span class="user-detail-text font-medium d-block mt-2 pt-2">
                            优惠票券
                        </span>
                    </div>
                    <div class="col text-center border-right">
                        <span class="user-detail-icon order mt-2">
                        </span>
                        <span class="user-detail-text font-medium d-block mt-2 pt-2">
                            我的订单
                        </span>
                    </div>
                    <div class="col text-center border-right">
                        <span class="user-detail-icon transaction mt-2">
                        </span>
                        <span class="user-detail-text font-medium d-block mt-2 pt-2">
                            交易明细
                        </span>
                    </div>
                    <div class="col text-center">
                        <span class="user-detail-icon invoice mt-2">
                        </span>
                        <span class="user-detail-text font-medium d-block mt-2 pt-2">
                            发票管理
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-3 mt-3">
        <div class="col-3">
            <div class="row">
                <div class="col">
                    <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                        <div class="paper-title border-bottom font-medium pt-3 pb-4">
                            基本信息
                        </div>
                        <div class="paper-content font-medium">
                            <p class="my-0 mt-4 pt-1 d-flex justify-content-between">
                                <span>常用邮箱&nbsp;&nbsp;123456@qq.com</span>
                                <span class="text-primary">已绑定</span>
                            </p>
                            <p class="my-0 mt-4 pt-1 d-flex justify-content-between">
                                <span>手机号码&nbsp;&nbsp;12345678901</span>
                                <span class="text-primary">已绑定</span>
                            </p>
                            <p class="mt-4 pt-1 d-flex justify-content-between">
                                <span>QQ号码&nbsp;&nbsp;123456</span>
                                <span class="text-primary">已绑定</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-100 pt-3 mt-3"></div>
                <div class="col">
                    <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                        <div class="paper-title border-bottom font-medium pt-3 pb-4">
                            你的专属客服
                        </div>
                        <div class="paper-content font-medium">
                            <h5 class="font-bold my-4 py-1">帅东</h5>
                            <p class="my-0 mb-3 pb-1">QQ号码&nbsp;&nbsp;888402334</p>
                            <p class="my-0">手机号码&nbsp;&nbsp;187190389901</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                <div class="paper-title border-bottom font-medium pt-3 pb-4">
                    我的产品
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
