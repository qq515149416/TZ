@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div id="overseas_product" class="row">
    @if ($page == 'HKT')
        <div class="banner domestic">
            <div class="title">
                <h2 class="text">服务器租用</h2>
                <h4 class="sub-text">
                    自主准T4、T3机房，从服务器设备、环境到维护的一站式服务，为您提供定制化硬件采购解决方案<br/>
                    以租用的方式独享专用高性能服务器及全完自主管理权限，满足您不同时期业务发展需求！
                </h4>
            </div>
            <div class="bottom">
            @foreach ($son_nav as $nav)
                <a class="btn-link {{ $page == $nav->alias ? 'active' : '' }}" href="/zuyong/{{ $nav->alias }}/{{ $nav->alias=='HKT' ? $room : 'hunan' }}">{{ $nav->name }}</a>
            @endforeach
            </div>
        </div>
    @else
        <div class="banner default">
            <div class="version-heart">
                <h3>
                    海外服务器
                    <span>
                        | 全球服务器租用
                    </span>
                </h3>
                <div class="description">
                    <ul>
                        <li>
                            高品质标准：T级机房，接入国际骨干
                        </li>
                        <li>
                            多配置可选：配置丰富，多配置扩展
                        </li>
                        <li>
                            高性价比：性能＞价格，谁用谁知道
                        </li>
                    </ul>
                </div>
                <div class="bottom">
                    @foreach ($son_nav as $nav)
                    <a class="btn-link {{ $nav->alias == $page ? 'active':'' }}" href="{{ $nav->url }}">
                        {{ $nav->name }}
                    </a>
                    @endforeach
                    <!-- <a class="btn-link" href="javascript:;">欧洲服务器</a> -->
                    <!-- <a class="btn-link active" href="javascript:;">
                        美洲服务器
                    </a> -->
                    <!-- <a class="btn-link" href="javascript:;">非洲服务器</a> -->
                </div>
            </div>
        </div>
    @endif

	<section class="jumbotron data-center">
		<div class="version-heart">
			<h2>
				数据中心
			</h2>
			<div class="main-content">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
                    @foreach ($machine_rooms as $machine_room)
					<li role="presentation" class="{{ $machine_room->alias == $room ? 'active':'' }}">
						<a href="/{{ $page=='HKT' ? 'zuyong' : 'overseas' }}/{{ $page }}/{{ $machine_room->alias }}">
                            {{ $machine_room->name }}
						</a>
					</li>
                    @endforeach
					<!-- <li role="presentation">
						<a href="/overseas/usa">
							美国-洛杉矶
						</a>
					</li> -->
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="usa">
						<h3>
							{{ $current_room->name }}
						</h3>
						<p>
							机房概况：{{ $current_room->overview }}
						</p>
						<div class="data-table">
							<div class="data-table-row">
								<div class="data-table-col thead">
									<div class="table-head-content">
										机房
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										CPU
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										型号
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										线程
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										内存
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										硬盘类型
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										硬盘大小
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										支持硬件升级
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										RAID卡
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										IP数量
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										DDOS
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										带宽
									</div>
								</div>
								<div class="data-table-col thead">
									<div class="table-head-content">
										价格
									</div>
								</div>
							</div>

                            @foreach ($data->filter(function ($value, $key) {
                                return $value->is_enhance == 0;
                            }) as $item)
                                <div class="data-table-row">

                                    <div class="data-table-col thead">
                                        <div class="data-table-content">
                                            @if (count(explode('-',$current_room->name)) > 1)
                                            <span>
                                                {{ explode('-',$current_room->name)[0] }}
                                            </span>
                                            {{ explode('-',$current_room->name)[1] }}
                                            @else
                                            {{ $current_room->name }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            @if (count(explode('\\',$item->cpu)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->cpu)[0] }}
                                                </span>
                                                {{ explode('\\',$item->cpu)[1] }}
                                            @else
                                                {{ $item->cpu }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            @if (count(explode('\\',$item->type)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->type)[0] }}
                                                </span>
                                                {{ explode('\\',$item->type)[1] }}
                                            @else
                                                {{ $item->type }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            @if (count(explode('\\',$item->thread)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->thread)[0] }}
                                                </span>
                                                {{ explode('\\',$item->thread)[1] }}
                                            @else
                                                {{ $item->thread }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            @if (count(explode('\\',$item->ram)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->ram)[0] }}
                                                </span>
                                                {{ explode('\\',$item->ram)[1] }}
                                            @else
                                                {{ $item->ram }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            @if (count(explode('\\',$item->hard_disk_type)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->hard_disk_type)[0] }}
                                                </span>
                                                {{ explode('\\',$item->hard_disk_type)[1] }}
                                            @else
                                                {{ $item->hard_disk_type }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            @if (count(explode('\\',$item->hard_disk_size)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->hard_disk_size)[0] }}
                                                </span>
                                                {{ explode('\\',$item->hard_disk_size)[1] }}
                                            @else
                                                {{ $item->hard_disk_size }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            {{ $item->upgrade  ? '支持':'不支持' }}
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            @if (count(explode('\\',$item->raid_card)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->raid_card)[0] }}
                                                </span>
                                                {{ explode('\\',$item->raid_card)[1] }}
                                            @else
                                                {{ $item->raid_card }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            {{ $item->ips }}
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            @if (count(explode('\\',$item->ddos)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->ddos)[0] }}
                                                </span>
                                                {{ explode('\\',$item->ddos)[1] }}
                                            @else
                                                {{ $item->ddos }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            @foreach (explode(',',$item->bandwidth) as $item_bandwidth)
                                            <p>
                                                @if (count(explode('\\',$item_bandwidth)) > 1)
                                                    {!! preg_replace('/(\d+[A-Z]{1})/','<span class="attr">$1&nbsp;</span>',explode('\\',$item_bandwidth)[0]) !!}
                                                    <span class="wrap">
                                                        {!! preg_replace('/(\d+[A-Z]{1})/','<span class="attr">$1&nbsp;</span>',explode('\\',$item_bandwidth)[1]) !!}
                                                    </span>
                                                @else
                                                    {!! preg_replace('/(\d+[A-Z]{1})/','<span class="attr">$1&nbsp;</span>',$item_bandwidth) !!}
                                                @endif
                                                <!-- <span class="attr">
                                                    30M
                                                </span>
                                                优化回国带宽 -->
                                                <!-- <span class="wrap">
                                                    (包含<span class="attr">5M</span> CN2优化回国)
                                                </span> -->
                                            </p>
                                            @endforeach
                                            <!-- <p>
                                                <span class="attr">
                                                    100M
                                                </span>
                                                普通带宽
                                            </p> -->
                                        </div>
                                    </div>
                                    <div class="data-table-col">
                                        <div class="data-table-content">
                                            <span class="amount">
                                                {{ $item->price }}
                                            </span>
                                            {{ $item->unit }}
                                        </div>
                                    </div>

                                </div>
                            @endforeach

							<!-- <div class="data-table-row">
								<div class="data-table-col thead">
									<div class="data-table-content">
										<span>
											美国
										</span>
										圣何塞机房
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										2*E5
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										2660
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										16核32线程
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										32G
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										SSD+ HDD
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										240G +1T
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										否
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										/
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										1
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										/
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										<p>
                                            <span class="attr">
                                                30M
                                            </span>
                                            优化回国带宽
                                            <span class="wrap">
                                                (包含<span class="attr">5M</span> CN2优化回国)
                                            </span>
										</p>
										<p>
											<span class="attr">
												100M
											</span>
											普通带宽
										</p>
									</div>
								</div>
								<div class="data-table-col">
									<div class="data-table-content">
										<span class="amount">
											2400.00
										</span>
										元/月
									</div>
								</div>
							</div>
                             -->
						</div>
						<div class="expand" style="{{ count($data->filter(function ($value, $key) {
                                return $value->is_enhance == 1;
                            })) > 0 ? 'display: block' : 'display: none;'  }}">
							<h3>
								增强服务器
							</h3>
							<div class="data-table">
								<div class="data-table-row">
									<div class="data-table-col thead">
										<div class="table-head-content">
											平台
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											CPU
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											型号
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											线程
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											内存
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											硬盘类型
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											硬盘大小
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											支持硬件升级
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											RAID卡
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											网卡
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											IP数量
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											DDOS
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											带宽&nbsp;
											<span class="label-text">
												(3&nbsp;选&nbsp;1)
											</span>
										</div>
									</div>
									<div class="data-table-col thead">
										<div class="table-head-content">
											价格&nbsp;
											<span class="label-mark">
												活动中
											</span>
										</div>
									</div>
								</div>

                                @foreach ($data->filter(function ($value, $key) {
                                    return $value->is_enhance == 1;
                                }) as $item)

                                <div class="data-table-row">
									<div class="data-table-col thead">
										<div class="data-table-content">
                                            @if (count(explode('\\',$item->more['platform'])) > 1)
                                                <span>
                                                    {{ explode('\\',$item->more['platform'])[0] }}
                                                </span>
                                                {{ explode('\\',$item->more['platform'])[1] }}
                                            @else
                                                {{ $item->more['platform'] }}
                                            @endif
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            @if (count(explode('\\',$item->cpu)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->cpu)[0] }}
                                                </span>
                                                {{ explode('\\',$item->cpu)[1] }}
                                            @else
                                                {{ $item->cpu }}
                                            @endif
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            @if (count(explode('\\',$item->type)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->type)[0] }}
                                                </span>
                                                {{ explode('\\',$item->type)[1] }}
                                            @else
                                                {{ $item->type }}
                                            @endif
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            @if (count(explode('\\',$item->thread)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->thread)[0] }}
                                                </span>
                                                {{ explode('\\',$item->thread)[1] }}
                                            @else
                                                {{ $item->thread }}
                                            @endif
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            @if (count(explode('\\',$item->ram)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->ram)[0] }}
                                                </span>
                                                {{ explode('\\',$item->ram)[1] }}
                                            @else
                                                {{ $item->ram }}
                                            @endif
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            @if (count(explode('\\',$item->hard_disk_type)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->hard_disk_type)[0] }}
                                                </span>
                                                {{ explode('\\',$item->hard_disk_type)[1] }}
                                            @else
                                                {{ $item->hard_disk_type }}
                                            @endif
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            @if (count(explode('\\',$item->hard_disk_size)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->hard_disk_size)[0] }}
                                                </span>
                                                {{ explode('\\',$item->hard_disk_size)[1] }}
                                            @else
                                                {{ $item->hard_disk_size }}
                                            @endif
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            {{ $item->upgrade  ? '支持':'不支持' }}
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            @if (count(explode('\\',$item->raid_card)) > 1)
                                                <span>
                                                    {{ explode('\\',$item->raid_card)[0] }}
                                                </span>
                                                {{ explode('\\',$item->raid_card)[1] }}
                                            @else
                                                {{ $item->raid_card }}
                                            @endif
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            @if (count(explode('\\',$item->more['network_card'])) > 1)
                                                <span>
                                                    {{ explode('\\',$item->more['network_card'])[0] }}
                                                </span>
                                                {{ explode('\\',$item->more['network_card'])[1] }}
                                            @else
                                                {{ $item->more['network_card'] }}
                                            @endif
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            {{ $item->ips }}
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            {{ $item->ddos }}
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
                                            @foreach (explode(',',$item->bandwidth) as $item_bandwidth)
                                            <p>
                                                @if (count(explode('\\',$item_bandwidth)) > 1)
                                                    {!! preg_replace('/(\d+[A-Z]{1})/','<span class="attr">$1&nbsp;</span>',explode('\\',$item_bandwidth)[0]) !!}
                                                    <span class="wrap">
                                                        {!! preg_replace('/(\d+[A-Z]{1})/','<span class="attr">$1&nbsp;</span>',explode('\\',$item_bandwidth)[1]) !!}
                                                    </span>
                                                @else
                                                    {!! preg_replace('/(\d+[A-Z]{1})/','<span class="attr">$1&nbsp;</span>',$item_bandwidth) !!}
                                                @endif
                                                <!-- <span class="attr">
                                                    30M
                                                </span>
                                                优化回国带宽 -->
                                                <!-- <span class="wrap">
                                                    (包含<span class="attr">5M</span> CN2优化回国)
                                                </span> -->
                                            </p>
                                            @endforeach
											<!-- <p>
												<span class="attr">
													30M
												</span>
												优化回国
											</p>
											<p>
												<span class="attr">
													100M
												</span>
												普通回国
											</p>
											<p>
												<span class="attr">
													100M
												</span>
												国际带宽
											</p> -->
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											<span class="amount">
                                                {{ $item->price }}
											</span>
											{{ $item->unit }}
										</div>
									</div>
								</div>

                                @endforeach
								<!-- <div class="data-table-row">
									<div class="data-table-col thead">
										<div class="data-table-content">
											<span>
												Dell
											</span>
											R630
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											2*E5
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											<span>
												E5-2630
											</span>
											v3*2
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											16核32线程
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											<span>
												64G
											</span>
											DDR4
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											<span>
												2.5寸 Intel
											</span>
											企业级 SSD
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											4*960G
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											是
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											<span>
												标配2G
											</span>
											缓存阵列卡
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											<span>
												标配10G
											</span>
											双光口
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											1
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											支持
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											<p>
												<span class="attr">
													30M
												</span>
												优化回国
											</p>
											<p>
												<span class="attr">
													100M
												</span>
												普通回国
											</p>
											<p>
												<span class="attr">
													100M
												</span>
												国际带宽
											</p>
										</div>
									</div>
									<div class="data-table-col">
										<div class="data-table-content">
											<span class="amount">
												3980.00
											</span>
											元/月
										</div>
									</div>
								</div> -->


							</div>
							<div class="explanation">
								<p>
									<span>
										1、
										<strong>
											定义
										</strong>
										：
									</span>
									<span>
										增强型服务器产品是一款为解决原有节点服务器扩展性能和稳定性不足、带宽不支持增加多种带宽的需求等问题。采用Dell品牌服务器，标配2G硬件raid卡，服务器可根据客户需
										求增加各种类型的带宽，设备硬件扩展性能强而设计的一款产品，该产品支持多种类型的带宽。
									</span>
								</p>
								<p>
									<span>
										2、
										<strong>
											适用范围
										</strong>
										：
									</span>
									<span>
										适用于客户对计算处理速度快、数据冗余性高、大容量存储、IOPS读写速度快，特别推出基础型、计算型、存储型和高I/0型。
									</span>
								</p>
								<p>
									<span>
										3、
										<strong>
											产品架构
										</strong>
										：
									</span>
									<span>
										增强型产品主要由物理服务器+多种带宽类型+单国际IP组成，IP种类为普通回国、优化回国、国际带宽类型。
									</span>
								</p>
								<p>
									<span>
										4、
										<strong>
											服务器系统支持
										</strong>
										：
									</span>
									<span>
										Windows、Linux、WM ware（Esxi）、Xenserver 。
									</span>
								</p>
								<p>
									<span>
										5、
										<strong>
											计费方式
										</strong>
										：
									</span>
									<span>
										硬件增值和IP租用按“服务器租用增值服务”计算；带宽增值计算方式，按此表后端附的“<a href="{{ asset('/resource/2019-11-11增值服务报价表.xls') }}">增值带宽计算方法</a>”。
									</span>
								</p>
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>
    </section>
    <section class="feature">
        <div class="version-heart">
            <ul>
                <li>全球一线机房</li>
                <li>多配置支持</li>
                <li>多IP可选</li>
                <li>高性价比</li>
                <li>稳定高可用达99.99%</li>
                <li>24小时售后服务支持</li>
            </ul>
        </div>
    </section>
    <section class="jumbotron footer">
        <h4>腾正{{ $page=='HKT' ? '' : '海外' }}服务器租用-帮您实现全球快速安全的资源部署</h4>
        <a href="javascript:;">立即咨询</a>
    </section>
</div>
@endsection
