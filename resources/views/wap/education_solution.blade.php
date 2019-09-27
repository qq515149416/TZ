@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 教育云解决方案 -->

<div id="education_solution">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/教育云海报.png") }}" alt="">
                        <a class="posters-btn">立即咨询</a>
                    </div>
                    <div class="title">
                        <p>行业问题</p>
                        <div class="title-hr"></div>
                    </div>
                    <div class="industry-problems">
                        <div class="tz-main">
                            <ul class="clear">
                                <li class="m">
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/教育局.png") }}" alt="">
                                        <p>教育局</p>
                                    </div>
                                    <p class="industry-text">教育信息化产品品类庞杂，不能将数据统一、规整，不能实时掌握所辖地区的教育数据。</p>
                                </li>
                                <li>
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/高校.png") }}" alt="">
                                        <p>高校</p>
                                    </div>
                                    <p class="industry-text">应用系统较多，缺统一认证机制，学生、教师身份信息管理复杂；网络、安全配套落后。</p>
                                </li>
                                <li class="m">
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/中小学.png") }}" alt="">
                                        <p>中小学</p>
                                    </div>
                                    <p class="industry-text">学校管理工作未智慧化，整体效率偏低；教师事务繁琐不能全心投入教学；家校沟通不畅。</p>
                                </li>
                                <li>
                                    <div class="industry-title">
                                        <img src="{{ asset("/images/wap/幼儿园.png") }}" alt="">
                                        <p>幼儿园</p>
                                    </div>
                                    <p class="industry-text">家长不能及时掌握幼儿进园、出园动态；家长较难了解孩子在幼儿园时的表现和动态。</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="architecture-deployment">
                        <div class="tz-main">
                            <div class="title">
                                <p>架构部署</p>
                                <div class="title-hr"></div>
                            </div>
                            <img src="{{ asset("/images/wap/教育云架构图.png") }}" alt="">
                            <div class="description">
                                <div class="description-title">架构说明</div>
                                <p>将教育管理、教务、教学应用等系统集成化，实现统一数据中心、统一身份认证、统一用户平台，创造“云端”服务： </p>
                                <p>1) 虚拟化设施，集中管理、按需分配、并行计算、海量存储;</p>
                                <p>2) 虚拟化管理，实现一机变多机变一机动态同步处理;</p>
                                <p>3) 软件大集成，统一部署、综合服务、数据共享、便于应用;</p>
                                <p>4) 资源价值化，资源共建、数据一致、全面统揽、个性应用;</p>
                            </div>
                        </div>
                    </div>
                    <div class="service-advantages">
                        <div class="title">
                            <p>服务优势</p>
                            <div class="title-hr"></div>
                        </div>
                        <img src="{{ asset("/images/wap/教育云服务优势.png") }}" alt="">
                        <div class="tz-main">
                            <ul>
                                <li>
                                    <div class="fuwu-title">面向教育管理者</div>
                                    <div class="fuwu-txt">利用云端办公环境，快速便捷地处理学籍、人事、资产及办公信息，提高工作效率和管理水平，减轻工作强度。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">面向教师</div>
                                    <div class="fuwu-txt">提供云端网络备课授课、课件制作、网上阅卷的平台，在更大范围内共享思想与资源，提高教学质量与教学水平。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">面向家长</div>
                                    <div class="fuwu-txt">架设学校和家庭之间的沟通桥梁，加强老师、家长、学生之间的联系，通过网络促进学校教育和家庭教育的结合。</div>
                                </li>
                                <li>
                                    <div class="fuwu-title">面向学生</div>
                                    <div class="fuwu-txt">以学生成长档案为核心，通过全新智能式、协作式、探索式手段开展学习与评价,全面提高学生的综合素质与能力。</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="solutions-consulting">
                        <img src="{{ asset("/images/wap/蓝条.png") }}" alt="">
                        <a>
                            立即咨询
                        </a>
                    </div> -->


                </div>
            </div>
        </div>
    </div>

@endsection
