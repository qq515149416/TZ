@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

<div id="registered">
        <div class="main-body">
            <div class="tz-container">
                <!-- 内容 -->
                <div class="main-content">
                    <div class="register-content">
                        <div class="register-t">
                            账号注册
                        </div>
                        <div class="login-text">
                            <input type="text" v-model="email" id="InputEmail" placeholder="请输入邮箱地址">
                            <input type="password" placeholder="密码" id="password" v-model="password">
                            <input type="password" placeholder="确认密码" id="password_con" v-model="password_confirmation">
                            <input type="" placeholder="昵称" id="qq" v-model="nickname">
                            <input type="" placeholder="联系电话" id="password" v-model="msg_phone">
                            <input type="" placeholder="QQ" id="qq" v-model="msg_qq">
                        </div>
                        <div class="validation">
                            <input type="text" v-model="get_token.verification_code" placeholder="验证码" id="captcha">
                            <div>
                                <img id="verification" v-bind:src="get_token.captcha_src" alt="">
                            </div>
                            <a href="#" v-on:click="switchCaptchaSrc" >换一张</a>
                        </div>
                        <div class="email-validation">
                            <input type="text" placeholder="邮箱验证码" id="token" v-model="token">
                            <input type="submit" v-on:click="getToken" v-bind:class="{wait: get_token.wait_time > 0}" id="get-verification-code" value="获取验证码">
                        </div>
                        <div class="select-salesman" v-on:click="s_salesman">请选择业务员</div>
                        <!-- 选择业务员 -->
                        <div class="select">
                            <div class="salesman">
                                <p>请选择业务员</p>
                                <div class="close close-salesman" v-on:click="close_salesman"><img src="{{ asset("/images/wap/关闭按钮.png") }}" alt=""></div>
                                <form action="" id="salesman-form">
                                    <!-- <div><input type="radio" name="salesman" value="" id=""><label></label></div> -->
                                    
                                    <!-- <div><input type="radio" name="salesman" value="黄育东"><label></label>黄育东</div>
                                     -->
                                </form>
                                <input class="determine" v-on:click="close_salesman" type="submit" value="确认">
                            </div>
                            
                        </div>
                        <!-- 注册与登录-验证码提醒 -->
                        <div class="r-remind">
                            <div class="remind">
                                <p>验证码已发送到你的邮箱，请注意查收</p>
                                <a href="javascript:;" v-on:click="closeremind">确定</a>
                            </div>
                        </div>
                        <div class="botton">
                                <input type="submit" v-on:click="registered" class="registered" id="registereds" value="注册">
                                <a href="/wap/login">
                                    <input type="submit" class="register" value="已有账户？立即登陆">
                                </a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
// var h =document.documentElement.clientHeight-45;
// document.querySelector(".register-content").style.height=h+"px";


</script>
@endsection