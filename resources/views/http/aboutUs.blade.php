
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
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">...</div>
                <div role="tabpanel" class="tab-pane" id="profile">...</div>
                <div role="tabpanel" class="tab-pane" id="messages">...</div>
                <div role="tabpanel" class="tab-pane" id="settings">...</div>
            </div>
        </article>
    </div>
@endsection
