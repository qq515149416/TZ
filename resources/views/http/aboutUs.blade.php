
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
                <div role="tabpanel" class="tab-pane active" id="descripts">
                    <h2>
                        公司简介
                        <span class="pull-right">
                            <a href="#">首页</a> >
                            <a href="#">关于我们</a> >
                            <a href="#" class="active">公司介绍</a>
                        </span>
                    </h2>
                    <p>
                    广东腾正计算机科技有限公司（以下简称腾正科技）一家专注于互联网安全技术研究的现代网络综合服务性的高科技公司，为企业提供领先、安全、高效、全面的互联网运营服务。总部位于东莞松山湖国际金融IT研发创新园，旗下全资拥有两家子公司，长沙正易网络科技有限公司和广东腾川网络科技有限公司及多家分子公司，建立了以华南的广东、华中的湖南、西部的西安、北部的吉林、东北的浙江五大核心数据中心及多个IDC节点，服务的企业遍布各个行业。
                    </p>
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
