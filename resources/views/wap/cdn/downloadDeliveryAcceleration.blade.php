@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
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
                            <li><a href="/wap/cdn/sca">静态加速</a></li>
							<li class="class-active"><a href="/wap/cdn/dda">下载加速</a></li>
							<li><a href="/wap/cdn/dsa">动态加速</a></li>
							<li><a href="/wap/cdn/smvoda">点播加速</a></li>
							<li><a href="/wap/cdn/smlba">直播加速</a></li>
						</ul>
					</div>
					<!-- CDN加速 -->
					<div class="CDN_up">
							<!-- 下载加速 -->
							<div class="class-item">
								<div class="download_speedup">
									<div class="title">
										<p>下载分发加速</p>
										<div class="title-hr"></div>
									</div>
									<div class="title-content">
										<p>15CDN下载分发加速主针对新版本软件/补丁包、游戏安装包获取、手机ROM升级、应用程序包下载等业务场景，提供稳定、优质的下载加速服务。海量弹性带宽储备，具备突发性超大流量承载能力，减少用户等待时间，让业务用户获得极速的下载体验，提升用户转化率。
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
												<img src="{{ asset("/images/wap/节点丰富2.png") }}" alt="">
												<div>节点丰富</div>
												<p>自建1000+高质量加速节点，Tb级带宽承载，可承载百万用户同时请求；可跨地域支持电信、联通、移动、教育网等主流运营商,以及多家中心型运营商，有效将用户请求精准调度至最优边缘节点。
												</p>
											</li>
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/全面防护2.png") }}" alt="">
												<div>全面防护</div>
												<p>在服务器、节点、网络三个层面上具有完善的冗余机制，有效地预防黑客入侵以及降低各种DDOS攻击对网站的影响，确保在服务器或节点出现故障时，自动将网民访问导向其他就近的监控节点进行响应。
												</p>
											</li>
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/一键接入2.png") }}" alt="">
												<div>一键接入</div>
												<p>只需前往域名服务商处把域名解析A改成分配后CNAME记录，即可完成接入。控制台支持多种自助配置,提供自主化域名管理，提供实时流量、带宽、访问数、数据统计分析，帮助客户实时了解业务波动。
												</p>
											</li>
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/性价比高2.png") }}" alt="">
												<div>性价比高</div>
												<p>内置功能丰富，横向产品补充，自助控制台丰富API，支持FTP、API接口等多种资源上传方式；支持按日、按流量、按需等灵活付费模式，可随时切换享受低成本高质量内容分发，满足您不同时期的业务需求。
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
														<img src="{{ asset("/images/wap/先进技术.png") }}" alt="">
														<div>先进技术</div>
														<p>采用优化的TCP技术完成，提高了文件的上传和内容分发速度的同时，有效的保证数据的安全性和稳定性。</p>
													</li>
													<li class="clear">
															<img src="{{ asset("/images/wap/性能优化.png") }}" alt="">
															<div>兼容性强</div>
															<p>通过智能解析系统分配下载请求，支持各种客户端软件的在线升级，支持各种下载工具，如网际快车、网络蚂蚁等。</p>
														</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/跨ISP访问.png") }}" alt="">
														<div>跨ISP访问</div>
														<p>跨越不同运营商之间由于互联互通所造成的瓶颈问题，用户实现就近访问，提升了用户的访问质量和对内容提供商的黏度。</p>
													</li>
													<li class="clear">
															<img src="{{ asset("/images/wap/全局加速.png") }}" alt="">
															<div>秒级响应</div>
															<p>源站保护，本地缓存加速，秒级缓存更新响应，提高企业站点的访问速度，增强了用户体验质量和对内容提供商的黏度。</p>
														</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/带宽优化2.png") }}" alt="">
														<div>带宽优化</div>
														<p>用户直接在cache节点获取所需数据，在提高访问速度的同时也减少了源站点的带宽使用率，保障链路质量的同时节省了带宽费用。</p>
													</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/全景数据统计分析.png") }}" alt="">
														<div>报表统计</div>
														<p>提供带宽流量、流量缓存、节点流量比例、页面访问的统计数据及日志下载等多样式全景数据统计报表，助力业务拓展分析。 </p>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<!-- 使用场景 -->
									<div class="usage_scenarios">
										<div class="title">
											<p>使用场景</p>
											<div class="title-hr"></div>
										</div>
										<div class="scenarios">
											<div class="scenarios-t">
												<p>客户群体</p>
											</div>
											<div class="scenarios-c">
												<ul class="clear">
													<li>
														<img src="{{ asset("/images/wap/病毒库更新下载.png") }}" alt="">
														<p>病毒库更新下载</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/小程序下载.png") }}" alt="">
														<p>小程序下载</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/软件及补丁下载.png") }}" alt="">
														<p>软件及补丁下载</p>
													</li>
												</ul>
												<ul class="clear">
													<li>
														<img src="{{ asset("/images/wap/应用程序下载.png") }}" alt="">
														<p>应用程序下载</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/小游戏下载.png") }}" alt="">
														<p>小游戏下载</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/音视频下载站.png") }}" alt="">
														<p>音视频下载站</p>
													</li>
												</ul>
											</div>
											<div class="scenarios-t">
												<p>加速对象</p>
											</div>
											<p>利用HTTP或FTP下载方式进行下载的各类软件/补丁包下载服务网站</p>
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