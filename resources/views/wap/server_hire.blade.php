@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

<!-- 服务器租用 -->
<div id="server_hire">
        <div class="main-body">
            <div class="tz-container clear">
                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/服务器租用海报.png") }}" alt="">
                        <a class="posters-btn posters-left">了解更多</a>
                    </div>
                    <div class="drop-down-options">
                        <div class="tz-main">
                            <div class="drop-options server-rooma">
                                <p>数据中心</p>
                                <select id="selecta" onchange="server_room()">
                                    <option value="湖南衡阳机房" selected>湖南衡阳机房</option>
                                    <option value="广东惠州机房">广东惠州机房</option>
                                    <option value="陕西西安机房">陕西西安机房</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="drop-options server-roomb">
                                <p>线路选择</p>
                                <select id="selectb" onchange="server_room()">
                                    <option value="电信服务器租用" selected>电信服务器租用</option>
                                    <option value="联通服务器租用">联通服务器租用</option>
                                    <option value="双线服务器租用">双线服务器租用</option>
                                    <option value="三线服务器租用">三线服务器租用</option>
                                </select>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <!-- 轮播 -->
                    <div class="nothing">
                        <div>暂无</div>
                    </div>
                    <div class="one-t">
                        <ul class="slide-ul clear">
                            <li class="slide-li active" id="one-a">
                                <div>惠州电信型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD |500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p>G口 20M <p class="p1">内存</p> <span class="p">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p>1个
                                        <p class="p2">单机防御</p><span class="pw">无</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1">￥</span> <span class="span2-1">
                                            1100&nbsp;&nbsp;</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2">9600</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                            <li class="slide-li" id="one-b">
                                <div>惠州联通型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD | 500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p>G口 20M <p class="p1">内存</p><span class="p">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p>1个
                                        <p class="p2">单机防御</p><span class="pw">无</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1 ">￥</span> <span class="span2-1">
                                            1100&nbsp;&nbsp;</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2">9600</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                            <li class="slide-li" id="one-c">
                                <div>惠州双线型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD |500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p>G口 20M <p class="p1">内存</p><span class="p">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p>2个
                                        <p class="p2">单机防御</p><span class="pw">无</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1 ">￥</span> <span class="span2-1">
                                            1300&nbsp;&nbsp;</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2">1200</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                        </ul>
                    </div>
                    <div class="slideshow">
                        <ul class="slideshow-ul clear">
                            <li class="slideshow-li slideshow-lia">
                                <div class="s-t-a">衡阳电信A型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD | 500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p><span class="dk-a">G口 20M</span>
                                        <p class="p1">内存</p> <span class="nc-a">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p> <span class="n-ip-a">1个</span>
                                        <p class="p2">单机防御</p> <span class="fy-a">无</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1 ">￥</span> <span class="span2-1 span-a-a">
                                            900&nbsp;&nbsp;</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2 span-a-b">8400</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                            <li class="slideshow-li slideshow-lib">
                                <div class="s-t-b">衡阳电信B型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD |500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p><span class="dk-b">G口 20M</span>
                                        <p class="p1">内存</p> <span class="nc-b">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p><span class="n-ip-b">1个</span>
                                        <p class="p2">单机防御</p> <span class="fy-b">40G</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1">￥</span> <span class="span2-1 span-b-a"
                                            id="span-a">
                                            900&nbsp;&nbsp;</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2 span-b-b" id="span-b">8400</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                            <li class="slideshow-li slideshow-lic">
                                <div class="s-t-c">衡阳电信C型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD |500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p><span class="dk-c">G口 20M</span>
                                        <p class="p1">内存</p> <span class="nc-c">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p><span class="n-ip-c">1个</span>
                                        <p class="p2">单机防御</p><span class="fy-c">40G</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1">￥</span> <span
                                            class="span2-1 span-c-a">1400</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2 span-c-b">13200</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                            <li class="slideshow-li slideshow-lid">
                                <div class="s-t-d">衡阳电信D型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD | 500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p> <span class="dk-d">G口 20M</span>
                                        <p class="p1">内存</p> <span class="nc-d">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p><span class="n-ip-d">1个</span>
                                        <p class="p2">单机防御</p><span class="fy-d">120G</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1">￥</span> <span
                                            class="span2-1 span-d-a">2100</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2 span-d-b">21600</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                            <!-- <li style="display: none;" class="slideshow-li slideshow-li-s">
                                    <div class="s-t-e">西安</div>
                                    <ol>
                                        <li>
                                            <p>规格</p>定制
                                        </li>
                                        <li>
                                            <p>硬盘</p>定制
                                        </li>
                                        <li>
                                            <p>带宽</p>G口无限带宽 <p class="p1">内存</p><span class="nc-d">定制</span>
                                        </li>
                                        <li>
                                            <p>IP数</p><span class="n-ip-d">1个</span>
                                            <p class="p2">单机防御</p><span class="fy-d">500G+云提</span>
                                        </li>
                                        <li>
                                            <p>月付</p> <span class="span1-1">￥</span> <span class="span2-1 span-d-a">定制</span>
                                            <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                                class="span2-2 span-d-b">定制</span>
                                        </li>
                                    </ol>
                                    <a href="/">立即购买</a>
                                </li> -->
                        </ul>
                        <!-- 点 -->
                        <div class="point">
                            <ol class="clear slideshow-ol">
                            </ol>
                        </div>
                    </div>
                    <div class="slideshow-a">
                        <ul class="slideshow-ul-a clear">
                            <li class="slideshow-li-a slideshow-lia ">
                                <div class="s-t-a-a">衡阳电信A型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD | 500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p><span class="dk-a-a">G口 20M</span>
                                        <p class="p1">内存</p> <span class="nc-a-a">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p> <span class="n-ip-a-a">1个</span>
                                        <p class="p2">单机防御</p> <span class="fy-a-a">无</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1 ">￥</span> <span class="span2-1 span-a-a-a">
                                            900&nbsp;&nbsp;</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2 span-a-b-a">8400</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                            <li class="slideshow-li-a slideshow-lib ">
                                <div class="s-t-b-a">衡阳电信B型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD |500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p><span class="dk-b-a">G口 20M</span>
                                        <p class="p1">内存</p> <span class="nc-b-a">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p><span class="n-ip-b-a">1个</span>
                                        <p class="p2">单机防御</p> <span class="fy-b-a">40G</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1">￥</span> <span class="span2-1 span-b-a-a"
                                            id="span-a">
                                            900&nbsp;&nbsp;</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2 span-b-b-a" id="span-b">8400</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                            <li class="slideshow-li-a slideshow-lic ">
                                <div class="s-t-c-a">衡阳电信C型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD |500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p><span class="dk-c-a">G口 20M</span>
                                        <p class="p1">内存</p> <span class="nc-c-a">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p><span class="n-ip-c-a">1个</span>
                                        <p class="p2">单机防御</p><span class="fy-c-a">40G</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1">￥</span> <span
                                            class="span2-1 span-c-a-a">1400</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2 span-c-b-a">13200</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                            <li class="slideshow-li-a slideshow-lid ">
                                <div class="s-t-d-a">衡阳电信D型</div>
                                <ol>
                                    <li>
                                        <p>规格</p>8核16线程 （E5530*2）
                                    </li>
                                    <li>
                                        <p>硬盘</p>240G SSD | 500G SATA | 1T SATA
                                    </li>
                                    <li>
                                        <p>带宽</p> <span class="dk-d-a">G口 20M</span>
                                        <p class="p1">内存</p> <span class="nc-d-a">16G</span>
                                    </li>
                                    <li>
                                        <p>IP数</p><span class="n-ip-d-a">1个</span>
                                        <p class="p2">单机防御</p><span class="fy-d-a">120G</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1">￥</span> <span
                                            class="span2-1 span-d-a-a">2100</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2 span-d-b-a">21600</span>
                                    </li>
                                </ol>
                                <!-- <a href="/">立即购买</a> -->
                            </li>
                            <li class="slideshow-li-a slideshow-li-s">
                                <div class="s-t-e">西安</div>
                                <ol>
                                    <li>
                                        <p>规格</p>定制
                                    </li>
                                    <li>
                                        <p>硬盘</p>定制
                                    </li>
                                    <li>
                                        <p>带宽</p>G口无限带宽 <p class="p1">内存</p><span>定制</span>
                                    </li>
                                    <li>
                                        <p>IP数</p><span>1个</span>
                                        <p class="p2">单机防御</p><span>500G+云提</span>
                                    </li>
                                    <li>
                                        <p>月付</p> <span class="span1-1">￥</span> <span class="span2-1">定制</span>
                                        <p class="p3">年付</p> <span class="span1-2">￥</span> <span
                                            class="span2-2">定制</span>
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
                        <p>热销产品</p>
                        <div class="title-hr"></div>
                    </div>
                    <div class="tz-fuwu">
                        <div class="tz-main">
                            <div class="tz-fuwu-box">
                                <div class="fuwu-li ">
                                    <div class="server-hire-fuwu-li">
                                        <p class="hire-li-t">惠州双线 50G 防御 </p>

                                    </div>
                                    <div class="server-hire_items clear">
                                        <ul class="server-hire_ul">
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>CPU:八核16线程 Xeon E5530*2</p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>内存:8G</p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>硬盘:300G SAS/1T SATA</p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>防御：G口 （20M独享）</p>
                                            </li>
                                        </ul>
                                        <div class="price">
                                            <span>￥</span>
                                            <div class="money">
                                                <p>900</p>/月
                                            </div>
                                            <!-- <a href="/">立即购买</a> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="fuwu-li">
                                    <div class="server-hire-fuwu-li">
                                        <p class="hiret-li-t">衡阳双线 40G 防御</p>
                                    </div>

                                    <div class="server-hire_items clear">
                                        <ul class="server-hire_ul">
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>CPU:Xeon E5530*2 | L5630*2 </p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>内存:8G</p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>硬盘:1T SATA</p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>带宽:G口(20M独享）</p>
                                            </li>
                                        </ul>
                                        <div class="price">
                                            <span>￥</span>
                                            <div class="money">
                                                <p>900</p>/月
                                            </div>
                                            <!-- <a href="/">立即购买</a> -->
                                        </div>
                                    </div>

                                </div>
                                <div class="fuwu-li">
                                    <div class="server-hire-fuwu-li">
                                        <p class="hire-li-t">高防320G抗D+无限CC</p>
                                    </div>

                                    <div class="server-hire_items clear">
                                        <ul class="server-hire_ul">
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>CPU:八核16线程 Xeon E5570* 2 </p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>内存:16G</p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>硬盘:240G（固态硬盘）</p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>带宽:G口（100M独享）</p>
                                            </li>
                                        </ul>
                                        <div class="price">
                                            <span>￥</span>
                                            <div class="money">
                                                <p>3500</p>/月
                                            </div>
                                            <!-- <a href="/">立即购买</a> -->
                                        </div>
                                    </div>

                                </div>
                                <div class="fuwu-li">
                                    <div class="server-hire-fuwu-li">
                                        <p class="hire-li-t">高防320G抗D+无限CC</p>
                                    </div>

                                    <div class="server-hire_items clear">
                                        <ul class="server-hire_ul">
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>CPU:八核16线程 Xeon E5530* 2 </p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>内存:8G</p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>硬盘:300G SAS/1T SATA</p>
                                            </li>
                                            <li>
                                                <img src="{{ asset("/images/wap/星星.png") }}" alt="">
                                                <p>带宽:G口（100M独享）</p>
                                            </li>
                                        </ul>
                                        <div class="price">
                                            <span>￥</span>
                                            <div class="money">
                                                <p>1299</p>/月
                                            </div>
                                            <!-- <a href="/">立即购买</a> -->
                                        </div>
                                    </div>

                                </div>
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
                                <ul class="clear">
                                    <li class="m">
                                        <img src="{{ asset("/images/wap/场景-游戏.png") }}" alt="">
                                    </li>
                                    <li>
                                        <img src="{{ asset("/images/wap/场景-金融.png") }}" alt="">
                                    </li>
                                    <li class="m">
                                        <img src="{{ asset("/images/wap/场景-电商.png") }}" alt="">
                                    </li>
                                    <li>
                                        <img src="{{ asset("/images/wap/场景-流媒体.png") }}" alt="">
                                    </li>
                                    <li class="m">
                                        <img src="{{ asset("/images/wap/场景-APP小程序.png") }}" alt="">
                                    </li>
                                    <li>
                                        <img src="{{ asset("/images/wap/场景-数据存储下载备份.png") }}" alt="">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 机房介绍 -->
                    <div class="computer-room">
                        <div class="title">
                            <p style="color: #fff !important;">机房介绍</p>
                            <div style="background-color: #fff !important;" class="title-hr"></div>
                        </div>
                        <div class="computer-box">
                            <div class="region">
                                <p class="active-room">湖南衡阳机房</p>
                                <p>广东惠州机房</p>
                                <p>陕西西安机房</p>
                            </div>
                            <div class="computer-content">
                                <div class="tz-main">
                                    <table class="active-tab" border="1" cellspacing="0">
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
                                            <td>机房特性</td>
                                            <td>机房带宽资源充足，地处华中南北互通性很强，特别针对全国性的业务优势更加明显</td>
                                        </tr>
                                        <tr>
                                            <td>数据中心地址</td>
                                            <td>湖南省衡阳市石鼓区蒸水桥北互联网数据中心</td>
                                        </tr>
                                    </table>
                                    <table border="1" cellspacing="0">
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
                                            <td>1.6T，直连中国华南地区国际出口电信骨干网</td>
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
                                            <td>机房特性</td>
                                            <td>机房带宽资源充足，地处华中南北互通性很强，特别针对全国性的业务优势更加明显</td>
                                        </tr>
                                        <tr>
                                            <td>数据中心地址</td>
                                            <td>广东省惠州市惠城区东湖二街东平互联网数据中心</td>
                                        </tr>
                                    </table>
                                    <table border="1" cellspacing="0">
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
                                            <td>机房特性</td>
                                            <td>机房带宽资源充足，地处华中南北互通性很强，特别针对全国性的业务优势更加明显</td>
                                        </tr>
                                        <tr>
                                            <td>数据中心地址</td>
                                            <td>陕西省西咸新区沣西新城</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 机房优势 -->
                    <div class="compouter-advantage">
                        <div class="title">
                            <p style="color: #fff !important;">机房优势</p>
                            <div style="background-color: #fff !important;" class="title-hr"></div>
                        </div>
                        <div class="advantage-li clear">
                            <div class="tz-main">
                                <ul>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/节点覆盖全国   .png") }}" alt="">
                                        <div>节点覆盖全球</div>
                                        <p>网络节点覆盖全国，开通多省N*40G直联链路</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/总出口达10T   .png") }}" alt="">
                                        <div>总出口达10T</div>
                                        <p>总出口达到10T，带宽资源充足，随时升级G口 </p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/集群超高防御.png") }}" alt="">
                                        <div>集群超高防御</div>
                                        <p>大带宽接入+超强防火墙集群，DDOS不再是噩梦 </p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/安全防护体系.png") }}" alt="">
                                        <div>安全防护体系</div>
                                        <p>自研安全牵引系统+数据安全防护体系=数据安全 </p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/成熟技术团队.png") }}" alt="">
                                        <div>成熟技术团队</div>
                                        <p>有多年互联网安全技术研究经验高级工程师团队 </p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/多节点网络监控.png") }}" alt="">
                                        <div>多节点网络监控</div>
                                        <p>多节点网络监控, 服务器状态可视, 故障秒级上报 </p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/储备电力系统    .png") }}" alt="">
                                        <div>储备电力系统</div>
                                        <p>双路供电, 10kv高压柴油发电机组, 24h燃油储备 </p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/星级消防系统    .png") }}" alt="">
                                        <div>星级消防系统</div>
                                        <p>采用先进有管网式气体消防系统</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/服务支持体系.png") }}" alt="">
                                        <div>服务支持体系</div>
                                        <p>技术驻点机房7*24售后、工单秒级响应服务支持 </p>
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
                                        <p>网页游戏服务器租用如何选择？</p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>游戏服务器租用的演变</p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>游戏服务器是什么 游戏服务器租用...</p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>便宜的服务器租用怎么样 好吗?</p>
                                        <p>2019.06.01</p>
                                    </li>
                                    <li class="clear">
                                        <img src="{{ asset("/images/wap/问题.png") }}" alt="">
                                        <p>腾正科技的服务器怎么样？ </p>
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