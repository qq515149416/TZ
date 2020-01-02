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
                <li role="presentation" class="active pr-3">
                    <a href="#all" class="px-3 py-2 font-medium" aria-controls="all" role="tab" data-toggle="tab">全&nbsp;部</a>
                </li>
                <li role="presentation" class="pr-3">
                    <a href="#huizhou" class="px-3 py-2 font-medium" aria-controls="huizhou" role="tab" data-toggle="tab">惠&nbsp;州</a>
                </li>
                <li role="presentation" class="pr-3">
                    <a href="#hengyang" class="px-3 py-2 font-medium" aria-controls="hengyang" role="tab" data-toggle="tab">衡&nbsp;阳</a>
                </li>
                <li role="presentation" class="pr-3">
                    <a href="#xian" class="px-3 py-2 font-medium" aria-controls="xian" role="tab" data-toggle="tab">西&nbsp;安</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="all">
                    <div class="tip rounded px-4 py-3 mt-4 font-medium">
                        腾正云服务器旨在为用户提供优质、高效、弹性伸缩的云计算服务。采用由数据切片技术构建的三层存储功能，切实保护客户数据的安全；弹性扩展的资源用量，为业务高峰期的顺畅保驾护航；灵活多样的计费方式，为客户节省IT运营成本，提高资源有效利用率。
                    </div>
                    <div class="toolbar clearfix mt-4">
                        <div class="float-right d-flex align-items-center">
                            <button type="button" class="btn btn-primary font-regular mr-2 py-2 px-3 active">全部</button>
                            <button type="button" class="btn btn-primary font-regular mr-2 py-2 px-3">1天过期</button>
                            <button type="button" class="btn btn-primary font-regular mr-2 py-2 px-3">3天过期</button>
                            <button type="button" class="btn btn-primary font-regular py-2 px-3">7天过期</button>
                            <form class="form-inline">
                                <div class="form-group mx-2">
                                    <label for="inputSearch" class="sr-only">Search</label>
                                    <input type="text" class="form-control" id="inputSearch" placeholder="IP/ 机器ID/ 名称">
                                </div>
                                <button type="submit" class="btn btn-primary font-regular py-2 px-3 border-0">搜索</button>
                            </form>
                        </div>
                    </div>
                    <table 
                    class="data font-heavy mt-3" 
                    id="table_data" 
                    data-pagination-loop="false" 
                    data-page-size="5" 
                    data-pagination="true" 
                    data-toggle="table" 
                    data-click-to-select="true" 
                    data-mobile-responsive="true"
                    data-check-on-init="true"
                    data-locale="zh-CN">
                        <thead>
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th>IP地址</th>
                                <th>名称</th>
                                <th>操作系统</th>
                                <th>带宽</th>
                                <th>防御</th>
                                <th>所在地区</th>
                                <th>配置信息</th>
                                <th>硬盘</th>
                                <th>起始时间</th>
                                <th>到期时间</th>
                                <th>价格</th>                                
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody class="font-regular">
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>                                
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2" data-toggle="modal" data-target="#renewModal">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>103.218.2.206</td>
                                <td>服务器-20180930181438.8473</td>
                                <td>CentOS 7.5 64位</td>
                                <td>5M</td>
                                <td>0G</td>
                                <td>惠州</td>
                                <td>CPU:1核心 内存：1G</td>
                                <td>20G</td>
                                <td>2020/01/01</td>
                                <td>2020/02/01</td>
                                <td>￥145</td>
                                <td>
                                    <span class="play mr-2">支付</span>
                                    <span class="renew mr-2">续费</span>
                                    <span class="view">查看</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="tip rounded px-4 py-3 mt-4 font-medium">
                        <p class="mb-2">若服务器有特殊情况在到期后仍需保留多两天可提交备注反馈给我们.位置:服务器->更多->修改名称->备注</p>
                        <p class="mb-1">帮助文档：《Windows磁盘挂载文档》</p>
                        <p class="mb-0">帮助文档：《Linux磁盘挂载文档》</p>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="huizhou">惠州</div>
                <div role="tabpanel" class="tab-pane" id="hengyang">衡阳</div>
                <div role="tabpanel" class="tab-pane" id="xian">西安</div>
            </div>

        </div>
    </div>
</div>
@endsection