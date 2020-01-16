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
<div id="server" class="container-fluid px-4">
    <div class="paper bg-white mt-4 py-3 px-4 rounded">
        <div class="server-tab">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs px-3 pb-4 pt-3" role="tablist">
                <li role="presentation" class="pr-3">
                    <a href="#all" class="px-3 py-2 font-medium active" data-filter="all" aria-controls="all" role="tab" data-toggle="tab">全&nbsp;部</a>
                </li>
                <li role="presentation" class="pr-3">
                    <a href="#huizhou" class="px-3 py-2 font-medium" data-filter="广东惠州" aria-controls="huizhou" role="tab" data-toggle="tab">惠&nbsp;州</a>
                </li>
                <li role="presentation" class="pr-3">
                    <a href="#hengyang" class="px-3 py-2 font-medium" data-filter="湖南衡阳" aria-controls="hengyang" role="tab" data-toggle="tab">衡&nbsp;阳</a>
                </li>
                <li role="presentation" class="pr-3 mt-3 mt-md-0 mt-lg-0">
                    <a href="#xian" class="px-3 py-2 font-medium" data-filter="陕西西安" aria-controls="xian" role="tab" data-toggle="tab">西&nbsp;安</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="all">
                    <div class="tip rounded px-4 py-3 mt-4 font-medium">
                        腾正云服务器旨在为用户提供优质、高效、弹性伸缩的云计算服务。采用由数据切片技术构建的三层存储功能，切实保护客户数据的安全；弹性扩展的资源用量，为业务高峰期的顺畅保驾护航；灵活多样的计费方式，为客户节省IT运营成本，提高资源有效利用率。
                    </div>
                    <div class="toolbar clearfix mt-4">
                        <div class="float-right d-flex align-items-center flex-wrap">
                            <button type="button" data-filter="all" data-from="all" class="btn btn-primary font-regular mr-2 py-2 px-3 active">全部</button>
                            <button type="button" data-filter="1" data-from="all" class="btn btn-primary font-regular mr-2 py-2 px-3">1天过期</button>
                            <button type="button" data-filter="3" data-from="all" class="btn btn-primary font-regular mr-2 py-2 px-3">3天过期</button>
                            <button type="button" data-filter="7" data-from="all" class="btn btn-primary font-regular py-2 px-3 mt-2 mt-md-0 mt-xl-0">7天过期</button>
                            <form class="form-inline mt-2 mt-md-0 mt-xl-0" data-from="all">
                                <div class="form-group mx-md-2 mx-lg-2 mb-0">
                                    <label for="inputSearch" class="sr-only">Search</label>
                                    <input type="text" class="form-control" id="inputSearch" placeholder="IP/ 机器ID/ 名称">
                                </div>
                                <button type="submit" class="btn btn-primary font-regular py-md-2 py-lg-2 px-3 ml-2 ml-md-0 ml-lg-0 border-0">搜索</button>
                            </form>
                        </div>
                    </div>
                    <table 
                    class="data font-heavy mt-3" 
                    id="table_data" 
                    data-url="/home/customer/businessList"
                    data-response-handler="process_data"
                    data-row-style="rowStyle"
                    data-pagination-loop="false" 
                    data-page-size="10" 
                    data-pagination="true" 
                    data-toggle="table" 
                    data-click-to-select="true" 
                    data-mobile-responsive="true"
                    data-check-on-init="true"
                    data-locale="zh-CN">
                        <thead>
                            <tr>
                                <th data-checkbox="true"></th>
                                <th data-field="ip" data-formatter="ipFormatter">IP地址</th>
                                <th data-field="machine_number">名称</th>
                                <!-- <th>操作系统</th> -->
                                <th data-field="bandwidth" data-formatter="bandwidthFormatter">带宽</th>
                                <th data-field="protect" data-formatter="protectFormatter">防御</th>
                                <th data-field="machineroom_name">所在地区</th>
                                <th data-field="resource_detail" data-formatter="resourceDetailFormatter">配置信息</th>
                                <th data-field="harddisk" data-formatter="harddiskFormatter">硬盘</th>
                                <th data-field="created_at" data-formatter="createdAtFormatter">起始时间</th>
                                <th data-field="endding_time">到期时间</th>
                                <th data-field="money">价格</th>                                
                                <th data-field="operat" data-formatter="operatFormatter">操作</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="tip rounded px-4 py-3 mt-4 font-medium">
                        <p class="mb-2">若服务器有特殊情况在到期后仍需保留多两天可提交备注反馈给我们.位置:服务器->更多->修改名称->备注</p>
                        <p class="mb-1">帮助文档：《Windows磁盘挂载文档》</p>
                        <p class="mb-0">帮助文档：《Linux磁盘挂载文档》</p>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="huizhou">
                
                    <div class="tip rounded px-4 py-3 mt-4 font-medium">
                            腾正云服务器旨在为用户提供优质、高效、弹性伸缩的云计算服务。采用由数据切片技术构建的三层存储功能，切实保护客户数据的安全；弹性扩展的资源用量，为业务高峰期的顺畅保驾护航；灵活多样的计费方式，为客户节省IT运营成本，提高资源有效利用率。
                        </div>
                        <div class="toolbar clearfix mt-4">
                            <div class="float-right d-flex align-items-center flex-wrap">
                                <button type="button" data-filter="all" data-from="huizhou" class="btn btn-primary font-regular mr-2 py-2 px-3 active">全部</button>
                                <button type="button" data-filter="1" data-from="huizhou" class="btn btn-primary font-regular mr-2 py-2 px-3">1天过期</button>
                                <button type="button" data-filter="3" data-from="huizhou" class="btn btn-primary font-regular mr-2 py-2 px-3">3天过期</button>
                                <button type="button" data-filter="7" data-from="huizhou" class="btn btn-primary font-regular py-2 px-3 mt-2 mt-md-0 mt-xl-0">7天过期</button>
                                <form class="form-inline mt-2 mt-md-0 mt-xl-0" data-from="huizhou">
                                    <div class="form-group mx-md-2 mx-lg-2 mb-0">
                                        <label for="inputSearch" class="sr-only">Search</label>
                                        <input type="text" class="form-control" id="inputSearch" placeholder="IP/ 机器ID/ 名称">
                                    </div>
                                    <button type="submit" class="btn btn-primary font-regular py-md-2 py-lg-2 px-3 ml-2 ml-md-0 ml-lg-0 border-0">搜索</button>
                                </form>
                            </div>
                        </div>
                        <table 
                        class="data font-heavy mt-3" 
                        id="table_data" 
                        data-url="/home/customer/businessList"
                        data-response-handler="process_data"
                        data-row-style="rowStyle"
                        data-pagination-loop="false" 
                        data-page-size="10" 
                        data-pagination="true" 
                        data-toggle="table" 
                        data-click-to-select="true" 
                        data-mobile-responsive="true"
                        data-check-on-init="true"
                        data-locale="zh-CN">
                            <thead>
                                <tr>
                                    <th data-checkbox="true"></th>
                                    <th data-field="ip" data-formatter="ipFormatter">IP地址</th>
                                    <th data-field="machine_number">名称</th>
                                    <!-- <th>操作系统</th> -->
                                    <th data-field="bandwidth" data-formatter="bandwidthFormatter">带宽</th>
                                    <th data-field="protect" data-formatter="protectFormatter">防御</th>
                                    <th data-field="machineroom_name">所在地区</th>
                                    <th data-field="resource_detail" data-formatter="resourceDetailFormatter">配置信息</th>
                                    <th data-field="harddisk" data-formatter="harddiskFormatter">硬盘</th>
                                    <th data-field="created_at" data-formatter="createdAtFormatter">起始时间</th>
                                    <th data-field="endding_time">到期时间</th>
                                    <th data-field="money">价格</th>                                
                                    <th data-field="operat" data-formatter="operatFormatter">操作</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="tip rounded px-4 py-3 mt-4 font-medium">
                            <p class="mb-2">若服务器有特殊情况在到期后仍需保留多两天可提交备注反馈给我们.位置:服务器->更多->修改名称->备注</p>
                            <p class="mb-1">帮助文档：《Windows磁盘挂载文档》</p>
                            <p class="mb-0">帮助文档：《Linux磁盘挂载文档》</p>
                        </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="hengyang">
                
                        <div class="tip rounded px-4 py-3 mt-4 font-medium">
                            腾正云服务器旨在为用户提供优质、高效、弹性伸缩的云计算服务。采用由数据切片技术构建的三层存储功能，切实保护客户数据的安全；弹性扩展的资源用量，为业务高峰期的顺畅保驾护航；灵活多样的计费方式，为客户节省IT运营成本，提高资源有效利用率。
                        </div>
                        <div class="toolbar clearfix mt-4">
                            <div class="float-right d-flex align-items-center flex-wrap">
                                <button type="button" data-filter="all" data-from="hengyang" class="btn btn-primary font-regular mr-2 py-2 px-3 active">全部</button>
                                <button type="button" data-filter="1" data-from="hengyang" class="btn btn-primary font-regular mr-2 py-2 px-3">1天过期</button>
                                <button type="button" data-filter="3" data-from="hengyang" class="btn btn-primary font-regular mr-2 py-2 px-3">3天过期</button>
                                <button type="button" data-filter="7" data-from="hengyang" class="btn btn-primary font-regular py-2 px-3 mt-2 mt-md-0 mt-xl-0">7天过期</button>
                                <form class="form-inline mt-2 mt-md-0 mt-xl-0" data-from="hengyang">
                                    <div class="form-group mx-md-2 mx-lg-2 mb-0">
                                        <label for="inputSearch" class="sr-only">Search</label>
                                        <input type="text" class="form-control" id="inputSearch" placeholder="IP/ 机器ID/ 名称">
                                    </div>
                                    <button type="submit" class="btn btn-primary font-regular py-md-2 py-lg-2 px-3 ml-2 ml-md-0 ml-lg-0 border-0">搜索</button>
                                </form>
                            </div>
                        </div>
                        <table 
                        class="data font-heavy mt-3" 
                        id="table_data" 
                        data-url="/home/customer/businessList"
                        data-response-handler="process_data"
                        data-row-style="rowStyle"
                        data-pagination-loop="false" 
                        data-page-size="10" 
                        data-pagination="true" 
                        data-toggle="table" 
                        data-click-to-select="true" 
                        data-mobile-responsive="true"
                        data-check-on-init="true"
                        data-locale="zh-CN">
                            <thead>
                                <tr>
                                    <th data-checkbox="true"></th>
                                    <th data-field="ip" data-formatter="ipFormatter">IP地址</th>
                                    <th data-field="machine_number">名称</th>
                                    <!-- <th>操作系统</th> -->
                                    <th data-field="bandwidth" data-formatter="bandwidthFormatter">带宽</th>
                                    <th data-field="protect" data-formatter="protectFormatter">防御</th>
                                    <th data-field="machineroom_name">所在地区</th>
                                    <th data-field="resource_detail" data-formatter="resourceDetailFormatter">配置信息</th>
                                    <th data-field="harddisk" data-formatter="harddiskFormatter">硬盘</th>
                                    <th data-field="created_at" data-formatter="createdAtFormatter">起始时间</th>
                                    <th data-field="endding_time">到期时间</th>
                                    <th data-field="money">价格</th>                                
                                    <th data-field="operat" data-formatter="operatFormatter">操作</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="tip rounded px-4 py-3 mt-4 font-medium">
                            <p class="mb-2">若服务器有特殊情况在到期后仍需保留多两天可提交备注反馈给我们.位置:服务器->更多->修改名称->备注</p>
                            <p class="mb-1">帮助文档：《Windows磁盘挂载文档》</p>
                            <p class="mb-0">帮助文档：《Linux磁盘挂载文档》</p>
                        </div>
                
                </div>
                <div role="tabpanel" class="tab-pane" id="xian">
                
                        <div class="tip rounded px-4 py-3 mt-4 font-medium">
                            腾正云服务器旨在为用户提供优质、高效、弹性伸缩的云计算服务。采用由数据切片技术构建的三层存储功能，切实保护客户数据的安全；弹性扩展的资源用量，为业务高峰期的顺畅保驾护航；灵活多样的计费方式，为客户节省IT运营成本，提高资源有效利用率。
                        </div>
                        <div class="toolbar clearfix mt-4">
                            <div class="float-right d-flex align-items-center flex-wrap">
                                <button type="button" data-filter="all" data-from="xian" class="btn btn-primary font-regular mr-2 py-2 px-3 active">全部</button>
                                <button type="button" data-filter="1" data-from="xian" class="btn btn-primary font-regular mr-2 py-2 px-3">1天过期</button>
                                <button type="button" data-filter="3" data-from="xian" class="btn btn-primary font-regular mr-2 py-2 px-3">3天过期</button>
                                <button type="button" data-filter="7" data-from="xian" class="btn btn-primary font-regular py-2 px-3 mt-2 mt-md-0 mt-xl-0">7天过期</button>
                                <form class="form-inline mt-2 mt-md-0 mt-xl-0" data-from="xian">
                                    <div class="form-group mx-md-2 mx-lg-2 mb-0">
                                        <label for="inputSearch" class="sr-only">Search</label>
                                        <input type="text" class="form-control" id="inputSearch" placeholder="IP/ 机器ID/ 名称">
                                    </div>
                                    <button type="submit" class="btn btn-primary font-regular py-md-2 py-lg-2 px-3 ml-2 ml-md-0 ml-lg-0 border-0">搜索</button>
                                </form>
                            </div>
                        </div>
                        <table 
                        class="data font-heavy mt-3" 
                        id="table_data" 
                        data-url="/home/customer/businessList"
                        data-response-handler="process_data"
                        data-row-style="rowStyle"
                        data-pagination-loop="false" 
                        data-page-size="10" 
                        data-pagination="true" 
                        data-toggle="table" 
                        data-click-to-select="true" 
                        data-mobile-responsive="true"
                        data-check-on-init="true"
                        data-locale="zh-CN">
                            <thead>
                                <tr>
                                    <th data-checkbox="true"></th>
                                    <th data-field="ip" data-formatter="ipFormatter">IP地址</th>
                                    <th data-field="machine_number">名称</th>
                                    <!-- <th>操作系统</th> -->
                                    <th data-field="bandwidth" data-formatter="bandwidthFormatter">带宽</th>
                                    <th data-field="protect" data-formatter="protectFormatter">防御</th>
                                    <th data-field="machineroom_name">所在地区</th>
                                    <th data-field="resource_detail" data-formatter="resourceDetailFormatter">配置信息</th>
                                    <th data-field="harddisk" data-formatter="harddiskFormatter">硬盘</th>
                                    <th data-field="created_at" data-formatter="createdAtFormatter">起始时间</th>
                                    <th data-field="endding_time">到期时间</th>
                                    <th data-field="money">价格</th>                                
                                    <th data-field="operat" data-formatter="operatFormatter">操作</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="tip rounded px-4 py-3 mt-4 font-medium">
                            <p class="mb-2">若服务器有特殊情况在到期后仍需保留多两天可提交备注反馈给我们.位置:服务器->更多->修改名称->备注</p>
                            <p class="mb-1">帮助文档：《Windows磁盘挂载文档》</p>
                            <p class="mb-0">帮助文档：《Linux磁盘挂载文档》</p>
                        </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection