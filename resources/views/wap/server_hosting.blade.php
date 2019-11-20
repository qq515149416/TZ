@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<!-- 服务器托管 -->
<div id="server_hosting">
    <div class="main-body">
        <div class="tz-container clear">
            <!-- 内容 -->
            <div class="main-content">
                <div class="posters">
                    <img src="{{ asset("/images/wap/服务器托管海报.png") }}" alt="">
                    <a class="posters-btn posters-left">了解更多</a>
                </div>
                <div class="drop-down-options">
                    <div class="tz-main">
                        <div class="drop-options">
                            <p>数据中心</p>
                            <select onchange="server_h_room()" id="select1">
                                <option value="湖南衡阳机房">湖南衡阳机房</option>
                                <option value="广东惠州机房">广东惠州机房</option>
                                <option value="陕西西安机房">陕西西安机房</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="drop-options">
                            <p>机柜尺寸</p>
                            <select id="select2" onchange="server_h_room()">
                                <option value="电信1U">电信1U</option>
                                <option value="联通1U">联通1U</option>
                                <option value="双线1U">双线1U</option>
                                <option value="三线1U">三线1U</option>
                                <option value="电信2U">电信2U</option>
                                <option value="联通2U">联通2U</option>
                                <option value="双线2U">双线2U</option>
                                <option value="三线2U">三线2U</option>
                            </select>
                            <span></span>
                        </div>
                    </div>
                </div>
                <!-- 轮播 -->
                <div class="nothing">
                    <div class="not_content clear">
                        <div class="not_t">衡阳三线</div>
                        <ol>
                            <li>
                                <p>规格</p><span class="not_gg">1U</span>标准服务器
                            </li>
                            <li>
                                <p>IP数</p>/
                            </li>
                            <li>
                                <p>月付</p> <span class="span1"></span> <span class="span2">
                                    /&nbsp;&nbsp;</span>
                            </li>
                        </ol>
                        <ol>
                            <li>
                                <p>带宽</p>/
                            </li>
                            <li>
                                <p>防御</p>/
                            </li>
                            <li>
                                <p>年付</p> <span class="span1"></span> <span class="span2">
                                    /&nbsp;&nbsp;</span>
                            </li>
                        </ol>
                    </div>

                </div>
                <div class="slideshow">
                    <ul class="slideshow-ul clear">
                        <li class="slideshow-li clear">
                            <div class="li_t_a">电信无防企业型</div>
                            <ol>
                                <li>
                                    <p>规格</p><span class="gga-a">1U</span>标准服务器
                                </li>
                                <li>
                                    <p>IP数</p> <span class="ipa-a">1个</span> 公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2 yfa-a">
                                        800&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口 <span class="dka-a">20M</span> 独享
                                </li>
                                <li>
                                    <p>防御</p> <span class="fya-a">无</span>
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2 nfa-a">
                                        7200&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slideshow-li clear">
                            <div class="li_t_b">电信40G硬防型</div>
                            <ol>
                                <li>
                                    <p>规格</p><span class="gga-a">1U</span>标准服务器
                                </li>
                                <li>
                                    <p>IP数</p><span class="ipa-a">1个</span> 公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2 yfa-b">
                                        800&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口<span class="dka-b">20M</span>独享
                                </li>
                                <li>
                                    <p>防御</p><span class="fya-b">40G硬防</span>
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2 nfa-b">
                                        7200&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slideshow-li clear">
                            <div class="li_t_c">电信80G硬防型</div>
                            <ol>
                                <li>
                                    <p>规格</p><span class="gga-a">1U</span>标准服务器
                                </li>
                                <li>
                                    <p>IP数</p><span class="ipa-a">1个</span>公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2 yfa-c">
                                        1300&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口<span class="dka-c">20M</span>独享
                                </li>
                                <li>
                                    <p>防御</p><span class="fya-c">80G硬防</span>
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2 nfa-c">
                                        12000&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slideshow-li clear">
                            <div class="li_t_d">电信120G硬防型</div>
                            <ol>
                                <li>
                                    <p>规格</p><span class="gga-a">1U</span>标准服务器
                                </li>
                                <li>
                                    <p>IP数</p><span class="ipa-a">1个</span>公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2 yfa-d">
                                        2000&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口<span class="dka-d">20M</span>独享
                                </li>
                                <li>
                                    <p>防御</p><span class="fya-d">120G硬防</span>
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2 nfa-d">
                                        20400&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                    </ul>
                    <!-- 点 -->
                    <div class="point">
                        <ol class="clear slideshow-ol">
                        </ol>
                    </div>
                </div>
                <div class="one-t">
                    <ul class="slide-ul clear">
                        <li class="slide-li active" id="one-a">
                            <div class="li_t_a">电信无防企业型</div>
                            <ol>
                                <li>
                                    <p>规格</p>1U标准服务器
                                </li>
                                <li>
                                    <p>IP数</p>1个公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2">
                                        1000&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口20M 独享
                                </li>
                                <li>
                                    <p>防御</p> 无
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2">
                                        8400&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slide-li" id="one-b">
                            <div>联通无防企业型</div>
                            <ol>
                                <li>
                                    <p>规格</p>1U标准服务器
                                </li>
                                <li>
                                    <p>IP数</p>1个公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2">
                                        1000&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口20M 独享
                                </li>
                                <li>
                                    <p>防御</p>无
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2">
                                        8400&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slide-li" id="one-c">
                            <div>双线无防企业型</div>
                            <ol>
                                <li>
                                    <p>规格</p>1U标准服务器
                                </li>
                                <li>
                                    <p>IP数</p>2个公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2">
                                        1200&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口20M独享
                                </li>
                                <li>
                                    <p>防御</p>无
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2">
                                        10800&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slide-li" id="one-d">
                            <div>三线无防企业型</div>
                            <ol>
                                <li>
                                    <p>规格</p>/
                                </li>
                                <li>
                                    <p>IP数</p>/
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1"></span> <span class="span2">
                                        /&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>/
                                </li>
                                <li>
                                    <p>防御</p>/
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1"></span> <span class="span2">
                                        /&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slide-li" id="one-e">
                            <div>电信无防企业型</div>
                            <ol>
                                <li>
                                    <p>规格</p>2U标准服务器
                                </li>
                                <li>
                                    <p>IP数</p>1个公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2">
                                        1200&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口20M独享
                                </li>
                                <li>
                                    <p>防御</p>无
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2">
                                        10800&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slide-li" id="one-f">
                            <div>联通无防企业型</div>
                            <ol>
                                <li>
                                    <p>规格</p>2U标准服务器
                                </li>
                                <li>
                                    <p>IP数</p>1个公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2">
                                        1200&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口20M 独享
                                </li>
                                <li>
                                    <p>防御</p>无
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2">
                                        10800&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slide-li" id="one-g">
                            <div>双线无防企业型</div>
                            <ol>
                                <li>
                                    <p>规格</p>2U标准服务器
                                </li>
                                <li>
                                    <p>IP数</p>2个公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2">
                                        1400&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口20M独享
                                </li>
                                <li>
                                    <p>防御</p>无
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2">
                                        13200&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slide-li" id="one-h">
                            <div>三线无防企业型</div>
                            <ol>
                                <li>
                                    <p>规格</p>2U标准服务器
                                </li>
                                <li>
                                    <p>IP数</p>/
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1"></span> <span class="span2">
                                        /&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>/
                                </li>
                                <li>
                                    <p>防御</p>/
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1"></span> <span class="span2">
                                        /&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                    </ul>
                </div>
                <div class="slideshow-a">
                    <ul class="slideshow-ul-a clear">
                        <li class="slideshow-li-a clear">
                            <div class="li_t_b_a">电信无防企业型</div>
                            <ol>
                                <li>
                                    <p>规格</p><span class="ggb-a">1U</span>标准服务器
                                </li>
                                <li>
                                    <p>IP数</p><span class="ipb-a">1个</span>公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2 yfb-a">
                                        800&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口<span class="dkb-a">20M</span>独享
                                </li>
                                <li>
                                    <p>防御</p><span class="fyb-a">无</span>
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2  nfb-a">
                                        7200&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slideshow-li-a clear">
                            <div class="li_t_b_b">电信40G硬防型</div>
                            <ol>
                                <li>
                                    <p>规格</p><span class="ggb-a">1U</span>标准服务器
                                </li>
                                <li>
                                    <p>IP数</p><span class="ipb-a">1个</span> 公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2 yfb-b">
                                        800&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口<span class="dkb-b">20M</span>独享
                                </li>
                                <li>
                                    <p>防御</p><span class="fyb-b">无</span>
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2  nfb-b">
                                        7200&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                        <li class="slideshow-li-a clear">
                            <div class="li_t_b_c">电信80G硬防型</div>
                            <ol>
                                <li>
                                    <p>规格</p><span class="ggb-a">1U</span>标准服务器
                                </li>
                                <li>
                                    <p>IP数</p><span class="ipb-a">1个</span>公网IP地址
                                </li>
                                <li>
                                    <p>月付</p> <span class="span1">￥</span> <span class="span2 yfb-c">
                                        1300&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <p>带宽</p>G口<span class="dkb-c">20M</span>独享
                                </li>
                                <li>
                                    <p>防御</p><span class="fyb-c">无</span>
                                </li>
                                <li>
                                    <p>年付</p> <span class="span1">￥</span> <span class="span2  nfb-c">
                                        12000&nbsp;&nbsp;</span>
                                </li>
                            </ol>
                            <!-- <a href="/">立即购买</a> -->
                        </li>
                    </ul>
                    <!-- 点 -->
                    <div class="point-a">
                        <ol class="clear slideshow-ol-a">
                        </ol>
                    </div>
                </div>
                <div class="title">
                    <p>机房性能PK</p>
                    <div class="title-hr"></div>
                </div>
                <div class="performance">
                    <table class="active-tab" border="1" cellspacing=0>
                        <tr>
                            <td>项目</td>
                            <td>腾正机房</td>
                            <td>其他非专业机房</td>
                        </tr>
                        <tr>
                            <td>机柜</td>
                            <td>
                                <div>42U机柜</div>
                                <p>只允许放18U设备，确保服务器散热</p>
                            </td>
                            <td>
                                <div>42U机柜</div>
                                <p>为节省成本,不考虑高温对服务器的影响超U填放</p>
                            </td>
                        </tr>
                        <tr>
                            <td>恒温</td>
                            <td>冷热分离,确保服务器最佳允许温度22℃±2℃</td>
                            <td>大型中央空调，服务器温度无法保证恒温</td>
                        </tr>
                        <tr>
                            <td>宽带</td>
                            <td>总出口达10T，带宽资源充足，随时升级G口</td>
                            <td>网络出口小，访问速度和后期扩展得不到保障</td>
                        </tr>
                        <tr>
                            <td>防御</td>
                            <td>集群防火墙+独立CC防火墙，抵御DDOS、CC攻击</td>
                            <td>普通防火墙，易被各种DDOS攻击和黑蛇入侵</td>
                        </tr>
                        <tr>
                            <td>能效</td>
                            <td>T3、T4数据中心的能效：PUE≤1.36</td>
                            <td>普通数据中心的能耗：PUE≥1.50</td>
                        </tr>
                        <tr>
                            <td>配电</td>
                            <td>双路供电+柴油发电机组+UPS模块组</td>
                            <td>单路供电，柴油发电机heUPS不支持1备1</td>
                        </tr>
                        <tr>
                            <td>故障率</td>
                            <td>可用性能99.99%，年平均故障时间52.56分钟</td>
                            <td>可用性＜98%、年平均故障时间大于17小时</td>
                        </tr>
                    </table>
                </div>
                <!-- 服务器支持 -->
                <div class="server-support">
                    <div class="title">
                        <p style="color: #fff !important;">服务器支持</p>
                        <div style="background-color: #fff !important;" class="title-hr"></div>
                    </div>
                    <div class="server-box">
                        <div class="server-content">
                            <div class="tz-main">
                                <table border="1" cellspacing="0">
                                    <tr>
                                        <td>项目</td>
                                        <td>腾正服务器托管</td>
                                        <td>其他公司服务器托管</td>
                                    </tr>
                                    <tr>
                                        <td>机柜</td>
                                        <td>免费上架安装</td>
                                        <td>免费上架安装</td>
                                    </tr>
                                    <tr>
                                        <td>系统安装</td>
                                        <td>首次免费安装系统</td>
                                        <td>首次免费安装系统</td>
                                    </tr>
                                    <tr>
                                        <td>合作方式</td>
                                        <td>
                                            <div>可租用设备,机位,带宽,IP,可年付也可月付</div>
                                            <p>没有技术的还可以选择代维服务</p>
                                        </td>
                                        <td>
                                            <div>只是年托或是月托服务</div>
                                            <p>没有技术的还可以选择代维服务</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>防御支持</td>
                                        <td>单独CC防火墙，免费CC防护</td>
                                        <td>无独立的CC防御系统，或有也需要付费购买</td>
                                    </tr>
                                    <tr>
                                        <td>技术支持</td>
                                        <td>自主机房，每机房配备3-6名工程师时刻待命，7*24小时电话、QQ、手机端工单系统实时响应技术支持</td>
                                        <td>非自主机房，遇服务需中转，甚至找不到人，无法保证实时响应，或是有响应，无法处理问题</td>
                                    </tr>
                                    <tr>
                                        <td>资质支持</td>
                                        <td>跨地区ISP\IDC资质支持，备案及经营性备案都支持</td>
                                        <td>非自有资质或资质受区域限制，无法提供有力支撑</td>
                                    </tr>
                                    <tr>
                                        <td>解决方案</td>
                                        <td>专业、高效、量身定制的托管服务方案</td>
                                        <td>非一手资质，沟通易脱节，无法保证方案可行性</td>
                                    </tr>
                                    <tr>
                                        <td>支付方式</td>
                                        <td>服务器上架成功后再付款</td>
                                        <td>先付款，后上架</td>
                                    </tr>
                                    <tr>
                                        <td>核心优势</td>
                                        <td>品质机房连通率99.99%，60秒人工服务响应</td>
                                        <td>价格</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 托管流程 -->
                <div class="compouter-advantage">
                    <div class="title">
                        <p style="color: #fff !important;">托管流程</p>
                        <div style="background-color: #fff !important;z-index: 10;" class="title-hr"></div>
                    </div>
                    <div class="advantage-li clear">
                        <div class="tz-main">
                            <div class="hr-1" style="z-index: 1;"></div>
                            <div class="hr-2"></div>
                            <ul>
                                <li>
                                    <img src="{{ asset("/images/wap/圈.png") }}" alt="">
                                    <p>1</p>
                                    注册账号
                                </li>
                                <li>
                                    <img src="{{ asset("/images/wap/圈.png") }}" alt="">
                                    <p>2</p>
                                    在线下单支付
                                </li>
                                <li>
                                    <img src="{{ asset("/images/wap/圈.png") }}" alt="">
                                    <p>3</p>
                                    根据提示快递服务器
                                </li>
                                <li>
                                    <img src="{{ asset("/images/wap/圈.png") }}" alt="">
                                    <p>4</p>
                                    机房收货，确认配置，分配资源，上架处理
                                </li>
                                <li>
                                    <img src="{{ asset("/images/wap/圈.png") }}" alt="">
                                    <p>5</p>
                                    在线管理
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- 高防服务器租用常见问题 -->
                <div class="common-problems">
                    <div class="title">
                        <p>服务器租用常见问题</p>
                        <div class="title-hr"></div>
                    </div>
                    <div class="problems-li">
                        <div class="tz-main">
                            <ul>
                                <li class="clear">
                                    <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                    <p>什么是服务器托管？</p>
                                    <p>2019.06.01</p>
                                </li>
                                <li class="clear">
                                    <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                    <p>服务器托管有哪些好处？</p>
                                    <p>2019.06.01</p>
                                </li>
                                <li class="clear">
                                    <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                    <p>服务器托管的U是什么意思？</p>
                                    <p>2019.06.01</p>
                                </li>
                                <li class="clear">
                                    <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                    <p>服务器托管BGP机房是什么意思?</p>
                                    <p>2019.06.01</p>
                                </li>
                                <li class="clear">
                                    <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                    <p>腾正科技的服务器托管怎么样？ </p>
                                    <p>2019.06.01</p>
                                </li>
                            </ul>
                            <div class="view-more">
                                查看更多
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
