@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')

<div id="login">
    <div class="main-body">
        <div class="tz-container">
                <!-- 内容 -->
                <div class="main-content">
                    <div class="login-content">
                        <div class="login-t">
                            账户登陆
                        </div>
                        <div class="login-text">
                            <input type="text" placeholder="请输入登陆邮箱" id="email" v-model="email">
                        </div>
                        <div class="login-text">
                            <input type="password" placeholder="密码" id="password" v-model="password">
                        </div>
                        <div class="login-more">
                            <div><input type="checkbox" name="remember" value="" :checked="rememberChecked" @click="remember"><label></label>
                                <p> 记住密码</p>
                            </div>

                            <a href="javascript:;">忘记密码？</a>
                        </div>
                        <div class="validation">
                            <input type="text" v-model="captcha"  placeholder="验证码">
                            <div>
                                <img :src="captcha_src" alt="">
                            </div>
                            <input type="submit" @click="switchCaptchaSrc" value="换一张">
                        </div>
                        <div class="botton">
                            <input type="submit" class="login" @click="login" value="登录">
                            <a href="/wap/registered">
                                <input type="submit" class="register" value="立即注册">
                            </a>
                        </div>
                    </div>

                </div>
        </div>
    </div>
</div>

@endsection