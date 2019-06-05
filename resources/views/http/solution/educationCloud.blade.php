@extends('layouts.layout')

@section('title', '游戏云解决方案-游戏服务器架构-CDN游戏加速[腾正科技]')

@section('keywords', '游戏云解决方案,游戏云面临问题,游戏云架构部署,游戏服务器,游戏服务器架构，CDN游戏加速')

@section('description', '腾正科技游戏云解决方案，利用云服务器弹性扩展、负载均衡功能、自研高防御系统及CDN加速，打造虚拟化、高可用的游戏集群，解决游戏客户运行卡顿、掉线、攻击停服、玩家分析缺失、游戏直播接入困难等常见问题。')

@section('content')
<div class="tz-solution">
    <div class="tab">
        <a class="tab-item" href="/solution/game">游戏</a>
        <a class="tab-item" href="/solution/chess">棋牌</a>
        <a class="tab-item" href="/solution/finance">金融</a>
        <a class="tab-item" href="/solution/streaming_media">流媒体</a>
        <a class="tab-item" href="/solution/mobile_app">移动APP</a>
        <a class="tab-item active" href="/solution/education_cloud">教育云</a>
        <a class="tab-item" href="/solution/government_cloud">政务云</a>
        <a class="tab-item" href="/solution/website_deployment">网站部署</a>
    </div>
    <!--主体内容-->
    <div class="content">
        <!-- 教育云 -->
        <div id="education-cloud">
            <!-- banner -->
            <div class="banner">
                <div class="title" style="color: #fff;">
                    <h2 class="text">教育云解决方案</h2>
                    <h5 class="sub-text font-regular">
                        结合教育地域特性，为各种教育场景快速搭建智能化信息平台，将教育管理、教务、教学应用等系统集成化，<br/>
                        推进教育行业的数字化和智能化，促进行业的转型升级
                    </h5>
                </div>
                <a class="apply-btn" href="javascript: void(0);">立即申请</a>
            </div>
            <!--面临问题-->
            <div class="problem">
                <h2 class="title">教育云面临的问题</h2>
                <div class="card-container">
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon19.png") }}" />
                            <span class="text">教育局</span>
                        </div>
                        <div class="card-body">
                            <p>
                                教育信息化产品品类庞杂，不能将数据统一、规整，不能实时掌握所辖地区的教育数据，如全部学生、教师人数男女生比例，班额情况等，而传统纸质的通知、审批工作，周期长、效率低，不能高效落实和收集反馈。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon20.png") }}" />
                            <span class="text">高校</span>
                        </div>
                        <div class="card-body">
                            <p>
                                应用系统较多，缺少统一认证机制，学生、教师身份信息管理复杂；网络、存储等设施设备落后于需求与技术的发展，缺乏统一管理和调度；安全、容灾、备份系统不够完善，稳定性与可靠性不够，整体效率偏低。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon21.png") }}" />
                            <span class="text">中小学</span>
                        </div>
                        <div class="card-body">
                            <p>学校管理工作仍偏传统未实现智慧化，整体效率偏低；家校沟通较不畅，家长不能及时了解学生在校学习及生活情况；教师日常事务性工作繁琐，不能全身心投入教学。</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <img class="icon" src="{{ asset("/images/program/icon22.png") }}" />
                            <span class="text">幼儿园</span>
                        </div>
                        <div class="card-body">
                            <p>家长不能及时掌握幼儿进园、出园动态；家长较难了解孩子在幼儿园时的表现和动态；幼儿园信息化建设较薄弱，数字化教学资源较短缺。</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--架构部署-->
            <div class="arch">
                <h2 class="title">解决方案构架部署</h2>
                <div class="cont">
                    <img class="arch-img" src="{{ asset("/images/program/education-cloud-arch.png") }}"
                    alt="教育云解决方案构架部署图" />
                    <div style="max-width: 1180px; margin: 0 auto;padding-left: 10px;padding-right: 10px;">
                        <div class="desc">
                            <h5 style="text-align: left; color: #1e2251; font-family: 'pingFangBold'">
                                将教育管理、教务、教学应用等系统集成化，实现统一数据中心、统一身份认证、统一用户平台，创造“云端”服务：
                            </h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span>基础设施虚拟化（大集中）——集中管理、按需分配、并行计算、海量存储；</span>
                                </li>
                                <li class="list-group-item">
                                    <span>应用软件集成化（大集成）-----统一部署、综合服务、数据共享、便于应用；</span>
                                </li>
                                <li class="list-group-item">
                                    <span>将服务器与存储进行虚拟化管理，实现一机变多机或多机变一机的动态管理，多任务同步处理；</span>
                                </li>
                                <li class="list-group-item">
                                    <span>教育资源价值化（大数据）——资源共建、数据一致、全面统览、个性应用。</span>
                                </li>
                            </ul>
                        </div>
                        <br/>
                        <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
                    </div>
                </div>
            </div>
            <!--优势-->
            <div class="adv">
                <h2 class="title">教育云服务优势</h2>
                <div class="cont">
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-1.png") }}" alt="adv1" />
                                <span>面向教育管理者</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    利用云端办公环境，快速便捷地处理学籍、人事、资产及办公信息，提高工作效率和管理水平，减轻工作强度。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-3.png") }}" alt="adv3" />
                                <span>面向家长</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    架设学校和家庭之间的沟通桥梁，加强老师、家长、学生之间的联系，通过网络促进学校教育和家庭教育的结合。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-2.png") }}" alt="adv2" />
                                <span>面向教师</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    提供云端网络备课授课、课件制作、网上阅卷的平台，在更大范围内共享思想与资源，提高教学质量与教学水平。
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-title">
                                <img class="order" src="{{ asset("/images/program/adv-icon-4.png") }}" alt="adv4" />
                                <span>面向学生</span>
                            </div>
                            <div class="item-body">
                                <p>
                                    以学生成长档案为核心，通过全新的智能式、协作式、探索式手段开展学习与评价，全面提高学生的综合素质与能力。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--咨询-->
        <div class="consult">
            <h2 class="title">
                联系解决方案架构师定制专属方案
            </h2>
            <a class="consult-btn" href="javascript: void(0);">立即咨询</a>
        </div>
    </div>
</div>
@endsection