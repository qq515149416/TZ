@extends('layouts.layout')

@section('title', '防C盾-抗CC防火墙-防CC攻击-隐藏源站IP-CC防御专家[腾正科技]')

@section('keywords', '防C盾,抗CC防火墙,防CC攻击,隐藏源站IP,CC防御，防cc攻击软件,CC高防')

@section('description', '防C盾是腾正科技自研针对CC攻击接入C盾进行高防御的攻击防护体系,利用CNAME特性隐藏源站IP，防止源站真实IP暴露，一键开启DDos和CC防御，零误封，可跨地域跨机房使用。')

@section('content')
<div class="tz-protection" id="c-shield">
    <!--banner-->
    <div class="banner">
        <div class="cont">
            <div class="title">
                <h2 class="text">防 C 盾</h2>
                <h5 class="sub-text">
                    防C盾是腾正科技自研针对CC攻击接入C盾进行高防御的攻击防护体系，一键开启DDos和C防御，<br/>
                    零误封，可跨地域跨机房使用。具抗CC/DDOS攻击，防入侵监测系统，硬件监控系统，网络故障<br/>
                    分析，数据灾备系统，防篡改，防盗链，防访问限制，源站保护功能。
                </h5>
            </div>
            <a class="apply-btn" href="https://www.15cdn.com/">立即申请</a>
        </div>
        <div class="tab">
            @foreach ($tabs as $item)
                <a class="tab-item {{$item['name'] === '防C盾' ? 'active' : ''}}" href="{{ $item['href'] }}">{{ $item['name'] }}</a>
            @endforeach
            <!-- <a class="tab-item" href="/protection/high-defense-cdn">高防CDN</a>
            <a class="tab-item" href="/dist/highDefense.html"> DDOS高防IP</a>
            <a class="tab-item active" href="/protection/c-shield">防C盾</a> -->
        </div>
    </div>
    <!--组合套餐-->
    <div class="package">
        <div class="accelerate">
            <h2 class="title black">加速套餐<span style="font-weight: normal;"> | 高强度高防CC攻击，在岗1分钟，安全60秒</span></h2>
            <div class="table-container">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" style="width: 15%;">套餐</th>
                        <th scope="col">域名数量月度总流量</th>
                        <th scope="col">原价域名数量</th>
                        <th scope="col">原价价格</th>
                        <th scope="col">产品说明</th>
                        <th scope="col">购买</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--******-->
                    <tr>
                        <th>
                            加速<br/>
                            特惠体验
                        </th>
                        <td>1TB</td>
                        <td>1个</td>
                        <td>
                            <span style="color: #ea0000;">100元/月</span>
                        </td>
                        <td>
                            提供网页和小文件加速服务帮助客户提升<br/>
                            网站的用户访问速度和服务的高可用性
                        </td>
                        <td>
                            <a href="javascript: void(0);" class="purchase-btn" onclick="randomqq();">立即购买</a>
                        </td>
                    </tr>
                    <!--******-->
                    <tr>
                        <th>
                            加速<br/>
                            商务版
                        </th>
                        <td>5TB</td>
                        <td>2个</td>
                        <td>
                            <span style="color: #ea0000;">500元/月</span>
                        </td>
                        <td>
                            网页静态资源优化加速，全站HTTPS保证网站<br/>
                            访问安全，适用于文学类站点、小型图片站等
                        </td>
                        <td>
                            <a href="javascript: void(0);" class="purchase-btn" onclick="randomqq();">立即购买</a>
                        </td>
                    </tr>
                    <!--******-->
                    <tr>
                        <th>
                            加速<br/>
                            企业版
                        </th>
                        <td>10TB</td>
                        <td>3个</td>
                        <td>
                            <span style="color: #ea0000;">800元/月</span>
                        </td>
                        <td>
                            图片、文件下载加速分发，多节点融合提高图片<br/>
                            显示及用户下载速度，适用各类图库、下载站等
                        </td>
                        <td>
                            <a href="javascript: void(0);" class="purchase-btn" onclick="randomqq();">立即购买</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-bordered" style="margin-top: 40px;">
                    <thead>
                    <tr>
                        <th scope="col" style="width: 15%;">套餐</th>
                        <th scope="col">域名数量防御类型</th>
                        <th scope="col">原价域名数量</th>
                        <th scope="col">原价价格</th>
                        <th scope="col">产品说明</th>
                        <th scope="col">购买</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--******-->
                    <tr>
                        <th>
                            防御<br/>
                            安全防御200G
                        </th>
                        <td>DDOS(200G)/CC</td>
                        <td>1个</td>
                        <td>
                            <span style="color: #ea0000;">2000元/月</span>
                        </td>
                        <td>
                            分布式防御流量200G，无限防御CC攻击。
                        </td>
                        <td>
                            <a href="javascript: void(0);" class="purchase-btn" onclick="randomqq();">立即购买</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="idc-hot-sale">
            <h2 class="title black">IDC 热销套餐<span style="font-weight: normal;"> | 企业服务器 + CDN 加速更加实惠</span></h2>
            <div class="header">
                <div class="item">
                    <div class="title">IDC + CDN 优惠套 1</div>
                    <img class="d-block" src="{{ asset("/images/cShield/flow-line.png") }}" />
                </div>
                <div class="item">
                    <div class="title">IDC + CDN 优惠套 2</div>
                    <img class="d-block" src="{{ asset("/images/cShield/flow-line.png") }}" />
                </div>
            </div>
            <div class="card-container">
                <div class="card">
                    <div class="card-title">衡阳电信 80G 防御</div>
                    <div class="card-body">
                        <p>CPU：XeonE5530*2/L5630*2</p>
                        <p>内存：8G</p>
                        <p>硬盘：1T SATA</p>
                        <p>带宽：G口（20M独享）</p>
                        <p>价格：1200元/月</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">CDN 加速企业版</div>
                    <div class="card-body">
                        <p>总流量：5TB&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加速域名：2个</p>
                        <p>价格：500元/月</p>
                        <p>产品说明：网页静态资源优化加速，全站HTTPS保证网站访问安全，适用于文学类站点、小型图片站等</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">惠州 100G 防御</div>
                    <div class="card-body">
                        <p>CPU：XeonX5672</p>
                        <p>内存：8G</p>
                        <p>硬盘：240GSSD（固态）</p>
                        <p>带宽：G口（20M独享）</p>
                        <p>价格：1600元/月</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">CDN 加速企业版</div>
                    <div class="card-body">
                        <p>总流量：5TB&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加速域名：2个</p>
                        <p>价格：500元/月</p>
                        <p>产品说明：网页静态资源优化加速，全站HTTPS保证网站访问安全，适用于文学类站点、小型图片站等</p>
                    </div>
                </div>
            </div>
            <div class="btn-container">
                <a href="javascript: void(0);" class="purchase-btn" onclick="randomqq();">立即购买</a>
                <a href="javascript: void(0);" class="purchase-btn" onclick="randomqq();">立即购买</a>
            </div>
        </div>
        <div class="tzclound-hot-sale">
            <h2 class="title black">腾正云热销套餐<span style="font-weight: normal;"> | 企业服务器 + CDN 加速更加实惠</span></h2>
            <div class="header">
                <div class="item">
                    <div class="title">云 + CDN 优惠套 1</div>
                    <img class="d-block" src="{{ asset("/images/cShield/flow-line.png") }}" />
                </div>
                <div class="item">
                    <div class="title">云 + CDN 优惠套 2</div>
                    <img class="d-block" src="{{ asset("/images/cShield/flow-line.png") }}" />
                </div>
            </div>
            <div class="card-container">
                <div class="card">
                    <div class="card-title">挂机宝云主机</div>
                    <div class="card-body">
                        <p>2核 2GB</p>
                        <p>系统盘(普通存储) 20GB</p>
                        <p>数据盘(普通存储) 20GB</p>
                        <p>公网IP 1个&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电信 10M 带宽</p>
                        <p>不限网络模式</p>
                        <p>特惠价：119元/月</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">CDN 加速体验版</div>
                    <div class="card-body">
                        <p>总流量：50GB</p>
                        <p>加速域名：1个</p>
                        <p>价格：9元/月</p>
                        <p>
                            产品说明：提供网页和小文件加速<br/>
                            服务帮助客户提升网站的用户访问<br/>
                            速度和服务的高可用性
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">商企云云主机</div>
                    <div class="card-body">
                        <p>8核 8GB</p>
                        <p>系统盘(普通存储) 30GB</p>
                        <p>数据盘(普通存储) 200GB</p>
                        <p>公网IP 1个&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电信 50M 带宽</p>
                        <p>不限网络模式</p>
                        <p>特惠价：699元/月</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">CDN 加速体验版</div>
                    <div class="card-body">
                        <p>总流量：50GB&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加速域名：1个</p>
                        <p>价格：100元/月</p>
                        <p>
                            产品说明：提供网页和小文件加速<br/>
                            服务帮助客户提升网站的用户访问<br/>
                            速度和服务的高可用性
                        </p>
                    </div>
                </div>
            </div>
            <div class="btn-container">
                <a href="javascript: void(0);" class="purchase-btn" onclick="randomqq();">立即购买</a>
                <a href="javascript: void(0);" class="purchase-btn" onclick="randomqq();">立即购买</a>
            </div>
        </div>
    </div>
    <!--功能-->
    <div class="function">
        <h2 class="title white">防 C 盾功能</h2>
        <div class="item-container">
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-1.png") }}"">
                <div class="text">
                    <h5 class="title">分流防护</h5>
                    <p class="desc">采用智能分发平台，按照近源防护原则，对于特殊事件或时间段的突发大流量进行分流，减少单点防护的压力，更好的保证了防护效果。</p>
                </div>
                <div class="hover-div"></div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-2.png") }}"">
                <div class="text">
                    <h5 class="title">IP负载均衡</h5>
                    <p class="desc">单节点数十台服务器机组负载均衡，保证了硬件运行的顺畅，减少CPU运行压力，全方位解决服务器性能不足的问题，提升防护效果。</p>
                </div>
                <div class="hover-div"></div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-3.png") }}"">
                <div class="text">
                    <h5 class="title">网络攻击防御</h5>
                    <p class="desc">利用CNAME特性隐藏源站IP，防止源站真实IP暴露，节点式分布承载DDOS/CC等网络攻击，确保在加速前提下提升网站安全性。</p>
                </div>
                <div class="hover-div"></div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-4.png") }}"">
                <div class="text">
                    <h5 class="title">跨地域跨机房使用</h5>
                    <p class="desc">全球领先云集群技术，通过T级集群防火墙+独立流量清洗+CC防御组合过滤精确识别，防御各种类型攻击，零误封，可跨地域跨机房使用。</p>
                </div>
                <div class="hover-div"></div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-5.png") }}"">
                <div class="text">
                    <h5 class="title">操作简单一键完成</h5>
                    <p class="desc">简单易懂的操作界面，可根据实际的情况自主更换防护信息；平台化接入，自助配置加速，只需修改域名解析即可实现接入。</p>
                </div>
                <div class="hover-div"></div>
            </div>
            <div class="item">
                <img class="icon" src="{{ asset("/images/highDefenseCdn/icon-6.png") }}"">
                <div class="text">
                    <h5 class="title">全景数据统计分析</h5>
                    <p class="desc">提供多纬度统计报表，如业务流量报表、新建和并发连接报表、DDoS和CC防护清洗报表，用户对业务和攻击情况实时掌握。</p>
                </div>
                <div class="hover-div"></div>
            </div>
        </div>
    </div>
    <!--特点-->
    <div class="feature">
        <h2 class="title black">防 C 盾特点</h2>
        <div class="card-container">
            <div class="card">
                <div class="card-body">
                    <img class="icon" src="{{ asset("/images/cShield/icon-1.png") }}"">
                    <h5 class="title">独立流量清洗系统</h5>
                    <p class="desc">针对高度依赖网络和易受DDOS攻击等带来营业损失的客户，有效给予用户经济上和网络安全方面的保障。</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <img class="icon" src="{{ asset("/images/cShield/icon-2.png") }}"">
                    <h5 class="title">独立CC防火墙</h5>
                    <p class="desc">独立CC防火墙设计，配合T级的集群防火墙，防护能力显著，有效防DDOS，SYN等多种类型攻击，无视CC，UDP等攻击。</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <img class="icon" src="{{ asset("/images/cShield/icon-3.png") }}"">
                    <h5 class="title">国际品牌服务器</h5>
                    <p class="desc">采用戴尔、惠普、浪潮等国际高端品牌服务器，性能卓越运行稳定，实现用户数据的快速、高效处理。</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <img class="icon" src="{{ asset("/images/cShield/icon-4.png") }}"">
                    <h5 class="title">万兆大带宽接入</h5>
                    <p class="desc">多个CC防护集群组合，采用万兆网络接入，建立高效CC攻击防护基础，一站式解决因CC攻击使服务器带宽占用而无法正常工作。</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <img class="icon" src="{{ asset("/images/cShield/icon-5.png") }}"">
                    <h5 class="title">安全牵引系统</h5>
                    <p class="desc">自主研发的BlackHole System，最大程序优化了自由的防护体系，对各种攻击的监控和检测更加灵敏，防护更快捷更高效。</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <img class="icon" src="{{ asset("/images/cShield/icon-6.png") }}"">
                    <h5 class="title">高性能CDN辅助</h5>
                    <p class="desc">在网络部署上具完备的安全机制，数百个CDN加速点负载，可以有效地预防各类黑客入侵，确保源站安全的同时更保证了网络质量。</p>
                </div>
            </div>
        </div>
    </div>
    <!--咨询-->
    <div class="consult">
        <h2 class="title">
            腾正高防专家，在岗 1 分钟，安全 60 秒
        </h2>
        <a class="consult-btn" href="javascript: void(0);" onclick="randomqq();">立即咨询</a>
    </div>
</div>
@endsection
