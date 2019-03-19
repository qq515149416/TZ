
@extends('layouts.layout')

@section('title', '服务器租用，服务器托管，专业IDC服务商')

@section('content')
    <div id="aboutus" class="row">
        <header class="banner">
            <h2>关于我们</h2>
            <h3>互联网应用支撑商</h3>
            <p>专注为您提供IDC·云计算服务·安全防护一站式产品解决方案，满足您不同时期业务发展需求</p>

        </header>
        <article class="content-list">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#descripts" aria-controls="descripts" role="tab" data-toggle="tab">公司介绍</a></li>
                <li role="presentation"><a href="#rongyu" aria-controls="rongyu" role="tab" data-toggle="tab">荣誉资质</a></li>
                <li role="presentation"><a href="#wenhua" aria-controls="wenhua" role="tab" data-toggle="tab">企业文化</a></li>
                <li role="presentation"><a href="#fazhang" aria-controls="fazhang" role="tab" data-toggle="tab">发展历程</a></li>
                <li role="presentation"><a href="#lianxi" aria-controls="lianxi" role="tab" data-toggle="tab">联系我们</a></li>
                <li role="presentation"><a href="#pay" aria-controls="pay" role="tab" data-toggle="tab">支付中心</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active clearfix" id="descripts">
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
                    腾正科技的产品线涵盖了IDC数据中心，数据安全，云计算，DNS&CDN，系统研发，电商平台基础支撑等领域。在IDC数据中心、大数据分析、网络运营领域拥有领先技术，目前已获得10余项自有软件著作权和专利权。其中，腾正科技与中科院联合打造的TzCloud公有云-云计算操作系统，不仅与中科院达成战略性合作，并且获得了中国信息安全评测中心等级安全认证，给予”安全可控优秀云计算解决方案”的评价。腾正云投入使用后，与曙光、南方报业集团等上百家知名公司建立了深度合作。
                    </p>
                    <p>
                    面对互联网产业蓬勃发展的全球化格局，为了更好的迎接互联网时代的浪潮，腾正科技以提供安全的互联网解决方案为目标，以市场的需求和业务的发展为先导，以互联网安全技术为核心，以专业、快速的售后服务为支撑，本着坚定的信念，开拓创新，为广大的互联网同行与合作伙伴提供优质的产品和完善的服务。
                    </p>
                    <img class="slogan clearfix" src="{{ asset("/images/boiling.png") }}" alt="" />
                </div>
                <div role="tabpanel" class="tab-pane" id="rongyu">
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
                                        <li>
                                            <a href="javascript:;" class="thumbnail">
                                                <img src="{{ asset("/images/cert/01.png") }}" alt="" />
                                            </a>
                                            <span>东莞市电子商务联合会</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="swiper-slide swiper-no-swiping">
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
                                </div>

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
                                                <img class="long" src="{{ asset("/images/cert/long/01.jpg") }}" alt="" />
                                            </a>
                                            <span>腾正防火墙牵引系统版权</span>
                                        </li>
                                        <li>
                                            <a href="javascript:;" class="thumbnail">
                                                <img class="long" src="{{ asset("/images/cert/long/01.jpg") }}" alt="" />
                                            </a>
                                            <span>腾正防火墙牵引系统版权</span>
                                        </li>
                                        <li>
                                            <a href="javascript:;" class="thumbnail">
                                                <img src="{{ asset("/images/cert/long/01.jpg") }}" alt="" />
                                            </a>
                                            <span>腾正防火墙牵引系统版权</span>
                                        </li>
                                    </ul>
                                </div>

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
                                                <img class="long" src="{{ asset("/images/cert/long/01.jpg") }}" alt="" />
                                            </a>
                                            <span>腾正防火墙牵引系统版权</span>
                                        </li>
                                        <li>
                                            <a href="javascript:;" class="thumbnail">
                                                <img class="long" src="{{ asset("/images/cert/long/01.jpg") }}" alt="" />
                                            </a>
                                            <span>腾正防火墙牵引系统版权</span>
                                        </li>
                                        <li>
                                            <a href="javascript:;" class="thumbnail">
                                                <img src="{{ asset("/images/cert/long/01.jpg") }}" alt="" />
                                            </a>
                                            <span>腾正防火墙牵引系统版权</span>
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
                <div role="tabpanel" class="tab-pane" id="wenhua">
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
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="fazhang">
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
                <div role="tabpanel" class="tab-pane" id="lianxi">
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
                                    <tr>
                                        <td>
                                            姓名：尹嘉辉
                                        </td>
                                        <td>
                                            电话：18028237786
                                        </td>
                                        <td>
                                            QQ：2853978334
                                        </td>
                                        <td>
                                            邮箱：2853978334@qq.com
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="pay">...</div>
            </div>
        </article>
    </div>
@endsection
