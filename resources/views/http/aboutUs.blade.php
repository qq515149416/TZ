
@extends('layouts.layout')

@section('title', '服务器租用，服务器托管，专业IDC服务商')

@section('content')
    <div id="aboutus" class="row">
        <header class="banner">
            <h2>关于我们</h2>
            <h3>互联网应用支撑商</h3>
            <p>专注为您提供IDC·云计算服务·安全防护一站式产品解决方案，满足您不同时期业务发展需求</p>

        </header>
        <article class="content-list">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#descripts" aria-controls="descripts" role="tab" data-toggle="tab">公司介绍</a></li>
                <li role="presentation"><a href="#rongyu" aria-controls="rongyu" role="tab" data-toggle="tab">荣誉资质</a></li>
                <li role="presentation"><a href="#wenhua" aria-controls="wenhua" role="tab" data-toggle="tab">企业文化</a></li>
                <li role="presentation"><a href="#fazhang" aria-controls="fazhang" role="tab" data-toggle="tab">发展历程</a></li>
                <li role="presentation"><a href="#lianxi" aria-controls="lianxi" role="tab" data-toggle="tab">联系我们</a></li>
                <li role="presentation"><a href="#pay" aria-controls="pay" role="tab" data-toggle="tab">支付中心</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active clearfix" id="descripts">
                    <h2>
                        公司简介
                        <span class="pull-right">
                            <a href="#">首页</a> >
                            <a href="#">关于我们</a> >
                            <a href="#" class="active">公司介绍</a>
                        </span>
                    </h2>
                    <p class="topline">
                    广东腾正计算机科技有限公司（以下简称腾正科技）一家专注于互联网安全技术研究的现代网络综合服务性的高科技公司，为企业提供领先、安全、高效、全面的互联网运营服务。总部位于东莞松山湖国际金融IT研发创新园，旗下全资拥有两家子公司，长沙正易网络科技有限公司和广东腾川网络科技有限公司及多家分子公司，建立了以华南的广东、华中的湖南、西部的西安、北部的吉林、东北的浙江五大核心数据中心及多个IDC节点，服务的企业遍布各个行业。
                    </p>
                    <img class="pull-left" src="{{ asset("/images/introduction.png") }}" alt="" />
                    <p>
                    腾正科技的产品线涵盖了IDC数据中心，数据安全，云计算，DNS&CDN，系统研发，电商平台基础支撑等领域。在IDC数据中心、大数据分析、网络运营领域拥有领先技术，目前已获得10余项自有软件著作权和专利权。其中，腾正科技与中科院联合打造的TzCloud公有云-云计算操作系统，不仅与中科院达成战略性合作，并且获得了中国信息安全评测中心等级安全认证，给予”安全可控优秀云计算解决方案”的评价。腾正云投入使用后，与曙光、南方报业集团等上百家知名公司建立了深度合作。
                    </p>
                    <p>
                    面对互联网产业蓬勃发展的全球化格局，为了更好的迎接互联网时代的浪潮，腾正科技以提供安全的互联网解决方案为目标，以市场的需求和业务的发展为先导，以互联网安全技术为核心，以专业、快速的售后服务为支撑，本着坚定的信念，开拓创新，为广大的互联网同行与合作伙伴提供优质的产品和完善的服务。
                    </p>
                    <img class="slogan clearfix" src="{{ asset("/images/boiling.png") }}" alt="" />
                </div>
                <div role="tabpanel" class="tab-pane" id="rongyu">...</div>
                <div role="tabpanel" class="tab-pane" id="wenhua">...</div>
                <div role="tabpanel" class="tab-pane" id="fazhang">...</div>
                <div role="tabpanel" class="tab-pane" id="lianxi">...</div>
                <div role="tabpanel" class="tab-pane" id="pay">...</div>
            </div>
        </article>
    </div>
@endsection
