
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
                <div role="tabpanel" class="tab-pane active" id="descripts">...</div>
                <div role="tabpanel" class="tab-pane" id="rongyu">...</div>
                <div role="tabpanel" class="tab-pane" id="wenhua">...</div>
                <div role="tabpanel" class="tab-pane" id="fazhang">...</div>
                <div role="tabpanel" class="tab-pane" id="lianxi">...</div>
                <div role="tabpanel" class="tab-pane" id="pay">...</div>
            </div>
        </article>
    </div>
@endsection
