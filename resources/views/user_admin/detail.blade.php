@extends('layouts.user')

@section('title', '新用户后台')

@section('tab')
    <ul class="px-0 py-0 mx-0 my-0 top-nav d-none d-md-flex d-lg-flex justify-content-center flex-fill">
        <li class="mr-4">
            <a class="px-4 py-2 rounded active font-medium" href="javascript:;">服务器</a>
        </li>
        <li>
            <a class="px-4 py-2 rounded font-medium" href="javascript:;">订单</a>
        </li>
    </ul>
@endsection

@section('mobile_tab')
<ul class="px-0 py-0 mx-0 my-0 top-nav d-md-none d-lg-none d-flex flex-fill">
    <li class="flex-fill">
        <a class="px-4 py-3 active font-medium" href="javascript:;">服务器</a>
    </li>
    <li class="flex-fill">
        <a class="px-4 py-3 font-medium" href="javascript:;">订单</a>
    </li>
</ul>
@endsection

@section('content')


@endsection