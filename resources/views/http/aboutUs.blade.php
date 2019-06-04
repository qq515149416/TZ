
@extends('layouts.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机,高防服务器,高防IP,服务器租用,服务器托管,带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC 服务器商,网络安全服务商')

@section('description', '专业IDC服务提供商，主营服务器租用、服务器托管、机柜租用、大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
    <div id="aboutus" class="row">
        @aboutusLayout(['title' => '关于我们', 'subtitle' => '腾正科技-互联网应用支撑商', 'descripts' => '一家专注于互联网安全技术研究的现代网络综合服务性的高科技公司，为您提供IDC·云计算·安全防护一站式产品解决方案服务。'])
        @slot('nav')
            <li role="presentation" class="{{ $page === 'index' ? 'active' : '' }}"><a href="#descripts" aria-controls="descripts" role="tab" data-toggle="tab">公司介绍</a></li>
            <li role="presentation" class="{{ $page === 'rongyu' ? 'active' : '' }}"><a href="#rongyu" aria-controls="rongyu" role="tab" data-toggle="tab">荣誉资质</a></li>
            <li role="presentation" class="{{ $page === 'wenhua' ? 'active' : '' }}"><a href="#wenhua" aria-controls="wenhua" role="tab" data-toggle="tab">企业文化</a></li>
            <li role="presentation" class="{{ $page === 'fazhang' ? 'active' : '' }}"><a href="#fazhang" aria-controls="fazhang" role="tab" data-toggle="tab">发展历程</a></li>
            <li role="presentation" class="{{ $page === 'lianxi' ? 'active' : '' }}"><a href="#lianxi" aria-controls="lianxi" role="tab" data-toggle="tab">联系我们</a></li>
            <li role="presentation" class="{{ $page === 'pay' ? 'active' : '' }}"><a href="#pay" aria-controls="pay" role="tab" data-toggle="tab">支付中心</a></li>
        @endslot
        <div role="tabpanel" class="tab-pane {{ $page === 'index' ? 'active' : '' }} clearfix" id="descripts">
            <h2>
                公司简介
                <span class="pull-right">
                    <a href="#">首页</a> >
                    <a href="#">关于我们</a> >
                    <a href="#" class="active">公司介绍</a>
                </span>
            </h2>
            <p class="topline">
            广东腾正计算机科技有限公司（以下简称腾正科技）一家专注于互联网安全技术研究的现代网络综合服务性的高科技公司，为企业提供领先、安全、高效、全面的互联网运营服务。总部位于东莞松山湖国际金融IT研发创新园，旗下全资拥有两家子公司，长沙正易网络科技有限公司和广东腾川网络科技有限公司及多家分子公司，建立了以华南的广东、华中的湖南、西部的西安、北部的吉林、东北的浙江五大核心数据中心及多个IDC节点，服务的企业遍布各个行业。
            </p>
            <img class="pull-left" src="{{ asset("/images/introduction.png") }}" alt="" />
            <p>
            腾正科技的产品线涵盖了IDC数据中心，数据安全，云计算，DNS&CDN，系统研发，电商平台基础支撑等领域。在IDC数据中心、大数据分析、数据安全、系统研发、网络运营领域拥有领先技术，目前已获得10余项自有软件著作权和专利权。其中，腾正科技打造的TzCloud公有云-云计算操作系统，获得了中国信息安全评测中心等级安全认证，给予”安全可控优秀云计算解决方案”的评价。腾正云投入使用后，与曙光、南方报业集团等上百家知名公司建立了深度合作。
            </p>
            <p>
            面对互联网产业蓬勃发展的全球化格局，为了更好的迎接互联网时代的浪潮，腾正科技以提供安全的互联网解决方案为目标，始终坚持以客户为中心，以市场的需求和客户业务的发展为先导，以互联网安全技术为核心，以专业、快速的售后服务为支撑，本着坚定的信念，挖掘潜力开拓创新，加强互联网与整个产业体系的融合力度，为广大的互联网同行与合作伙伴提供优质的产品和完善的服务。
            </p>
            <img class="slogan clearfix" src="{{ asset("/images/boiling.png") }}" alt="" />
        </div>
        <div role="tabpanel" class="tab-pane {{ $page === 'rongyu' ? 'active' : '' }}" id="rongyu">
            <h2>
                荣誉资质
                <span class="pull-right">
                    <a href="#">首页</a> >
                    <a href="#">关于我们</a> >
                    <a href="#" class="active">荣誉资质</a>
                </span>
            </h2>
            <div class="certificate square">
                <div class="swiper-container certificate-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide swiper-no-swiping">
                            <ul class="clearfix">
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/01.jpg") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/02.jpg") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会会员单位</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/03.jpg") }}" alt="" />
                                    </a>
                                    <span>东莞市网络文化协会会员单位</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/04.jpg") }}" alt="" />
                                    </a>
                                    <span>东莞现代信息协会会员单位</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/05.jpg") }}" alt="" />
                                    </a>
                                    <span>广播电视节目制作经营许可证</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/06.jpg") }}" alt="" />
                                    </a>
                                    <span>广东省互联网协会常务理事会</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/07.jpg") }}" alt="" />
                                    </a>
                                    <span>荣获“2015中国智慧城市十大IDC服务商”</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/08.jpg") }}" alt="" />
                                    </a>
                                    <span>松山湖电商协会副会长单位</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/09.jpg") }}" alt="" />
                                    </a>
                                    <span>中国互联网协会会员</span>
                                </li>
                            </ul>
                        </div>

                        <!-- <div class="swiper-slide swiper-no-swiping">
                            <ul class="clearfix">
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/01.png") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会123</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/01.png") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/01.png") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/01.png") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/01.png") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/01.png") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/01.png") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/01.png") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/01.png") }}" alt="" />
                                    </a>
                                    <span>东莞市电子商务联合会</span>
                                </li>
                            </ul>
                        </div> -->

                    </div>
                </div>

                <div class="normal swiper-certificate-page text-center">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </div>

                <div class="swiper-container long-certificate-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide swiper-no-swiping">
                            <ul class="clearfix long">
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img class="long" src="{{ asset("/images/cert/long/01.jpg") }}" alt="" />
                                    </a>
                                    <span>腾正防火墙牵引系统版权</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img class="long" src="{{ asset("/images/cert/long/02.jpg") }}" alt="" />
                                    </a>
                                    <span>腾正防火墙系统</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img class="long" src="{{ asset("/images/cert/long/03.jpg") }}" alt="" />
                                    </a>
                                    <span>腾正互联数据中心技术交流平台</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/long/04.jpg") }}" alt="" />
                                    </a>
                                    <span>腾正内容发网络管理系统V1.0</span>
                                </li>
                            </ul>
                        </div>

                        <div class="swiper-slide swiper-no-swiping">
                            <ul class="clearfix long">
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img class="long" src="{{ asset("/images/cert/long/05.jpg") }}" alt="" />
                                    </a>
                                    <span>腾正域名备案软件</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img class="long" src="{{ asset("/images/cert/long/06.jpg") }}" alt="" />
                                    </a>
                                    <span>腾正增值电信业务经营许可证</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img class="long" src="{{ asset("/images/cert/long/07.jpg") }}" alt="" />
                                    </a>
                                    <span>腾正自动化办公系统版权</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img src="{{ asset("/images/cert/long/08.jpg") }}" alt="" />
                                    </a>
                                    <span>网络文化经营许可证（副本）</span>
                                </li>
                            </ul>
                        </div>

                        <div class="swiper-slide swiper-no-swiping">
                            <ul class="clearfix long">
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img class="long" src="{{ asset("/images/cert/long/09.jpg") }}" alt="" />
                                    </a>
                                    <span>质量管理体系认证</span>
                                </li>
                                <li>
                                    <a href="javascript:;" class="thumbnail">
                                        <img class="long" src="{{ asset("/images/cert/long/10.jpg") }}" alt="" />
                                    </a>
                                    <span>IDC许可证</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="long swiper-certificate-page text-center">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </div>

            </div>
        </div>
        <div role="tabpanel" class="tab-pane {{ $page === 'wenhua' ? 'active' : '' }}" id="wenhua">
            <h2>
                企业文化
                <span class="pull-right">
                    <a href="#">首页</a> >
                    <a href="#">关于我们</a> >
                    <a href="#" class="active">企业文化</a>
                </span>
            </h2>
            <div class="culture-list">
                <div class="culture-item">
                    <div class="title">
                        <h4>服务宗旨</h4>
                        <span>SERVICE TENET</span>
                    </div>
                    <div class="body">
                        <p>客户至上，务实创新</p>
                    </div>
                </div>
                <div class="culture-item">
                    <div class="title">
                        <h4>核心价值观</h4>
                        <span>CORE VALUES</span>
                    </div>
                    <div class="body">
                        <ul>
                            <li>
                                <span>分享：以开放的态度，分享资源，分享技术</span>
                            </li>
                            <li>
                                <span>共赢：在成功的道路上为客户护航，提供支撑，实现双赢目标</span>
                            </li>
                            <li>
                                <span>创新：以创新为发展动力，从技术创新和服务创新为导向，为客户提供更安全的保护</span>
                            </li>
                            <li>
                                <span>诚信：始终坚持用诚信赢得客户</span>
                            </li>
                        </ul>
                    </div>
                    <div class="culture-item">
                        <div class="title">
                            <h4>经营理念</h4>
                            <span>MANAGEMENT IDEA</span>
                        </div>
                        <div class="body">
                            <p>以客户为中心、以诚信为基础、以创新为发展</p>
                        </div>
                    </div>
                    <div class="culture-item">
                        <div class="title">
                            <h4>企业价值观</h4>
                            <span>CORPORATE VALUES</span>
                        </div>
                        <div class="body">
                            <ul>
                                <li>
                                    <span>为客户创造保障：如何保障客户的网络安全是腾正科技技术团队的工作导向，而为用户提供全面的互联网运营方案是腾正科技全体员工工作的目标。</span>
                                </li>
                                <li>
                                    <span>为社会提供服务：回馈社会，履行企业的社会责任，我们义不容辞；腾正爱心阳光基金会的成立，也是为了更好的服务社会，倡导企业公民责任，推进社会和谐进步。</span>
                                </li>
                                <li>
                                    <span>为员工制造机会：腾正科技以开放的态度，为所有的员工提供了最大的成长空间，我们愿意提供机会，只为让你在腾正成长为最好的你。</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="culture-item">
                        <div class="title">
                            <h4>社会责任</h4>
                            <span>SOCIAL RESPONSIBILITY</span>
                        </div>
                        <div class="body">
                            <ul>
                                <li>
                                    <span>腾正科技一直以一个优秀的负责任的企业姿态，积极承担起各种社会责任，捐赠，慈善义卖，弱势群体关爱，助学……腾正科技将公益事业看成是长期的过程，一直持续支持各类社会公益慈善活动。</span>
                                </li>
                                <li>
                                    <span>2015年11月份，腾正爱心阳光基金会成立，表明了企业将公益作为一项事业持续开展的决心。腾正爱心阳光基金会将致力于公益慈善事业，关爱青少年教育成长，关爱弱势群体生活，倡导企业公民责任，推进社会和谐进步。</span>
                                </li>
                                <li>
                                    <span>通过建立慈善基金会，腾正科技将自身当成一块磁铁，将尽力吸引更多的社会力量参与公益活动，共同关注教育与弱势群体，为需要帮助的人和地区提供实际的公益支援。</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane {{ $page === 'fazhang' ? 'active' : '' }}" id="fazhang">
            <h2>
                发展历程
                <span class="pull-right">
                    <a href="#">首页</a> >
                    <a href="#">关于我们</a> >
                    <a href="#" class="active">发展历程</a>
                </span>
            </h2>
            <img src="{{ asset("/images/history.png") }}" alt="" />
        </div>
        <div role="tabpanel" class="tab-pane {{ $page === 'lianxi' ? 'active' : '' }}" id="lianxi">
            <h2>
                联系我们
                <span class="pull-right">
                    <a href="#">首页</a> >
                    <a href="#">关于我们</a> >
                    <a href="#" class="active">联系我们</a>
                </span>
            </h2>
            <div class="culture-list">
                <div class="culture-item">
                    <div class="title">
                        <h4>联系方式</h4>
                        <span>CONTACT INFORMATION</span>
                    </div>
                    <div class="body">
                        <ul>
                            <li>销售一部直线：0769-22895563</li>
                            <li>销售二部直线：0769-22895561</li>
                            <li>销售三部直线：0769-22895564</li>
                            <li>传真：0769-22385552</li>
                            <li>邮编：523000</li>
                        </ul>
                    </div>
                </div>
                <div class="culture-item">
                    <div class="title">
                        <h4>投诉建议</h4>
                        <span>CONPLAINT SUGGESTION</span>
                    </div>
                    <div class="body">
                        <ul>
                            <li>电话：18922986777</li>
                            <li>QQ：2851506990</li>
                            <li>邮箱：pzw@tzidc.com</li>
                        </ul>
                    </div>
                </div>
                <div class="culture-item">
                    <div class="title">
                        <h4>售后服务</h4>
                        <span>AFTER-SALE SERVICE</span>
                    </div>
                    <div class="body">
                        <ul>
                            <li>
                                <span>电话：15399941777</span>
                                <span>0769-22385558</span>
                            </li>
                            <li>QQ：800093515</li>
                            <li>邮箱：crc@tzidc.com</li>
                        </ul>
                    </div>
                </div>
                <div class="culture-item">
                    <div class="title">
                        <h4>备案专员</h4>
                        <span>FILING SPECIALIST</span>
                    </div>
                    <div class="body">
                        <ul>
                            <li>
                                电话：15387558899
                            </li>
                            <li>QQ：3134597671</li>
                            <li>邮箱：crc@tzidc.com</li>
                        </ul>
                    </div>
                </div>
                <div class="culture-item">
                    <div class="title">
                        <h4>售前人员</h4>
                        <span>PRE SALES PERSONNEL</span>
                    </div>
                    <div class="body">
                        <table class="table">
                            @getContacts("table")
                        </table>
                    </div>
                </div>
                <div class="culture-item">
                    <div class="title">
                        <h4>公司地址</h4>
                        <span>COMPANY ADDRESS</span>
                    </div>
                    <div class="body">
                        <table class="table">
                            <tr>
                                <td>
                                    东莞总公司：广东省东莞市松山湖科技十路国际金融IT研发中心2栋B座
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    惠州分公司：广东省惠州市东平南路21号2栋第二层
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    陕西分公司：陕西省西安市高新区瑞吉大厦7层10701-7634
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    湖南分公司：湖南省长沙市高新开发区麓龙路209号单元402
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    上海分公司：上海市金山工业区夏宁路666弄58_59号2064室
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane {{ $page === 'pay' ? 'active' : '' }}" id="pay">
            <h2>
                支付中心
                <span class="pull-right">
                    <a href="#">首页</a> >
                    <a href="#">关于我们</a> >
                    <a href="#" class="active">支付中心</a>
                </span>
            </h2>
            <div class="culture-list">
                <div class="culture-item">
                    <div class="title">
                        <h4>公司对公帐户</h4>
                        <span>COMPANY'S PUBLIC ACCOUNT</span>
                    </div>
                    <div class="body">
                        <ul class="clearfix border">
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset("/images/pay/01.png") }}" alt="" />
                                </div>
                                <div class="dec">
                                    <p>开户名称：广东腾正计算机科技有限公司</p>
                                    <p>银行账号：7699 0507 2010 999</p>
                                    <p>开户支行：招商银行东莞松山湖支行</p>
                                </div>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset("/images/pay/02.png") }}" alt="" />
                                </div>
                                <div class="dec">
                                    <p>开户名称：广东腾正计算机科技有限公司</p>
                                    <p>银行账号：4430 8001 0400 08440</p>
                                    <p>开户支行：农业银行东莞市松山湖支行</p>
                                </div>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset("/images/pay/03.png") }}" alt="" />
                                </div>
                                <div class="dec">
                                    <p>开户名称：广东腾正计算机科技有限公司</p>
                                    <p>银行账号：4405 0177 0053 0000 0295</p>
                                    <p>开户支行：建设银行东莞市松山湖支行</p>
                                </div>
                            </li>
                        </ul>
                        <ul class="clearfix">
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset("/images/pay/04.png") }}" alt="" />
                                </div>
                                <div class="dec">
                                    <p>开户名称：广东腾正计算机科技有限公司</p>
                                    <p>银行账号：2010 0504 1910 0112 087</p>
                                    <p>开户支行：工商银行东莞松山湖支行</p>
                                </div>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset("/images/pay/05.png") }}" alt="" />
                                </div>
                                <div class="dec">
                                    <p>开户名称：长沙正易网络科技有限公司</p>
                                    <p>银行账号：5898 6197 0187</p>
                                    <p>开户支行：中国银行股份有限公司长沙市银盆岭支行</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="culture-item">
                    <div class="title">
                        <h4>在线支付</h4>
                        <span>ONLINE PAYMENT</span>
                    </div>
                    <div class="body">
                        <ul class="clearfix">
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset("/images/pay/06.png") }}" alt="" />
                                </div>
                                <div class="dec clearfix">
                                    <div class="pull-left">
                                        <p>开户名称：广东腾正</p>
                                        <p>支付宝账号：pay@tzidc.com</p>
                                    </div>
                                    <div class="pull-right">
                                        <img class="pay" src="{{ asset("/images/pay/payerweima.jpg") }}" alt="" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset("/images/pay/07.png") }}" alt="" />
                                </div>
                                <div class="dec clearfix">
                                    <div class="pull-left">
                                        <p>开户名称：广东腾正</p>
                                        <p>微信账号：GDtengzheng</p>
                                    </div>
                                    <div class="pull-right">
                                        <img class="pay" src="{{ asset("/images/pay/wx.png") }}" alt="" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="culture-item">
                    <div class="title">
                        <h4>汇款注意事项</h4>
                        <span>REMITTANCE NOTES</span>
                    </div>
                    <div class="body">
                        <ul class="list-item">
                            <li>
                                <span>①</span>汇款后请将付款底单信息截图发给售前客服处理，由售前客服提交财务确认
                            </li>
                            <li>
                                <span>②</span>请务必注明您的会员账号及订单号等信息
                            </li>
                            <li>
                                <span>③</span>为了更快速处理您的服务订单，请务必及时发送付款底单信息
                            </li>
                            <li>
                                <span>④</span>注意事项：银行电汇底单必须有银行加盖的转讫章；邮局收据上应有邮局日戳
                            </li>
                            <!-- <li>
                                <span>⑤</span>腾正科技所有报价均为不含税，如果需要开发票，请在汇款时加6%的税点
                            </li> -->
                            <li>
                                <span>⑤</span>招行、工行、农行、邮局汇款均是立即到帐，建行、中行为2个小时到帐，企业对公帐号3-5天内到帐
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="culture-item">
                    <div class="title">
                        <h4>退款注意事项</h4>
                        <span>REFUND NOTES</span>
                    </div>
                    <div class="body">
                        <ul class="list-item">
                            <li>
                                <span>①</span>我公司承诺属产品质量问题且确认无法解决的均可以退款
                            </li>
                            <li>
                                <span>②</span>退款时请填写退款申请表
                            </li>
                            <li>
                                <span>③</span>请邮寄退款申请表及证件（个人或企业）至公司
                            </li>
                            <li>
                                <span>④</span>我们将在收到申请表之后的7个工作日内给您办理退款手续
                            </li>
                            <li>
                                <span>⑤</span>款项将退还到您注册的会员名下
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
        </div>
        @endaboutusLayout
    </div>
@endsection
