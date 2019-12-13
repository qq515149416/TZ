@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div id="high_anti_CDN">
		<div class="main-body">
			<div class="tz-container clear">

				<!-- 内容 -->
				<div class="main-content">
					<div class="posters">
						<img src="{{ asset("/images/wap/高防CDN海报.png") }}" alt="">
						<a class="posters-btn posters-left">了解更多</a>
					</div>
					<div class="title">
						<p>高防CDN产品</p>
						<div class="title-hr"></div>
					</div>
					<!-- 高防CDN产品 -->
					<div class="slideshow-one">
							<div class="slideshow-ul-one clear">
								<div class="slideshow-li-one">
									<div>定制版</div>
									<div>
										<p>价格待定</p>
										<p></p>
									</div>
									<div>
										<div>
											<img src="{{ asset("/images/wap/星星.png") }}" alt="">
											防护：100
										</div>
										<div>
											<img src="{{ asset("/images/wap/星星.png") }}" alt="">
											域名数量：不限
										</div>
									</div>
									<a href="/">定制咨询</a>
								</div>
							</div>
						</div>

					<!-- 高防CDN特点 -->
					<div class="service-advantages" style="z-index: 100;">
						<div class="title">
							<p>高防CDN特点</p>
							<div class="title-hr"></div>
						</div>
						<img src="{{ asset("/images/wap/高防CDN特点.png") }}" alt="">
						<div class="tz-main">
							<ul>
								<li>
									<div class="fuwu-title">稳定</div>
									<div class="fuwu-txt">高质节点覆盖全国30多个省份，Tb级带宽承载
									</div>
								</li>
								<li>
									<div class="fuwu-title">极速</div>
									<div class="fuwu-txt">毫秒响应，只能分发，告诉网络+SSD存储更流畅</div>
								</li>
								<li>
									<div class="fuwu-title">易扩展</div>
									<div class="fuwu-txt">横向产品补充，自助控制台，随时便捷架构扩展</div>
								</li>
								<li>
									<div class="fuwu-title">易操作</div>
									<div class="fuwu-txt">平台化接入，自助配置加速，一键刷新缓存</div>
								</li>
								<li>
									<div class="fuwu-title">成本低</div>
									<div class="fuwu-txt">多样付费模式，享受低成本高质量内容分发</div>
								</li>
							</ul>
						</div>
					</div>

					<!-- DDoS高防IP功能 -->
					<div class="compouter-advantage-gn">
						<div class="title">
							<p style="color: #fff !important;">高防CDN功能</p>
							<div style="background-color: #fff !important;" class="title-hr"></div>
						</div>
						<div class="advantage-li clear">
							<div class="tz-main">
								<ul>
									<li class="clear">
										<img src="{{ asset("/images/wap/全局加速.png") }}" alt="">
										<div>全局加速</div>
										<p>智能DNS调度算法，加速本地缓存，近原则分配最优节点服务，减少传输时间提高访问速度。</p>
									</li>
									<li class="clear">
										<img src="{{ asset("/images/wap/冗余机制.png") }}" alt="">
										<div>冗余机制</div>
										<p>服务器，节点，网络三层面实现了完善的冗余,保证设备节点出现故障时不会影响用户正常访问。</p>
									</li>
									<li class="clear">
										<img src="{{ asset("/images/wap/防御弹性扩展.png") }}" alt="">
										<div>超强防御</div>
										<p>利用多节点的优势隐藏源站IP,有效抵御不同类型DDoS,CC攻击，保障源站服务器安全稳定。 </p>
									</li>
									<li class="clear">
										<img src="{{ asset("/images/wap/自动触发全面防护.png") }}" alt="">
										<div>安全配置</div>
										<p>支持缓存策略、缓存Key计算、回源、视频、防盗链、HTTPS等相关的配置，完美解决盗链危害。</p>
									</li>
									<li class="clear">
										<img src="{{ asset("/images/wap/性能优化.png") }}" alt="">
										<div>性能优化</div>
										<p>页面优化、智能压缩功能，为您减少传输内容节约开销的同时提升加速效果。</p>
									</li>
									<li class="clear">
										<img src="{{ asset("/images/wap/全景数据统计分析.png") }}" alt="">
										<div>数据监控及分析 </div>
										<p>数据监控，实时采集分析，提供带宽流量,请求次数等全景数据报表分析，提供日志下载和转储。</p>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- 应用场景 -->
					<div class="application-scenarios">
						<div class="title">
							<p>应用场景</p>
							<div class="title-hr"></div>
						</div>
						<div class="application-box">
							<div class="tz-main">
								<div class="application-items">
									<div class="clear">网站加速 <img src="{{ asset("/images/wap/网站类业务.png") }}" alt="">
									</div>
									<p class="font-b">适用行业：图片、素材、金融、电商、企业门户类网站 </p>
									<p>采用替身防御模式隐藏源站IP，阻断黑客针对源站的DDoS、CC攻击及恶意SQL注入，保障网站正常服务。</p>
								</div>
								<div class="application-items">
									<div class="clear">存储分发 <img style="width: 22px;" src="{{ asset("/images/wap/存储分发.png") }}" alt="">
									</div>
									<p class="font-b">适用行业：各类型端游,手游,下载站,应用程序等网络产品 </p>
									<p>不同粒度文件全国分发加速，解决在线游戏、音乐、视频、软件等大型文件传输</p>
								</div>
								<div class="application-items">
									<div class="clear">视频点播 <img src="{{ asset("/images/wap/视频点播.png") }}" alt="">
									</div>
									<p class="font-b">适用行业：在线影音、小视频类网站 </p>
									<p>基于腾正云海量存储、高效转码、极速分发和多端安全播放等服务打造一站式音乐、视频点播解决方案。</p>
								</div>
								<div class="application-items">
									<div class="clear">视频直播 <img src="{{ asset("/images/wap/视频直播.png") }}" alt="">
									</div>
									<p class="font-b">适用行业：视频直播品台  </p>
									<p>基于大规模实时流媒体计算集群和强大的音视频信号处理算法，打造"清晰流畅、低时延、高并发"的音视频直播服务。</p>
								</div>
							</div>
						</div>
					</div>
					<div class="methodofuse">
						<div class="title">
							<p>使用步骤</p>
							<div class="title-hr"></div>
						</div>
						<div class="tz-main">
							<img src="{{ asset("/images/wap/高防CDN使用步骤.png") }}" alt="">
						</div>
					</div>
					<!-- 高防IP常见问题 -->
					<div class="common-problems">
						<div class="title">
							<p>高防CDN常见问题</p>
							<div class="title-hr"></div>
						</div>
						@include($help_template)
					</div>
					<!-- 蓝条 -->
					<!-- <div class="solutions-consulting">
						<img src="{{ asset("/images/wap/防御流量叠加包蓝条.png" alt="">
						<a>
							立即咨询
						</a>
					</div> -->
				</div>
			</div>
		</div>
	</div>

@endsection
