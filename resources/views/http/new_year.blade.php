@extends('layouts.layout')

@section('title', $tdk['title'])

@section('keywords', $tdk['keywords'])

@section('description', $tdk['description'])

@section('content')
    <div id="new_year" class="row">
        <div class="product-item">
            <div class="header">
                <span class="font-heavy">
                    腾正云春节促销活动
                </span>
            </div>
            <div class="content">
                <ul class="products clearfix">
                    <li>
                        <ul class="config">
                            <li>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        CPU
                                    </span>
                                    <span class="value font-heavy">
                                        2核
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        内存
                                    </span>
                                    <span class="value font-heavy">
                                        4G
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        硬盘
                                    </span>
                                    <span class="value font-heavy">
                                        40G+20G
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        带宽
                                    </span>
                                    <span class="value font-heavy">
                                        10M
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        防御
                                    </span>
                                    <span class="value font-heavy">
                                        10G
                                    </span>
                                </p>
                            </li>
                            <li>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        备份集
                                    </span>
                                    <span class="value font-heavy">
                                        1份
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        IP
                                    </span>
                                    <span class="value font-heavy">
                                        1个
                                    </span>
                                </p>
                            </li>
                        </ul>
                        <p class="tip font-medium">应用场景：适用于做PC/移动端、移动端电商商城、轻量型游戏客户。</p>
                        <div class="buy">
                            <div class="price">
                                <span class="currency">￥</span>
                                <span class="amount font-heavy">99</span>
                                <span class="unit font-medium">元/月</span>
                            </div>
                            <a class="purchas" onclick="randomqq()" href="javascript:;">
                                限时抢购
                            </a>
                        </div>
                        <div class="product-footer">
                            <span class="title font-heavy">
                                续费时长 | 赠送
                            </span>
                            <p class="font-medium">3个月 | 送1个月（按季付送1个月，即实际用4个月）</p>
                            <p class="font-medium">6个月 | 送3个月（按半年付送3个月，即实际用9个月）</p>
                            <p class="font-medium">12个月 | 送6个月（按年付送6个月，即实际用18个月）</p>
                        </div>
                    </li>
                    <li>
                        <ul class="config">
                            <li>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        CPU
                                    </span>
                                    <span class="value font-heavy">
                                        4核
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        内存
                                    </span>
                                    <span class="value font-heavy">
                                        4G
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        硬盘
                                    </span>
                                    <span class="value font-heavy">
                                        40G+40G
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        带宽
                                    </span>
                                    <span class="value font-heavy">
                                        10M
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        防御
                                    </span>
                                    <span class="value font-heavy">
                                        40G
                                    </span>
                                </p>
                            </li>
                            <li>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        备份集
                                    </span>
                                    <span class="value font-heavy">
                                        1份
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        IP
                                    </span>
                                    <span class="value font-heavy">
                                        1个
                                    </span>
                                </p>
                            </li>
                        </ul>
                        <p class="tip font-medium">应用场景：适用于做金融、娱乐（游戏）、传奇游戏客户。</p>
                        <div class="buy">
                            <div class="price">
                                <span class="currency">￥</span>
                                <span class="amount font-heavy">129</span>
                                <span class="unit font-medium">元/月</span>
                            </div>
                            <a class="purchas" onclick="randomqq()" href="javascript:;">
                                限时抢购
                            </a>
                        </div>
                        <div class="product-footer">
                            <span class="title font-heavy">
                                续费时长 | 赠送
                            </span>
                            <p class="font-medium">3个月 | 送1个月（按季付送1个月，即实际用4个月）</p>
                            <p class="font-medium">6个月 | 送3个月（按半年付送3个月，即实际用9个月）</p>
                            <p class="font-medium">12个月 | 送6个月（按年付送6个月，即实际用18个月）</p>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="product-item">
            <div class="header">
                <span class="font-heavy">
                    腾正物理机春节促销活动
                </span>
            </div>
            <div class="content">
                <ul class="products clearfix">
                    <li>
                        <ul class="config">
                            <li>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        CPU
                                    </span>
                                    <span class="value font-heavy">
                                        8核
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        内存
                                    </span>
                                    <span class="value font-heavy">
                                        16G
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        硬盘
                                    </span>
                                    <span class="value font-heavy">
                                        240G
                                    </span>
                                </p>
                            </li>
                            <li>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        带宽
                                    </span>
                                    <span class="value font-heavy">
                                        100M
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        防御
                                    </span>
                                    <span class="value font-heavy">
                                        200G
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        线路
                                    </span>
                                    <span class="value font-heavy">
                                        西安电信
                                    </span>
                                </p>
                            </li>
                        </ul>
                        <div class="description">
                            <p class="font-heavy text-center">
                                续费时长 | 赠送
                            </p>
                            <p class="font-heavy text-center" style="color: #f44336;">
                                买9月送3月 | 送产权
                            </p>
                        </div>
                        <div class="buy">
                            <div class="price">
                                <span class="currency">￥</span>
                                <span class="amount font-heavy">888</span>
                                <span class="unit font-medium">元/月</span>
                            </div>
                            <a class="purchas" onclick="randomqq()" href="javascript:;">
                                限时抢购
                            </a>
                        </div>
                    </li>
                    <li>
                        <ul class="config">
                            <li>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        CPU
                                    </span>
                                    <span class="value font-heavy">
                                        8核
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        内存
                                    </span>
                                    <span class="value font-heavy">
                                        16G
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        硬盘
                                    </span>
                                    <span class="value font-heavy">
                                        240G
                                    </span>
                                </p>
                            </li>
                            <li>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        带宽
                                    </span>
                                    <span class="value font-heavy">
                                        100M
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        防御
                                    </span>
                                    <span class="value font-heavy">
                                        40G
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        线路
                                    </span>
                                    <span class="value font-heavy">
                                        衡阳电信
                                    </span>
                                </p>
                            </li>
                        </ul>
                        <div class="description">
                            <p class="font-heavy text-center">
                                续费时长 | 赠送
                            </p>
                            <p class="font-heavy text-center" style="color: #f44336;">
                                买9月送3月 | 送产权
                            </p>
                        </div>
                        <div class="buy">
                            <div class="price">
                                <span class="currency">￥</span>
                                <span class="amount font-heavy">999</span>
                                <span class="unit font-medium">元/月</span>
                            </div>
                            <a class="purchas" onclick="randomqq()" href="javascript:;">
                                限时抢购
                            </a>
                        </div>
                    </li>
                    <li>
                        <ul class="config">
                            <li>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        CPU
                                    </span>
                                    <span class="value font-heavy">
                                        8核
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        内存
                                    </span>
                                    <span class="value font-heavy">
                                        16G
                                    </span>
                                </p>
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        硬盘
                                    </span>
                                    <span class="value font-heavy">
                                        240G
                                    </span>
                                </p>
                            </li>
                            <li style="justify-content: flex-start;">
                                <p class="config-item" style="margin-right: 50px;">
                                    <span class="attr font-medium">
                                        带宽
                                    </span>
                                    <span class="value font-heavy">
                                        100M
                                    </span>
                                </p>
                                <!-- <p class="config-item">
                                    <span class="attr font-medium">
                                        防御
                                    </span>
                                    <span class="value font-heavy">
                                        200G
                                    </span>
                                </p> -->
                                <p class="config-item">
                                    <span class="attr font-medium">
                                        线路
                                    </span>
                                    <span class="value font-heavy">
                                        惠州电信
                                    </span>
                                </p>
                            </li>
                        </ul>
                        <div class="description">
                            <p class="font-heavy text-center">
                                续费时长 | 赠送
                            </p>
                            <p class="font-heavy text-center" style="color: #f44336;">
                                买9月送3月 | 送产权
                            </p>
                        </div>
                        <div class="buy">
                            <div class="price">
                                <span class="currency">￥</span>
                                <span class="amount font-heavy">999</span>
                                <span class="unit font-medium">元/月</span>
                            </div>
                            <a class="purchas" onclick="randomqq()" href="javascript:;">
                                限时抢购
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="terms">
                <ol>
                    <li class="font-medium">
                        <span>1. 活动时间：</span>
                        <span>2020.01.01-2020.01.31。</span>
                    </li>
                    <li class="font-medium">
                        <span>2. 活动对象：</span>
                        <span>所有新老客户，每个ID限购1台。</span>
                    </li>
                    <li class="font-medium">
                        <span>3. 免赔条款：</span>
                        <div>
                            <span>(1)不可抗力的因素引起的；</span>
                            <span>(2)合作生效后用户后进行系统维护所引起的，包括割接、维修、升级等；</span>
                            <span>(3)用户未遵循相关国家法律法规行为所引发的结果；</span>
                            <span>(4)其他不能预见并且对其发生和后果不能防止并避免的不可抗力原因。</span>
                        </div>
                    </li>
                    <li class="font-medium">
                        <span>4. 退款说明：</span>
                        <span>如因买方个人/公司自身原因导致的退货退款的客户，一律按月为单位退货退款，
                        且默认买家自动放弃本次优惠买赠活动，即最终退款=【买9送3（即12个月）-个人
                        /公司已使用月数（不足1月的按1月计算）-送3（即3个月）】*促销产品单价，以此类推。</span>
                    </li>
                    <li class="font-medium">
                        5. 所有参加活动的用户，均视为认可本活动规则且同意遵守《腾正用户协议》。
                    </li>
                    <li class="font-medium">
                        6. 本活动最终解释权归腾正网络所有。
                    </li>
                </ol>
            </div>
        </div>

    </div>
@endsection
