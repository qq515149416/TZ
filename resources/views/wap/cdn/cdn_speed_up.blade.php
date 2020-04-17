@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- CDN加速 -->
<div id="CDN_speed_up">
		<div class="main-body">
			<div class="tz-container clear">

				<!-- 内容 -->
				<div class="main-content">
					<div class="posters">
						<img src="{{ asset("/images/wap/CDN加速海报.png") }}" alt="">
						<a class="posters-btn posters-left">了解更多</a>
					</div>
					<div class="accelerate_class">
						<ul class="clear">
							<li>
								<a href="/wap/cdn/sca">静态加速</a>
							</li>
							<li><a href="/wap/cdn/dda">下载加速</a></li>
							<li><a href="/wap/cdn/dsa">动态加速</a></li>
							<li><a href="/wap/cdn/smvoda">点播加速</a></li>
							<li><a href="/wap/cdn/smlba">直播加速</a></li>
						</ul>
					</div>
					<!-- CDN加速 -->
					<div class="CDN_up">
						<div class="class-item-a">
							<div class="CDN_speedup">
								<div class="tz-fuwu">
									<div class="tz-main">
										<div class="tz-fuwu-box">
											<div class="title">
												<p>CDN加速套餐推荐</p>
												<div class="title-hr"></div>
											</div>
											<div class="fuwu-li ">
												<div class="server-hire-fuwu-li">
													<p class="hire-li-t">加速 - 特惠体验</p>
													<p class="hire-li-c">提供网页和小文件加速服务帮助客户提升网站的用户访问速度和服务的高可用性。</p>
												</div>
												<div class="server-hire_items clear">
													<ul class="server-hire_ul">
														<li>
															<img src="{{ asset("/images/wap/星星.png") }}" alt="">
															<p>域名数量月度总流量：1T</p>
														</li>
														<li>
															<img src="{{ asset("/images/wap/星星.png") }}" alt="">
															<p>域名数量：1个</p>
														</li>
													</ul>
													<div class="price">
														<span>￥</span>
														<div class="money">
															<p>100</p>/月
														</div>
														<!-- <a href="/">立即购买</a> -->
													</div>
												</div>
											</div>
											<div class="fuwu-li">
												<div class="server-hire-fuwu-li">
													<p class="hire-li-t">加速 - 企业版</p>
													<p class="hire-li-c">网页静态资源优化加速，全站HTTPS保证网站访问安全，适用于文学类站点、小型图片站等。</p>
												</div>

												<div class="server-hire_items clear">
													<ul class="server-hire_ul">
														<li>
															<img src="{{ asset("/images/wap/星星.png") }}" alt="">
															<p>域名数量月度总流量：5T</p>
														</li>
														<li>
															<img src="{{ asset("/images/wap/星星.png") }}" alt="">
															<p>域名数量：2个</p>
														</li>
													</ul>
													<div class="price">
														<span>￥</span>
														<div class="money">
															<p>500</p>/月
														</div>
														<!-- <a href="/">立即购买</a> -->
													</div>
												</div>

											</div>
											<div class="fuwu-li">
												<div class="server-hire-fuwu-li">
													<p class="hire-li-t">加速 - VIP</p>
													<p class="hire-li-c">图片、文件下载加速分发，多借点融合提供图片显示及用户下载速度，适用各类图库、下载站等。</p>
												</div>

												<div class="server-hire_items clear">
													<ul class="server-hire_ul">
														<li>
															<img src="{{ asset("/images/wap/星星.png") }}" alt="">
															<p>域名数量月度总流量：10T</p>
														</li>
														<li>
															<img src="{{ asset("/images/wap/星星.png") }}" alt="">
															<p>域名数量：3个</p>
														</li>
													</ul>
													<div class="price">
														<span>￥</span>
														<div class="money">
															<p>800</p>/月
														</div>
														<!-- <a href="/">立即购买</a> -->
													</div>
												</div>

											</div>
											<div class="fuwu-li">
												<div class="server-hire-fuwu-li">
													<p class="hire-li-t">加速 - 定制版</p>
													<p class="hire-li-c">企业网站，论坛，小说站，游戏网站，电子商务平台等。</p>
												</div>

												<div class="server-hire_items clear">
													<ul class="server-hire_ul">
														<li>
															<img src="{{ asset("/images/wap/星星.png") }}" alt="">
															<p>域名数量月度总流量：不限</p>
														</li>
														<li>
															<img src="{{ asset("/images/wap/星星.png") }}" alt="">
															<p>域名数量：不限</p>
														</li>
													</ul>
													<div class="price">
														<!-- <span>￥</span> -->
														<div class="money">
															<p style="font-size: 18px;">价格待定</p>
														</div>
														<!-- <a href="/">立即购买</a> -->
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- 产品优势 -->
								<div class="compouter-advantage-gn">
									<div class="title">
										<p>产品优势</p>
										<div class="title-hr"></div>
									</div>
									<div class="advantage-li clear">
										<div class="tz-main">
											<ul>
												<li class="clear">
													<img src="{{ asset("/images/wap/操作简单.png") }}" alt="">
													<div>操作简单</div>
													<p>15CDN服务，对于互联网用户的访问完全透明，网站方面的切换过程简单易行，操作方便。</p>
												</li>
												<li class="clear">
													<img src="{{ asset("/images/wap/完善的冗余机制.png") }}" alt="">
													<div>完善的冗余机制</div>
													<p>在设备、节点和网络三层面实现完善的冗余，保证设备或节点出现故障时，用户能正常访问。</p>
												</li>
												<li class="clear">
													<img src="{{ asset("/images/wap/安全性更高.png") }}" alt="">
													<div>安全性更高</div>
													<p>15CDN在部署上具完备安全机制,有效抵御DDOS及CC攻击,确保源站安全和网络质量。</p>
												</li>
												<li class="clear">
													<img src="{{ asset("/images/wap/内容管理更简单.png") }}" alt="">
													<div>内容管理更简单</div>
													<p>通过内容管理技术，实现对发布到CDN网络中的内容进行管理，保证终端内容与源站同步。</p>
												</li>
												<li class="clear">
													<img src="{{ asset("/images/wap/丰富的监控系统.png") }}" alt="">
													<div>丰富的监控系统</div>
													<p>整个CDN网络运行状态实行7*24小时全网监控、集中维护，保证问题能够及时有效解决。</p>
												</li>
												<li class="clear">
													<img src="{{ asset("/images/wap/服务更专业.png") }}" alt="">
													<div>服务更专业</div>
													<p>从需求分析、加速建议、效果测试、售后服务一站式专业化管理，实现各种数据统计分析。</p>
												</li>
												<li class="clear">
													<img src="{{ asset("/images/wap/业务更全面.png") }}" alt="">
													<div>业务更全面</div>
													<p>以客户为导向，提供专业CDN加速服务，满足各种静态、动态、上传、存储、分发加速。</p>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- 服务矩形 -->
								<div class="fuwu-rectangular">
									<div class="title">
										<p>服务矩形</p>
										<div class="title-hr"></div>
									</div>
									<img src="{{ asset("/images/wap/服务矩形.png") }}" alt="">
									<div class="rectangular">
										<div class="tz-main clear">
											<div class="rectangular-l">
												<div>
												</div>
											</div>
											<div class="rectangular-r">
												<ul>
													<li>
														<span></span>
														<div>静态内容加速</div>
														<p>隐藏源站IP，保护源站服务器；解除跨ISP访问的瓶颈，用户的就近访问，提升用户访问质量和体验黏度。</p>
													</li>
													<li>
														<span></span>
														<div>下载分发加速</div>
														<p>三层面冗余机制，抵御黑客入侵及DDOS类攻击；智能解析系统，支持各种软件在线升级、各种下载工具。</p>
													</li>
													<li>
														<span></span>
														<div>动态加速网络</div>
														<p>动态加速节点两两互联，海量传输；私有TCP协议实现数据加密传输，比传统 TCP 协议更高效、更稳定。</p>
													</li>
													<li>
														<span></span>
														<div>流媒体点播加速</div>
														<p>Tb级带宽承载，可承载百万用户同时请求；缓存、回源、防盗链、HTTPS等配置，完美解决盗链危害问题。</p>
													</li>
													<li>
														<span></span>
														<div>流媒体直播加速</div>
														<p>Tb级带宽承载，可承载百万用户同时请求；RTMP/HTTP FLV/HTTP
															TS/HLS等协议，满足各终端品台的用户需求。
														</p>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<!-- 高防服务器租用常见问题 -->
								<div class="common-problems">
									<div class="title">
										<p>CDN加速常见问题</p>
										<div class="title-hr"></div>
									</div>
									@include($help_template)
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="solutions-consulting">
						<img src="{{ asset("/images/wap/CDN加速蓝条.png") }}" alt="">
						<a>
							立即体验
						</a>
					</div> -->
				</div>
			</div>
		</div>
	</div>

@endsection
