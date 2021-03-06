@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 带宽租用 -->
<div id="bandwidth_to_ent">
	<div class="main-body">
		<div class="tz-container clear">

			<!-- 内容 -->
			<div class="main-content">
					<div class="posters">
						<img src="{{ asset("/images/wap/带宽租用海报.png") }}" alt="">
						<a class="posters-btn posters-left">了解更多</a>
					</div>
					<div class="title back-w">
						<p>数据中心</p>
						<div class="title-hr"></div>
					</div>
					<div class="tz-main back-w" style="padding-top: 10px;">
						<div class="drop-options ">
							<p>机房选择</p>
							<select id="select-room-a" onchange="machineroomtext(this)">
								<option value="0" selected>湖南衡阳机房</option>
								<option value="1">广东惠州机房</option>
								<option value="2">陕西西安机房</option>
							</select>
							<span></span>
						</div>
						<div class="option-text-a option-e-active">
							<div class="computer-content">
								<table class="active-tab" border="0" cellspacing="1">
									<tr>
										<td>数据中心级别</td>
										<td>标准T3机房</td>
									</tr>
									<tr>
										<td>机房面积</td>
										<td>3000平方米</td>
									</tr>
									<tr>
										<td>机柜总数</td>
										<td>1288个，42U国际标准机柜</td>
									</tr>
									<tr>
										<td>出口总宽带</td>
										<td>860G直连中国电信骨干网</td>
									</tr>
									<tr>
										<td>防火墙设备</td>
										<td>200G集群防火墙</td>
									</tr>
									<tr>
										<td>电力设备</td>
										<td>两路市电，UpS艾默生力博特Hipluse系统，美国卡特2000KVA柴油发电机组</td>
									</tr>
									<tr>
										<td>数据中心地址</td>
										<td>湖南省衡阳市石鼓区蒸水桥北互联网数据中心</td>
									</tr>
								</table>
							</div>
							<a href="javascript;">查看详情</a>
							<a href="javascript;">在线咨询</a>
							<div class="telecom">
								<ul class="clear">
									<li>
										<p>衡阳电信100M型</p>
										<p>带宽：100M</p>
										<p>2000</p>
										<p>元/月</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
									<li>
										<p>衡阳电信500M型</p>
										<p>带宽：500M</p>
										<p>10000</p>
										<p>元/月</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
									<li>
										<p>衡阳电信1G型</p>
										<p>带宽：1G</p>
										<p>22W</p>
										<p>元/年</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
									<li>
										<p>衡阳电信万兆口</p>
										<p>带宽：10G（万兆口）</p>
										<p>200W</p>
										<p>元/年</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
								</ul>
							</div>
						</div>
						<div class="option-text-a ">
							<div class="computer-content">
								<table border="0" cellspacing="1">
									<tr>
										<td>数据中心级别</td>
										<td>标准T3机房</td>
									</tr>
									<tr>
										<td>机房面积</td>
										<td>8000平方米</td>
									</tr>
									<tr>
										<td>机柜总数</td>
										<td>2800个，42U国际标准机柜</td>
									</tr>
									<tr>
										<td>出口总宽带</td>
										<td>1600G直连中国华南地区国际出口电信骨干网</td>
									</tr>
									<tr>
										<td>防火墙设备</td>
										<td>480G 集群防火墙（百万兆级别）+云堤独立清洗 400G</td>
									</tr>
									<tr>
										<td>电力设备</td>
										<td>独立引入两路电力供应，市电线路的冗余备份、智能UPS系统冗余备份的柴油发电组</td>
									</tr>
									<tr>
										<td>数据中心地址</td>
										<td>广东省惠州市惠城区东湖二街东平互联网数据中心</td>
									</tr>
								</table>
							</div>
							<a href="javascript;">查看详情</a>
							<a href="javascript;">在线咨询</a>
							<div class="telecom">
								<ul class="clear">
									<li>
										<p>惠州电信100M型</p>
										<p>带宽：100M</p>
										<p>2400</p>
										<p>元/月</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
									<li>
										<p>惠州电信500M型</p>
										<p>带宽：500M</p>
										<p>12000</p>
										<p>元/月</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
									<li>
										<p>惠州电信1G型</p>
										<p>带宽：1G</p>
										<p>28W</p>
										<p>元/年</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
									<li>
										<p>惠州电信万兆口</p>
										<p>带宽：10G（万兆口）</p>
										<p>250W</p>
										<p>元/年</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
								</ul>
							</div>
						</div>
						<div class="option-text-a">
							<div class="computer-content">
								<table border="0" cellspacing="1">
									<tr>
										<td>数据中心级别</td>
										<td>标准T3机房</td>
									</tr>
									<tr>
										<td>机房面积</td>
										<td>53851平方米</td>
									</tr>
									<tr>
										<td>机柜总数</td>
										<td>5000个，42U国际标准机柜</td>
									</tr>
									<tr>
										<td>出口总宽带</td>
										<td>10T，直连互联网骨干点</td>
									</tr>
									<tr>
										<td>防火墙设备</td>
										<td>320G集群防火墙</td>
									</tr>
									<tr>
										<td>电力设备</td>
										<td>从三向不同局向的变电所引入市电，不间断电源系统配置分为240V直流系统和UPS系统</td>
									</tr>
									<tr>
										<td>数据中心地址</td>
										<td>陕西省西咸新区沣西新城</td>
									</tr>
								</table>
							</div>
							<a href="javascript;">查看详情</a>
							<a href="javascript;">在线咨询</a>
							<div class="telecom">
								<ul class="clear">
									<li>
										<p>西安电信100M型</p>
										<p>带宽：100M</p>
										<p>2400</p>
										<p>元/月</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
									<li>
										<p>西安电信500M型</p>
										<p>带宽：500M</p>
										<p>12000</p>
										<p>元/月</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
									<li>
										<p>西安电信1G型</p>
										<p>带宽：1G</p>
										<p>28W</p>
										<p>元/年</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
									<li>
										<p>西安电信万兆口</p>
										<p>带宽：10G（万兆口）</p>
										<p>250W</p>
										<p>元/年</p>
										<!-- <a href="/">立即购买</a> -->
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="title">
						<p>专业服务 六大保障</p>
						<div class="title-hr"></div>
					</div>
					<!-- 轮播 -->
					<div class="slideshow" id="slideshow">
						<ul class="slideshow-ul clear">
							<li class="slideshow-li">
								<img src="{{ asset("/images/wap/安全服务.png") }}" alt="">
								<div>安全服务</div>
								<p>提供攻击防御流量清洗、异地容灾备份、无缝移机、服务器状态监控服务，抵御各种攻击。</p>
							</li>
							<li class="slideshow-li">
								<img src="{{ asset("/images/wap/软件服务.png") }}" alt="">
								<div>软件服务</div>
								<p>协助用户部署服务器系统环境，并在用户授权下定期为其进行常用软件的运行和故障排查。 </p>
							</li>
							<li class="slideshow-li">
								<img src="{{ asset("/images/wap/硬件服务.png") }}" alt="">
								<div>硬件服务</div>
								<p>7*24小时启动服务，协助用户进行服务器、电力及网络的部署、更换或添加服务器配件等。 </p>
							</li>
							<li class="slideshow-li">
								<img src="{{ asset("/images/wap/技术支持.png") }}" alt="">
								<div>技术支持</div>
								<p>自研IDC运维系统，提供365*24小时技术支持+VIP快速通道，能及时完善地处理任何故障。</p>
							</li>
							<li class="slideshow-li">
								<img src="{{ asset("/images/wap/开源节流.png") }}" alt="">
								<div>开源节流</div>
								<p>与单独构建机房和租用专线上网相比，机柜租用降低了企业运营成本，提升了后期维护效率。 </p>
							</li>
							<li class="slideshow-li">
								<img src="{{ asset("/images/wap/灵活部署.png") }}" alt="">
								<div>灵活部署</div>
								<p>自有机房，即开即用，随时可扩展网络托管设备，助您快速实现业务部署，抢占市场先机。 </p>
							</li>
						</ul>
						<!-- 点 -->
						<div class="point">
							<ol class="clear slideshow-ol">
							</ol>
						</div>
					</div>
					<!-- 相关证书 -->
					<div class="certificate">
						<div class="title">
							<p>相关证书</p>
							<div class="title-hr"></div>
						</div>
						<div class="certificate-box">
							<div class="tz-main">
								<ul class="clear">
									<li>
										<div>
											<img src="{{ asset("/images/wap/广播节目制作许可证.png") }}" alt="">
										</div>
										<p>广播电视节目制作经营许可证</p>
									</li>
									<li>
										<div>
											<img src="{{ asset("/images/wap/国内数据传送许可证.png") }}" alt="">
										</div>
										<p>固定网国内数据传送业务经营许可证</p>
									</li>
									<li>
										<div>
											<img src="{{ asset("/images/wap/电信业务经营许可证.png") }}" alt="">
										</div>
										<p>腾正增值电信业务许可证</p>
									</li>
									<li>
										<div>
											<img src="{{ asset("/images/wap/网络文化经营许可证.png") }}" alt="">
										</div>
										<p>网络文化经营许可证</p>
									</li>
									<li>
										<div>
											<img src="{{ asset("/images/wap/质量管理体系认可.png") }}" alt="">
										</div>
										<p>质量管理体系认证</p>
									</li>
									<li>
										<div>
											<img src="{{ asset("/images/wap/腾正防火墙系统.png") }}" alt="">
										</div>
										<p>腾正防火墙系统</p>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- 机柜租用常见问题 -->
					<div class="common-problems">
						<div class="title">
							<p>带宽常见问题</p>
							<div class="title-hr"></div>
						</div>
						@include($help_template)
					</div>

					<!-- 蓝条 -->
					<!-- <div class="solutions-consulting">
						<img src="{{ asset("/images/wap/服务器租用蓝条.png") }}" alt="">
						<a>
							立即咨询
						</a>
					</div> -->
				</div>
		</div>
	</div>
@endsection
