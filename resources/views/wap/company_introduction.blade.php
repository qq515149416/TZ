@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

<!-- 企业文化 -->

<div id="company_introduction">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/企业文化海报.png") }}" alt="">
                        <a class="posters-btn">立即咨询</a>
                    </div>
                    <div class="drop-options">
                        <div class="drop-options">
                            <p>{{$page_info[$page]['name']}}</p>
                            <span class="arrow"></span>
                            <ul class="select-text clear">
                                <li class="option-i" value="0" selected>公司简介</li>
                                <li class="option-i" value="1">新闻公告</li>
                                <li class="option-i" value="2">荣誉资质</li>
                                <li class="option-i" value="3">企业文化</li>
                                <li class="option-i" value="4">发展历程</li>
                                <li class="option-i" value="5">联系我们</li>
                                <li class="option-i" value="6">支付中心</li>
                            </ul>
                        </div>
                    </div>
                    <!-- 公司介绍 -->
                    <div class="option-text {{ $page=='company_introduction'?'option-e-active':'' }}">
                        <div class="company-content">
                            <div class="a-title">
                                百川沸<p>腾</p> 笃志腾<p>正</p>
                            </div>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;广东腾正计算机科技有限公司（以下简称腾正科技）一家专注于互联网安全技术研究的现代网络综合服务性的高科技公司，为企业提供领先、安全、高效、全面的互联网运营服务。总部位于东莞松山湖国际金融IT研发创新园，旗下全资拥有两家子公司，长沙正易网络科技有限公司和广东腾川网络科技有限公司及多家分子公司，简历了以华南的广东、华中的湖南、西部的西安、东北的浙江四大核心数据中心及多个IDC节点，服务的企业遍布各个行业。
                            </p>
                            <img src="{{ asset("/images/wap/公司简介.png") }}" alt="">
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;腾正科技的产品线涵盖了IDC数据中心，数据安全，云计算，DNS&CDN，系统研发，电商平台基础支撑等领域。在IDC数据中心、大数据分析、数据安全、系统研发、网络运营领域拥有领先技术，目前已获得10余项自有软件著作权和专利权，其中，腾正科技打造的TzCloud公有云-云计算操作系统，获得中国信息安全评测中心等级安全认证，给予“安全可控优秀云计算解决方案”的评价。腾正云投入使用后，与曙光、南方报业集团等上百家知名公司建立了胜读合作。
                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;面对互联网产业蓬勃发展的全球化格局，为了更好的迎接互联网时代的浪潮，腾正科技以提供安全的互联网解决方案为目标，始终坚持以客户为中心，以市场的需求和客户业务的发展为导向，以互联网安全技术为核心，挖掘潜力开拓创新，加强互联网与整个产业体系的融合力度，为广大的互联网同行与合作伙伴提供优质的产品和完善的服务。
                            </p>
                        </div>
                    </div>
                    <!-- 新闻公告 -->
                    <div class="option-text {{ $page=='news'?'option-e-active':'' }}">
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="news">
                            <div class="news-text-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="news-text-content">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至...
                            </div>
                            <div class="news-text-time">
                                2019-06-06
                            </div>
                        </div>
                        <div class="bottom" id="bottom">
                            <!-- <div style="width: 85px;">
                                <img src="{{ asset("/images/wap/第一页.png") }}" alt="">
                                <img src="{{ asset("/images/wap/上一页.png") }}" alt="">
                            </div>

                            <div class="page" id="page">
                                <span>01</span>/03
                            </div>
                            <div style="width: 85px;">
                                <img src="{{ asset("/images/wap/下一页.png") }}" alt="">
                                <img src="{{ asset("/images/wap/最后一页.png") }}" alt="">
                            </div> -->
                        </div>

                    </div>
                    <!-- 荣誉资质 -->
                    <div class="option-text {{ $page=='honor'?'option-e-active':'' }}">
                        <div class="honor honor-a">
                            <div class="title back-w">
                                <p>腾正科技版权</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="honor-i clear active">
                                <div class="honor-t ">
                                    <img src="{{ asset("/images/wap/腾正互联数据中心交流平台.jpg") }}" alt="">
                                    <p>腾正互联数据中心交流平台</p>
                                </div>
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/腾正互联数据中心交流平台.jpg") }}" alt="">
                                    <p>腾正下载站平台</p>
                                </div>
                            </div>
                            <div class="honor-i clear">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/腾正防火墙牵引系统版权.jpg") }}" alt="">
                                    <p>腾正防火墙牵引系统版权</p>
                                </div>
                                <div class="honor-t ">
                                    <img src="{{ asset("/images/wap/腾正防火墙系统.jpg") }}" alt="">
                                    <p>腾正防火墙系统</p>
                                </div>
                            </div>
                            <div class="honor-i clear">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/腾正内容发网络管理系统V1.0.jpg") }}" alt="">
                                    <p>腾正内容发网络管理系统V1.0</p>
                                </div>
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/腾正域名备案软件.jpg") }}" alt="">
                                    <p>腾正域名备案软件</p>
                                </div>
                            </div>
                            <div class="honor-i clear">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/腾正自动化办公系统版权.jpg") }}" alt="">
                                    <p>腾正自动化办公系统版权</p>
                                </div>
                            </div>

                            <div class="bottom" id="bottom">
                                <div style="width: 93px;left: 12px;">
                                    <img src="{{ asset("/images/wap/第一页.png") }}" alt=""class="p-firsta ">
                                    <img src="{{ asset("/images/wap/上一页.png") }}" alt="" class="p-prea ">
                                </div>

                                <div class="page">
                                    <span id="pageNumber">01</span>/04
                                </div>
                                <div style="width: 93px; right: 12px;">
                                    <img src="{{ asset("/images/wap/下一页.png") }}" alt="" class="p-nexta">
                                    <img src="{{ asset("/images/wap/最后一页.png") }}" alt="" class="p-lasta">
                                </div>

                            </div>
                        </div>
                        <div class="honor honor-b">
                            <div class="title back-w">
                                <p>腾正科技荣誉</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="honor-i clear active">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/云计算十佳应用创新奖.png") }}" alt="">
                                    <p>2018-2019年度智慧城市云计算十佳应用创新奖</p>
                                </div>
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/2018华为最佳行业合作伙伴伽马奖.png") }}" alt="">
                                    <p>2018华为最佳行业合作伙伴伽马奖</p>
                                </div>
                            </div>
                            <div class="honor-i clear">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/东莞市电子商务联合会.jpg") }}" alt="">
                                    <p>东莞市电子商务联合会</p>
                                </div>
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/东莞市电子商务联合会会员单位.jpg") }}" alt="">
                                    <p>东莞市电子商务联合会会员单位</p>
                                </div>
                            </div>
                            <div class="honor-i clear">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/东莞市网络文化协会会员单位.jpg") }}" alt="">
                                    <p>东莞市网络文化协会会员单位</p>
                                </div>
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/东莞现代信息协会会员单位.jpg") }}" alt="">
                                    <p>东莞现代信息协会会员单位</p>
                                </div>
                            </div>
                            <div class="honor-i clear">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/广东省互联网协会常务理事会.jpg") }}" alt="">
                                    <p>广东省互联网协会常务理事会</p>
                                </div>
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/荣获“2015中国智慧城市十大IDC服务商”.jpg") }}" alt="">
                                    <p>荣获“2015中国智慧城市十大IDC服务商”</p>
                                </div>
                            </div>
                            <div class="honor-i clear">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/松山湖电商协会副会长单位.jpg") }}" alt="">
                                    <p>松山湖电商协会副会长单位</p>
                                </div>
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/中国互联网协会会员.jpg") }}" alt="">
                                    <p>中国互联网协会会员</p>
                                </div>
                            </div>
                            <div class="bottom">
                                <div style="width: 93px; left: 12px;">
                                    <img src="{{ asset("/images/wap/第一页.png") }}" alt=""class="p-firstb">
                                    <img src="{{ asset("/images/wap/上一页.png") }}" alt="" class="p-preb">
                                </div>

                                <div class="page">
                                    <span id="pageNumberb">01</span>/05
                                </div>
                                <div style="width: 93px; right: 12px;">
                                    <img src="{{ asset("/images/wap/下一页.png") }}" alt="" class="p-nextb">
                                    <img src="{{ asset("/images/wap/最后一页.png") }}" alt="" class="p-lastb">
                                </div>

                            </div>
                        </div>
                        <div class="honor honor-c">
                            <div class="title back-w">
                                <p>腾正科技资质</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="honor-i clear active">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/腾正增值电信业务经营许可证.png") }}" alt="">
                                    <p>增值电信业务经营许可证</p>
                                </div>
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/IDC许可证.png") }}" alt="">
                                    <p>互联网数据中心业务</p>
                                </div>
                            </div>
                            <div class="honor-i clear">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/网络文化经营许可证（副本）.jpg") }}" alt="">
                                    <p>网络文化经营许可证（副本）</p>
                                </div>
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/质量管理体系认证.jpg") }}" alt="">
                                    <p>互联网数据中心业务</p>
                                </div>
                            </div>
                            <div class="honor-i clear">
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/IDC许可证.jpg") }}" alt="">
                                    <p>网络文化经营许可证（副本）</p>
                                </div>
                                <div class="honor-t">
                                    <img src="{{ asset("/images/wap/广播电视节目制作经营许可证.jpg") }}" alt="">
                                    <p>广播电视节目制作经营许可证</p>
                                </div>
                            </div>

                            <div class="bottom">
                                <div style="width: 93px; left: 12px;">
                                    <img src="{{ asset("/images/wap/第一页.png") }}" alt="" class="p-firstc">
                                    <img src="{{ asset("/images/wap/上一页.png") }}" alt="" class="p-prec">
                                </div>

                                <div class="page">
                                    <span id="pageNumberc">01</span>/03
                                </div>
                                <div style="width: 93px; right: 12px;">
                                    <img src="{{ asset("/images/wap/下一页.png") }}" alt="" class="p-nextc">
                                    <img src="{{ asset("/images/wap/最后一页.png") }}" alt="" class="p-lastc">
                                </div>

                            </div>
                        </div>


                    </div>
                    <!-- 企业文化 -->
                    <div class="option-text {{ $page=='culture'?'option-e-active':'' }}">
                        <div class="culture">
                            <img src="{{ asset("/images/wap/企业文化服务宗旨.png") }}" alt="">
                        </div>
                        <div class="culture-a">
                            <div class="title back-w">
                                <p>核心价值观</p>
                                <div class="title-hr"></div>
                            </div>
                            <img src="{{ asset("/images/wap/分享.png") }}" alt="">
                            <img src="{{ asset("/images/wap/共赢.png") }}" alt="">
                            <img src="{{ asset("/images/wap/创新.png") }}" alt="">
                            <img src="{{ asset("/images/wap/诚信.png") }}" alt="">
                            <div class="title back-w">
                                <p>经营理念</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="culture-b">以客户为中心 <span>|</span> 以诚信为基础 <span>|</span> 以创新为发展</div>
                            <div class="title back-w">
                                <p>企业价值观</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="culture-b">为客户创造保障 <span>|</span> 为社会提供服务 <span>|</span> 为员工制造机会</div>
                        </div>
                        <div class="culture-a">
                            <div class="title back-w">
                                <p>社会责任</p>
                                <div class="title-hr"></div>
                            </div>
                            <span>腾正科技一直以一个优秀的负责任的企业姿态，积极承担起各种社会责任，捐赠，慈善义卖，弱势群体关爱，助学……腾正科技将公益事业看成是长期的过程，一直持续支持各类社会公益慈善活动。</span>
                            <span>2015年11月份，腾正爱心阳光基金会成立，表明了企业将公益作为一项事业持续开展的决心。腾正爱心阳光基金会将致力于公益慈善事业，关爱青少年教育成长，关爱弱势群体生活，倡导企业公民责任，推进社会和谐进步。</span>
                            <span>通过建立慈善基金会，腾正科技将自身当成一块磁铁，将尽力吸引更多的社会力量参与公益活动，共同关注教育与弱势群体，为需要帮助的人和地区提供实际的公益支援。</span>
                        </div>
                    </div>
                    <!-- 发展历程 -->
                    <div class="option-text {{ $page=='progress'?'option-e-active':'' }}">
                        <div class="hr"></div>
                        <div class="development-course">
                            <div class="year">
                                <p>2019</p>
                                <img src="{{ asset("/images/wap/圆点.png") }}" alt="">
                                <img src="{{ asset("/images/wap/对话框.png") }}" alt="">
                            </div>
                            <div class="development">
                                <ul>
                                    <li>
                                        <p>20019.01</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获工信部固定网国内数据传送业务经营许可证
                                        </p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获华为最佳行业合作伙伴伽马奖
                                        </p>
                                    </li>
                                    <li>
                                        <p>2019.04</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获CMMI3级项目实施管理证书
                                        </p>
                                    </li>
                                    <li>
                                        <p>2019.05</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获ITSS信息技术服务运行维护标准三级证书
                                        </p>
                                    </li>
                                    <li>
                                        <p>2019.06</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获2018-2019年度智慧城市云计算十佳应用创新奖
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="development-course">
                            <div class="year">
                                <p>2018</p>
                                <img src="{{ asset("/images/wap/圆点.png") }}" alt="">
                                <img src="{{ asset("/images/wap/对话框.png") }}" alt="">
                            </div>
                            <div class="development">
                                <ul>
                                    <li>
                                        <p>20018.05</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获广东省科学技术厅、广东省财政厅、广东省国家税务局、广东省地方税务局联合颁发的“高新技术企业证书”
                                        </p>
                                    </li>
                                    <li>
                                        <p>2018.07</p>
                                        <p>
                                            <span></span>
                                            腾正科技一次性获工信部颁发CDN、VPN和云牌照“三牌照”
                                        </p>
                                    </li>
                                    <li>
                                        <p>2018.10</p>
                                        <p>
                                            <span></span>
                                            腾正科技西安分公司成立
                                        </p>
                                    </li>
                                    <li>
                                        <p>2018.12</p>
                                        <p>
                                            <span></span>
                                            腾正科技上海分公司-上海泰正科技公司成立
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="development-course">
                            <div class="year">
                                <p>2017</p>
                                <img src="{{ asset("/images/wap/圆点.png") }}" alt="">
                                <img src="{{ asset("/images/wap/对话框.png") }}" alt="">
                            </div>
                            <div class="development">
                                <ul>
                                    <li>
                                        <p>20017.10</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获工信部云服务业务许可牌照
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="development-course">
                            <div class="year">
                                <p>2016</p>
                                <img src="{{ asset("/images/wap/圆点.png") }}" alt="">
                                <img src="{{ asset("/images/wap/对话框.png") }}" alt="">
                            </div>
                            <div class="development">
                                <ul>
                                    <li>
                                        <p>20016.01</p>
                                        <p>
                                            <span></span>
                                            腾正科技投入资金一千万携手金盾，打造国内顶尖的网络安全系统
                                        </p>
                                        <p>
                                            <span></span>
                                            腾正科技为广东省互联网协会常务理事单位
                                        </p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获“2015年度东莞十大成长性企业”
                                        </p>
                                    </li>
                                    <li>
                                        <p>2016.03</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获iso9001质量管理体系认证证书
                                        </p>
                                    </li>
                                    <li>
                                        <p>2016.04</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获广东省文化厅颁发的“网络文化经营许可证”
                                        </p>
                                    </li>
                                    <li>
                                        <p>2016.05</p>
                                        <p>
                                            <span></span>
                                            腾正科技子公司广东腾川计算机系统有限公司正式营业
                                        </p>
                                    </li>
                                    <li>
                                        <p>2016.09</p>
                                        <p>
                                            <span></span>
                                            腾正科技正式加入松山湖（生态园）高新技术企业上市促进会
                                        </p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获得《广播电视节目制作经营许可证》
                                        </p>
                                    </li>
                                    <li>
                                        <p>2016.11</p>
                                        <p>
                                            <span></span>
                                            腾正科技与中国电信股份有限公司惠州分公司签署战略合作
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="development-course">
                            <div class="year">
                                <p>2015</p>
                                <img src="{{ asset("/images/wap/圆点.png") }}" alt="">
                                <img src="{{ asset("/images/wap/对话框.png") }}" alt="">
                            </div>
                            <div class="development">
                                <ul>
                                    <li>
                                        <p>20015.03</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获得国家工信局颁发的IDC/ISP全网证
                                        </p>
                                    </li>
                                    <li>
                                        <p>2015.04</p>
                                        <p>
                                            <span></span>
                                            腾正科技与湖南卫视达成战略合作，为旗下“芒果TV”提供分发点
                                        </p>
                                    </li>
                                    <li>
                                        <p>2015.10</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获广东省文化厅颁发的“网络文化经营许可证”
                                        </p>
                                    </li>
                                    <li>
                                        <p>2015.11</p>
                                        <p>
                                            <span></span>
                                            腾正科技惠州自主运营IDC数据中心正式启用
                                        </p>
                                        <p>
                                            <span></span>
                                            腾正科技于第四届中国惠州物联网云计算技术应用博览会，正式公开发布“腾正云”上市
                                        </p>
                                        <p>
                                            <span></span>
                                            “腾正云”被广东省经济和信息化委员会列为促进云计算创新发展重要任务
                                        </p>
                                    </li>
                                    <li>
                                        <p>2015.12</p>
                                        <p>
                                            <span></span>
                                            腾正科技喜获“2015中国智慧城市十大IDC服务商”
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="development-course">
                            <div class="year">
                                <p>2014</p>
                                <img src="{{ asset("/images/wap/圆点.png") }}" alt="">
                                <img src="{{ asset("/images/wap/对话框.png") }}" alt="">
                            </div>
                            <div class="development">
                                <ul>
                                    <li>
                                        <p>20014.06</p>
                                        <p>
                                            <span></span>
                                            广东腾正计算机科技有限公司注册成立（简称“腾正科技”）
                                        </p>
                                    </li>
                                    <li>
                                        <p>2014.08</p>
                                        <p>
                                            <span></span>
                                            腾正科技收购长沙正易网络科技有限公司，并开通湖南衡阳IDC数据中心
                                        </p>
                                    </li>
                                    <li>
                                        <p>2014.09</p>
                                        <p>
                                            <span></span>
                                            腾正科技与中科院合作，协助G-Cloud云操作平台的工信部“可信云”认证
                                        </p>
                                    </li>
                                    <li>
                                        <p>2014.10</p>
                                        <p>
                                            <span></span>
                                            腾正科技开通辽宁沈阳、广东东莞IDC数据中心，完成东北及华南地区的数据中心节点部署
                                        </p>
                                        <p>
                                            <span></span>
                                            腾正科技为（中国）首届世界互联网大会提供数据存储、数据安全、技术支撑等服务
                                        </p>
                                    </li>
                                    <li>
                                        <p>2014.11</p>
                                        <p>
                                            <span></span>
                                            腾正科技开通贵州贵阳IDC数据中心，西南地区数据中心节点部署完成
                                        </p>
                                    </li>
                                    <li>
                                        <p>2014.12</p>
                                        <p>
                                            <span></span>
                                            腾正科技并购佛山捷信，开通佛山IDC数据中心
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 联系我们 -->
                    <div class="option-text {{ $page=='contact'?'option-e-active':'' }}">
                        <div class="contact-us">
                            <div class="title back-w">
                                <p>公司对公账户</p>
                                <div class="title-hr"></div>
                            </div>
                            <table class="table-box" border="1" cellspacing="0">
                                <tr>
                                    <td>销售一部直线</td>
                                    <td>0769-22895563</td>
                                </tr>
                                <tr>
                                    <td>销售二部直线</td>
                                    <td>0769-22895561</td>
                                </tr>
                                <tr>
                                    <td>销售三部直线</td>
                                    <td>0769-22895564</td>
                                </tr>
                            </table>
                            <table class="table-box" border="1" cellspacing="0">
                                <tr>
                                    <td>传真：0769-22385552</td>
                                    <td>邮编：523000</td>
                                </tr>
                            </table>
                        </div>
                        <div class="contact-us">
                            <div class="title back-w">
                                <p>投诉建议</p>
                                <div class="title-hr"></div>
                            </div>
                            <table class="table-box3" border="1" cellspacing="0">
                                <tr>
                                    <td>电话</td>
                                    <td>QQ号</td>
                                    <td>邮箱</td>
                                </tr>
                                <tr>
                                    <td>18922986777</td>
                                    <td>2851506990</td>
                                    <td>pzw@tzidc.com</td>
                                </tr>
                            </table>
                            <div class="title back-w">
                                <p>售后服务</p>
                                <div class="title-hr"></div>
                            </div>
                            <table class="table-box3" border="1" cellspacing="0">
                                <tr>
                                    <td>电话</td>
                                    <td>QQ号</td>
                                    <td>邮箱</td>
                                </tr>
                                <tr>
                                    <td>15399941777</td>
                                    <td>2851506990</td>
                                    <td>crc@tzidc.com</td>
                                </tr>
                            </table>
                            <div class="title back-w">
                                <p>备案专员</p>
                                <div class="title-hr"></div>
                            </div>
                            <table class="table-box3" border="1" cellspacing="0">
                                <tr>
                                    <td>电话</td>
                                    <td>QQ号</td>
                                    <td>邮箱</td>
                                </tr>
                                <tr>
                                    <td>15387558899</td>
                                    <td>3134597671</td>
                                    <td>crc@tzidc.com</td>
                                </tr>
                            </table>
                        </div>
                        <div class="contact-us">
                            <div class="title back-w">
                                <p>售前人员</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="personnel">
                                <div class="personnel-a active-block">
                                    <ol>
                                        <li>
                                            <p>禹豪</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>15622908447</td>
                                                    <td>2853978330</td>
                                                    <td>2853978330@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>秋霞</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>18218649432</td>
                                                    <td>2851506995</td>
                                                    <td>2851506995@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>镜雄</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13592703394</td>
                                                    <td>2851506992</td>
                                                    <td>2851506992@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>国东</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>16620655846</td>
                                                    <td>2851506993</td>
                                                    <td>2851506993@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>帅东</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13922933992</td>
                                                    <td>2853978331</td>
                                                    <td>2853978331@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>嘉辉</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>18028237786</td>
                                                    <td>2853978334</td>
                                                    <td>2853978334@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>小庞</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13123456789</td>
                                                    <td>2851506990</td>
                                                    <td>2851506990@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>成龙</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13790423606</td>
                                                    <td>2885655958</td>
                                                    <td>2885655958@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                    </ol>
                                </div>
                                <div class="personnel-a">
                                    <ol>
                                        <li>
                                            <p>增清</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>15382877369</td>
                                                    <td>2851217786</td>
                                                    <td>2851217786@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>智超</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13686205712</td>
                                                    <td>2851217785</td>
                                                    <td>2851217785@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>金文</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>17876594109</td>
                                                    <td>2851506994</td>
                                                    <td>2851506994@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>肖涛</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13790662084</td>
                                                    <td>2853978337</td>
                                                    <td>2853978337@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>运莹</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13686205712</td>
                                                    <td>2853978336</td>
                                                    <td>2853978336@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>邹琪</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13713496019</td>
                                                    <td>2885693355</td>
                                                    <td>2885693355@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>王政</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>18098216572</td>
                                                    <td>2851506998</td>
                                                    <td>2851506998@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>罗冰</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13380134041</td>
                                                    <td>2885611879</td>
                                                    <td>2885611879@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                    </ol>
                                </div>
                                <div class="personnel-a">
                                    <ol>
                                        <li>
                                            <p>邦松</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>19185358729</td>
                                                    <td>2853978338</td>
                                                    <td>2853978338@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>范涛</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>15625736001</td>
                                                    <td>2851217783</td>
                                                    <td>2851217783@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>秋雪</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13711944297</td>
                                                    <td>2851217789</td>
                                                    <td>2851217789@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>秋媛</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13268578030</td>
                                                    <td>2885650826</td>
                                                    <td>2885650826@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>成嘉</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>17628632854</td>
                                                    <td>2885840559</td>
                                                    <td>2885840559@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>涂彤</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>17603002745</td>
                                                    <td>2885655986</td>
                                                    <td>2885655986@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <p>家健</p>
                                            <table border="0" cellspacing="0">
                                                <tr>
                                                    <td>电话</td>
                                                    <td>QQ</td>
                                                    <td>邮箱</td>
                                                </tr>
                                                <tr>
                                                    <td>13172704478</td>
                                                    <td>2853978335</td>
                                                    <td>2853978335@qq.com</td>
                                                </tr>
                                            </table>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            <div class="bottom">
                                <div style="width: 93px;">
                                    <img src="{{ asset("/images/wap/第一页.png") }}" alt="" class="pagefirst">
                                    <img src="{{ asset("/images/wap/上一页.png") }}" alt="" class="pagepre">
                                </div>

                                <div class="page">
                                    <span id="pageNumber">01</span>/03
                                </div>
                                <div style="width: 93px;">
                                    <img src="{{ asset("/images/wap/下一页.png") }}" alt="" class="pagenext">
                                    <img src="{{ asset("/images/wap/最后一页.png") }}" alt="" class="pagelast">
                                </div>

                            </div>
                        </div>
                        <div class="contact-us">
                            <div class="title back-w">
                                <p>公司地址</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="address">
                                东莞总公司
                                <p>广东省东莞市松山湖科技十路国际金融IT研发中心2栋B座</p>
                            </div>
                            <div class="address">
                                惠州分公司
                                <p>广东省惠州市东平南路21号2栋第二层</p>
                            </div>
                            <div class="address">
                                陕西分公司
                                <p>陕西省西安市高新区瑞吉大厦7层10701-7634</p>
                            </div>
                            <div class="address">
                                湖南分公司
                                <p>湖南省长沙市高新开发区麓龙路209号单元402</p>
                            </div>
                            <div class="address">
                                上海分公司
                                <p>上海市金山工业区夏宁路666弄58_59号2064室</p>
                            </div>
                        </div>
                    </div>
                    <!-- 支付中心 -->
                    <div class="option-text {{ $page=='pay'?'option-e-active':'' }}">
                        <div class="corporate-account">
                            <div class="title back-w">
                                <p>公司对公账户</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="bank">
                                <img src="{{ asset("/images/wap/招商银行.png") }}" alt="">
                                <p>开户名称：广东腾正计算机科技有限公司</p>
                                <p>银行账户：7699 0507 2010 999</p>
                                <p>开户支行：招商银行东莞市松山湖支行</p>
                            </div>
                            <div class="bank">
                                <img src="{{ asset("/images/wap/中国农业银行.png") }}" alt="">
                                <p>开户名称：广东腾正计算机科技有限公司</p>
                                <p>银行账户：4430 8001 0400 08440</p>
                                <p>开户支行：农业银行东莞市松山湖支行</p>
                            </div>
                            <div class="bank">
                                <img src="{{ asset("/images/wap/中国建设银行.png") }}" alt="">
                                <p>开户名称：广东腾正计算机科技有限公司</p>
                                <p>银行账户：4405 0177 0053 0000 0295</p>
                                <p>开户支行：建设银行东莞市松山湖支行</p>
                            </div>
                            <div class="bank">
                                <img src="{{ asset("/images/wap/中国工商银行.png") }}" alt="">
                                <p>开户名称：广东腾正计算机科技有限公司</p>
                                <p>银行账户：2010 0504 1910 0112 087</p>
                                <p>开户支行：工商银行东莞市松山湖支行</p>
                            </div>
                            <div class="bank">
                                <img src="{{ asset("/images/wap/中国银行.png") }}" alt="">
                                <p>开户名称：长沙正易网络科技有限公司</p>
                                <p>银行账户：5898 6197 0187</p>
                                <p>开户支行：中国银行股份有限公司长沙市银盆岭支行</p>
                            </div>
                        </div>
                        <div class="corporate-account">
                            <div class="title back-w">
                                <p>在线支付</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="online-payment clear">
                                <img src="{{ asset("/images/wap/支付宝.png") }}" alt="">
                                <img src="{{ asset("/images/wap/支付宝二维码.png") }}" alt="">
                                <p>开户名称：广东腾正</p>
                                <p>支付宝账户：pay@txidc.com</p>
                            </div>
                            <div class="online-payment clear">
                                <img src="{{ asset("/images/wap/微信支付.png") }}" alt="">
                                <img src="{{ asset("/images/wap/微信二维码.png") }}" alt="">
                                <p>开户名称：广东腾正</p>
                                <p>微信账户：GDtengzheng</p>
                            </div>
                        </div>
                        <div class="corporate-account">
                            <div class="title back-w">
                                <p>汇款注意事项</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="matters-needing">
                                <p>①汇款后请将付款底单信息截图发给售前客服处理，由售前客服提交财务确认</p>
                                <p>②请务必注明您的会员账号及订单号等信息</p>
                                <p>③为了更快速处理您的订单，请务必及时发送付款底单信息</p>
                                <p>④注意事项：银行电汇底单必须有银行加盖的转讫章；邮局收据上应有邮局日戳</p>
                                <p>⑤招行、工行、农行、邮局汇款均是立即到账，建行、中行为2各 小时到账，企业对公账号3-5天内到账</p>
                            </div>
                        </div>
                        <div class="corporate-account">
                            <div class="title back-w">
                                <p>退款注意事项</p>
                                <div class="title-hr"></div>
                            </div>
                            <div class="matters-needing">
                                <p>①我公司承诺属产品质量问题且确认无法解决的均可以退款</p>
                                <p>②退款时请填写退款申请表</p>
                                <p>③请邮寄退款申请表及证件（个人或企业）至公司</p>
                                <p>④我们将在收到申请表之后的7个工作日内给您办理退款手续</p>
                                <p>⑤款项将退还到您注册的会员名下</p>
                            </div>
                        </div>
                    </div>

                    <!-- 新闻公告 内容页 -->
                    <div class="news-content ">
                        <div class="content">
                            <div class="content-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="content-time">2019-06-06 12:03:39</div>
                            <div class="content-main">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至6月9日放假，共3天。
                            </div>
                            <div class="content-text clear">
                                <div>
                                    <p>尊敬的腾正用户：</p>
                                    <p> 　　您好!端午节将至，根据《国务院办公厅关于 2019
                                        年部分节假日安排通知》，我司定于2019年6月7日至6月9日放假，共3天。放假期间，我司安排工作人员24小时值班，为您提供不间断的业务咨询，技术方案，售后处理等服务。感谢您一直以来对腾正科技的支持和信任！在此提前祝您国庆节快乐！
                                    </p>

                                </div>
                                <div>
                                    <p>24小时技术专线：0769-22385558 15399941777</p>
                                    <p>售后服务企业QQ：800093515</p>
                                    <p>业务咨询电话：18922986777、18028237786</p>
                                    <p>企业QQ：2851506990、2853978334</p>
                                </div>
                                <div>
                                    <p>温馨提示：</p>
                                    <p>1.放假期间避免进行重大业务变更</p>
                                    <p>2.提前安排运维监控和合理备份</p>
                                    <p>3.请关注余额和资源到期时间，如有需要及时续费</p>
                                    <p>4.备案咨询业务正常，审核业务因通信管理局假期原因暂停，6月10日恢复正常</p>
                                </div>
                                <div>
                                    <p>腾正科技</p>
                                    <p>2019年6月6日</p>
                                </div>
                            </div>
                        </div>
                        <div class="news-more">
                            <p>上一篇：实现腾正科技共赢|腾正科技...</p>
                            <p>下一篇：没有了</p>
                            <img src="{{ asset("/images/wap/内容页按钮.png") }}" alt="">
                        </div>
                    </div>

                    <!-- 蓝条 -->
                    <!-- <div class="solutions-consulting">
                        <img src="{{ asset("/images/wap/企业文化蓝条.png") }}" alt="">
                        <a>
                            立即咨询
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

@endsection
