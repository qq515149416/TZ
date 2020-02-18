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
<div id="detail" data-businessid="{{ $data->id }}" data-ip="{{ $data->ip }}" class="container-fluid px-4 pt-3">
    <div class="container-fluid pl-4">
        <div class="row">
            <div class="left-w">
                <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                    <div class="paper-title border-bottom font-medium pb-3">
                        基本信息
                    </div>
                    <div class="paper-content font-medium pt-3">
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">业务编号</span>
                          <span class="val">{{ $data->business_number }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">业务类型</span>
                          <span class="val">{{ $data->resource_type }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">机器编号</span>
                          <span class="val">{{ $data->machine_number }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">业务状态</span>
                          <span class="val">{{ $data->status }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">所属地区</span>
                          <span class="val">{{ $data->machineroom }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">账号</span>
                          <span class="val">{{ $data->loginname }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">密码</span>
                          <span class="val">{{ $data->loginpass }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">单价</span>
                          <span class="val">￥{{ $data->money }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">使用时长</span>
                          <span class="val">{{ $data->length }}</span>
                      </p>
                      <p class="d-flex mb-0">
                          <span class="attr mr-3">备注</span>
                          <span class="val"></span>
                      </p>
                    </div>
                </div>
                <div class="paper jumbotron-fluid rounded bg-white px-4 py-4 mt-4">
                    <div class="paper-title border-bottom font-medium pb-3">
                        配置信息
                    </div>
                    <div class="paper-content font-medium pt-3">
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">CPU</span>
                          <span class="val">{{ $data->cpu }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">内存</span>
                          <span class="val">{{ $data->memory }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">机器编号</span>
                          <span class="val">{{ $data->machine_number }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">硬盘</span>
                          <span class="val">{{ $data->harddisk }}</span>
                      </p>
                      <!-- <p class="d-flex mb-3">
                          <span class="attr mr-3">操作系统</span>
                          <span class="val">CentOS 7.5 64位</span>
                      </p> -->
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">公网IP</span>
                          <span class="val">{{ $data->ip }}</span>
                      </p>
                      <p class="d-flex mb-3">
                          <span class="attr mr-3">带宽</span>
                          <span class="val">{{ $data->bandwidth }}M</span>
                      </p>
                      <p class="d-flex mb-0">
                          <span class="attr mr-3">防御</span>
                          <span class="val">{{ $data->protected }}</span>
                      </p>
                    </div>
                </div>
            </div>
            <div class="w-100 d-block d-md-none d-xl-none">
            </div>
            <div class="col">
                
                <div class="container-fluid echarts">
                    <div class="row">
                        <div class="col mt-4 mt-md-0 mt-lg-0">
                            <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                                <div class="paper-title font-medium d-flex align-items-center">
                                    <h4 class="mx-0 my-0 mr-3">
                                        带宽使用情况
                                    </h4>
                                    <span>单位为 m</span>
                                </div>
                                <div class="tip-date mt-2 d-flex justify-content-between align-items-center mb-4 flex-wrap flex-md-nowrap flex-lg-nowrap">
                                    <div class="tip d-flex mb-2 mb-md-0 mb-lg-0">
                                        <span class="upload font-medium mr-3">
                                            上传流量
                                        </span>
                                        <span class="download font-medium">
                                            下载流量
                                        </span>
                                    </div>
                                    <div class="date font-medium d-flex justify-content-end align-items-center">
                                        <span class="mr-2">
                                            日期
                                        </span>
                                        <input type="text" class="form-control w-75" id="selectDate">
                                    </div>
                                </div>
                                <!-- <img src="{{ asset("/user_assets/html_img/empty.png") }}" class="w-100" /> -->
                                <div id="flow_echars" style="height: 269px;" data-business-ip="{{ $data->ip }}" data-business-id="{{ $data->id }}" class="w-100">
                                </div>
                            </div>
                        </div>
                        <div class="col mt-4 mt-md-0 mt-lg-0">
                            <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                                <div class="paper-title font-medium d-flex align-items-center">
                                    <h4 class="mx-0 my-0 mr-3">
                                        内存使用情况
                                    </h4>
                                    <span>单位为 %</span>
                                </div>
                                <div class="tip-date mt-2 d-flex justify-content-between align-items-center mb-4">
                                    <div class="tip d-flex">
                                        <!-- <span class="upload font-medium mr-3">
                                            上传流量
                                        </span>
                                        <span class="download font-medium">
                                            下载流量
                                        </span> -->
                                    </div>
                                    <div class="date font-medium d-flex justify-content-end align-items-center">
                                        <span class="mr-2">
                                            日期
                                        </span>
                                        <input type="text" class="form-control w-75" id="selectDate">
                                    </div>
                                </div>
                                <img style="height: 269px;" src="{{ asset("/user_assets/html_img/empty.png") }}" class="w-100" />
                            </div>
                        </div>
                        <div class="w-100 pb-4 pt-1"></div>
                        <div class="col">
                            <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                                <div class="paper-title font-medium d-flex align-items-center">
                                    <h4 class="mx-0 my-0 mr-3">
                                        磁盘使用情况
                                    </h4>
                                    <span>单位为 %</span>
                                </div>
                                <div class="tip-date mt-2 d-flex justify-content-between align-items-center mb-4">
                                    <div class="tip d-flex">
                                        <!-- <span class="upload font-medium mr-3">
                                            上传流量
                                        </span>
                                        <span class="download font-medium">
                                            下载流量
                                        </span> -->
                                    </div>
                                    <div class="date font-medium d-flex justify-content-end align-items-center">
                                        <span class="mr-2">
                                            日期
                                        </span>
                                        <input type="text" class="form-control w-75" id="selectDate">
                                    </div>
                                </div>
                                <img style="height: 269px;" src="{{ asset("/user_assets/html_img/empty.png") }}" class="w-100" />
                            </div>
                        </div>
                        <div class="col mt-4 mt-md-0 mt-lg-0">
                            <div class="paper jumbotron-fluid rounded bg-white px-4 py-4">
                                <div class="paper-title font-medium d-flex align-items-center">
                                    <h4 class="mx-0 my-0 mr-3">
                                        CPU使用情况
                                    </h4>
                                    <span>单位为 %</span>
                                </div>
                                <div class="tip-date mt-2 d-flex justify-content-between align-items-center mb-4">
                                    <div class="tip d-flex">
                                        <!-- <span class="upload font-medium mr-3">
                                            上传流量
                                        </span>
                                        <span class="download font-medium">
                                            下载流量
                                        </span> -->
                                    </div>
                                    <div class="date font-medium d-flex justify-content-end align-items-center">
                                        <span class="mr-2">
                                            日期
                                        </span>
                                        <input type="text" class="form-control w-75" id="selectDate">
                                    </div>
                                </div>
                                <img style="height: 269px;" src="{{ asset("/user_assets/html_img/empty.png") }}" class="w-100" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection