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
							<li class="class-active"><a href="/wap/cdn/dsa">动态加速</a></li>
							<li><a href="/wap/cdn/smvoda">点播加速</a></li>
							<li><a href="/wap/cdn/smlba">直播加速</a></li>
						</ul>
					</div>
					<!-- CDN加速 -->
					<div class="CDN_up">
							<!-- 动态加速 -->
							<div class="class-item">
								<div class="dynamic_speedup">
									<div class="title">
										<p>动态加速网络</p>
										<div class="title-hr"></div>
									</div>
									<div class="title-content">
										<p>动态加速网络是针对网站中通过程序接口提取数据库或其他存储媒体中的内容而产生的服务，这些内容需不断更新，因此终端每次访问内容都有所不同，利用基础CDN缓存技术无法解决动态加速需求。而15CDN网络智能系统+自研的最优链路算法完美解决这一难题。
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
												<img src="{{ asset("/images/wap/网状互联海量传输.png") }}" alt="">
												<div>网状互联海量传输</div>
												<p>腾正自研链路优化技术和最优传输路径快速分发技术+自建高质量动态加速节点，使动态加速节点两两进行网状互联，可传输海量数据让您发布的内容更快地触达用户，提供用户对平台的黏度。
												</p>
											</li>
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/链路优化冗余传输.png") }}" alt="">
												<div>链路优化 冗余传输</div>
												<p>针对动态请求高并发、小文件的传输特点，15CDN通过多链路优化技术冗余传输，有效提升传输链路利用率，降低传输耗时和弱环境下的传输成本，保障数据传输过程中的可靠性和稳定性。
												</p>
											</li>
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/一键接入.png") }}" alt="">
												<div>操作简单 一键接入</div>
												<p>只需前往域名服务商处把域名解析A改成分配后CNAME记录，即可完成接入。控制台支持多种自助配置,提供自主化域名管理，提供实时流量、带宽、访问数、数据统计分析，帮助客户实时了解业务情况。
												</p>
											</li>
											<li class="slideshow-li">
												<img src="{{ asset("/images/wap/功能丰富性价比高.png") }}" alt="">
												<div>功能丰富 性价比高</div>
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
									<!-- 产品优势 -->
									<div class="compouter-advantage-gn">
										<div class="title">
											<p>产品功能</p>
											<div class="title-hr"></div>
										</div>
										<div class="advantage-li clear">
											<div class="tz-main">
												<ul>
													<li class="clear">
														<img src="{{ asset("/images/wap/源站保护.png") }}" alt="">
														<div>源站保护</div>
														<p>利用CDN节点替代源站被直接访问，达到隐藏源站IP的效果，有效保护源服务器避免遭到黑客攻击带来的危害。</p>
													</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/带宽优化.png") }}" alt="">
														<div>带宽优化</div>
														<p>用户直接在cache节点获取所需数据，在提高访问速度的同时也减少了源站点的带宽使用率，保障链路质量的同时节省了带宽费用。</p>
													</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/稳定高效.png") }}" alt="">
														<div>稳定高效</div>
														<p>用户的请求接入动态加速网络后，转换为可靠的腾正私有协议进行数据加密及传输，比传统 TCP 协议更高效、更稳定。</p>
													</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/秒级响应.png") }}" alt="">
														<div>秒级响应</div>
														<p>本地缓存加速，秒级缓存更新响应，提高了企业站点的访问速度，增强了用户体验质量和对内容提供商的黏度。</p>
													</li>
													<li class="clear">
														<img src="{{ asset("/images/wap/报表统计.png") }}" alt="">
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
														<img src="{{ asset("/images/wap/BBS社区论坛.png") }}" alt="">
														<p>BBS社区论坛</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/证券类网站.png") }}" alt="">
														<p>金融类网站</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/在线医疗等.png") }}" alt="">
														<p>在线医疗等</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/SNS社交网站.png") }}" alt="">
														<p>SNS社交网站</p>
													</li>
												</ul>
												<ul class="clear">
													<li>
														<img src="{{ asset("/images/wap/新闻类网站.png") }}" alt="">
														<p>新闻门户类</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/电子商务类网站.png") }}" alt="">
														<p>电子商务类</p>
													</li>
													<li>
														<img src="{{ asset("/images/wap/娱乐游戏类网站.png") }}" alt="">
														<p>游戏娱乐类</p>
													</li>
												</ul>
											</div>
											<div class="scenarios-t">
												<p>加速对象</p>
											</div>
											<p>提供实时、动态内容的各类网站</p>
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
