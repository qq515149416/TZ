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
							<li class="class-active"><a href="/wap/cdn/smlba">直播加速</a></li>
						</ul>
					</div>
					<!-- CDN加速 -->
					<div class="CDN_up">
							<!-- 直播加速 -->
							<div class="class-item">
								<div class="live_speedup">
									<div class="title">
										<p>流媒体直播加速</p>
										<div class="title-hr"></div>
									</div>
									<div class="title-content">
										<p>15CDN流媒体直播加速是将源站采用广播方式通过网络为用户提供实时采集的视频流，通过最佳链路传输到腾正科技流媒体专用存储设备中，并利用15CDN网络自身的协同性能，将这些大流量流媒体文件进行快速分层同步传输到全国各加速节点上，为用户提供稳定可靠的音视频点播服务。
										</p>
									</div>
									<div class="title back-w">
										<p>产品优势</p>
										<div class="title-hr"></div>
									</div>
									<!-- 轮播 -->
									<div class="slideshow" id="slideshow">
										<ul class="slideshow-ul clear">
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/更快速.png") }}" alt="">
												<div>更快速</div>
												<p>自建1000+高质量加速节点，Tb级带宽承载，可承载百万用户同时请求，助力内容直播的时间、空间范围。
												</p>
											</li>
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/更稳定.png") }}" alt="">
												<div>更稳定</div>
												<p>分层分发保证直播流的传输质量，最大程度减少传输环节对直播效果的影响，提高用户体验度和访问黏度。
												</p>
											</li>
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/更灵活.png") }}" alt="">
												<div>更灵活</div>
												<p>支持RTMP/HTTP FLV/HTTP TS/HLS/HDS等协议、码率转换，支持直播定位时移，满足多终端多平台的用户需求。
												</p>
											</li>
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/更简单.png") }}" alt="">
												<div>更简单</div>
												<p>使用15CDN无需更改网站设置，只需前往域名服务商处把域名解析A改成分配后CNAME记录，即可完成接入。
												</p>
											</li>
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/性价比高.png") }}" alt="">
												<div>更经济</div>
												<p>无需建设高标准的系统及网络环境，依据按日、按流量等多重付费模式，不必顾虑非直播期间带来的成本压力。
												</p>
											</li>
										</ul>
										<!-- 点 -->
										<div class="point">
											<ol class="clear slideshow-ol">
											</ol>
										</div>
									</div>
									<!-- 产品功能 -->
									<div class="compouter-advantage-gn">
										<div class="title">
											<p>产品功能</p>
											<div class="title-hr"></div>
										</div>
										<div class="advantage-li clear">
											<div class="tz-main">
												<ul>
													<li class="clear">
														<img src="{{ asset("/images/wap/安全配置2.png") }}" alt="">
														<div>安全配置</div>
														<p>支持缓存策略、缓存Key计算、回源、视频、防盗链、HTTPS等相关的配置，完美解决盗链危害和用户等待时间。</p>
													</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/自动适配2.png") }}" alt="">
														<div>自动适配</div>
														<p>专业的编转码技术，自动适应各种网络环境，自动适配多种终端以及平台，支持实时转码和离线转码。</p>
													</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/安全性更高.png") }}" alt="">
														<div>源站保护</div>
														<p>利用CDN节点替代源站被直接访问，达到隐藏源站IP的效果，有效保护源服务器避免遭到黑客攻击带来的危害。</p>
													</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/负载均衡.png") }}" alt="">
														<div>负载均衡</div>
														<p>采用负载均衡技术，当Cache节点出现宕机时，能够自动屏蔽该Cache节点并切换到健康节点，保证用户正常访问。</p>
													</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/报表统计.png") }}" alt="">
														<div>报表统计</div>
														<p>提供带宽流量、流量缓存、节点流量比例、页面访问的统计数据及日志下载等数据统计报表，助力业务拓展分析。</p>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<!-- 使用场景 -->
									<div class="usage_scenarios">
										<div class="title">
											<p>产品优势</p>
											<div class="title-hr"></div>
										</div>
										<div class="scenarios">
											<div class="scenarios-t">
												<p>客户群体</p>
											</div>
											<div class="scenarios-c">
												<ul class="clear">
													<li>
														<img src="{{ asset("/images/wap/新闻类网站.png") }}" alt="">
														<p>新闻直播类网站</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/电视直播类网站.png") }}" alt="">
														<p>电视直播类网站</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/体育赛事类网站.png") }}" alt="">
														<p>体育赛事类网站</p>
													</li>
												</ul>
												<ul class="clear">
													<li>
														<img src="{{ asset("/images/wap/远程教育类网站.png") }}" alt="">
														<p>远程教育类网站</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/娱乐游戏类网站.png") }}" alt="">
														<p>游戏直播网站</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/在线医疗等.png") }}" alt="">
														<p>远程医疗类网站</p>
													</li>
												</ul>
												<ul class="clear">
													<li>
														<img src="{{ asset("/images/wap/BBS社区论坛.png") }}" alt="">
														<p>访谈类网站</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/实时视频会议.png") }}" alt="">
														<p>实时视频会议</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/音乐类网站2.png") }}" alt="">
														<p>音乐类网站</p>
													</li>
												</ul>
											</div>
											<div class="scenarios-t">
												<p>加速对象</p>
											</div>
											<p>网站或受经济APP静态组成部分如html文件、flash动画、css、js及各种文件类型的文字、图片类网站</p>
										</div>
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
