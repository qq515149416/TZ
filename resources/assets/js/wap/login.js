if(document.querySelector("#login")){
    window.$ = window.jQuery = require('jquery');
    window.axios = require('axios');
    window.Vue = require('vue');
    document.querySelector(".login-content").style.height=window.screen.height+"px"; 
    new Vue({
        el: '#login',
        data: function() {
            let email = "";
            let password = "";
            let rememberChecked = false;
            return {
                email: email,
                password: password,
                captcha: "",
                captcha_src: "",
                rememberChecked: rememberChecked,
                error: false,
                error_msg: ""
            };
        },
        methods: {
            switchCaptchaSrc() {
                $.get("/verification_code",(data) => {
                    if(data.code==1) {
                        this.captcha_src = data.data.src;
                    }
                });
            },
            textTip(str, callBack) {
                // t = t || 2000;
                var dom = document.createElement("p");
                dom.setAttribute('class', 'text-tip');
                document.body.appendChild(dom);
                var mytip = document.querySelector('.text-tip')
      
                mytip.style.display="block";
                mytip.innerHTML = str;
                var tipHeight = mytip.offsetHeight;
      
                //文字两行或两行以上
                if((tipHeight - 20)/18>1){
                    mytip.style.width = "55%";
                }
                setTimeout(function () {
                mytip.style.display="none";
                // mytip.parentNode.removeChild(mytip);
                if (callBack) {callBack();}
                }, 2000);
            },
            login() {
                if(this.email=="" || this.password==""){
                    this.textTip("账户，密码不能为空");
                }else{
                $.post("/auth/login",{
                    login_name: this.email,
                    password: this.password,
                    captcha: this.captcha
                },(data) => {
                    if(data.code==1) {
                        this.textTip("登陆成功");
                        if(this.rememberChecked) {
                            
                        } else {
                            
                        }
                        location.href = "/wap/logging";
                    } else {
                        this.switchCaptchaSrc();
                        
                        this.error = true;
                        this.error_msg = data.msg;
                        this.textTip(data.msg);
                    }
                });
                if(this.rememberChecked==true){ 
                    this.setCookie('email',this.email,7); //保存帐号到cookie，有效期7天
                    this.setCookie('password',this.password,7); //保存密码到cookie，有效期7天
                  }else if(this.rememberChecked==false){
                        this.delCookie('email');
                        this.delCookie('password');
                  }
            }
            },
            //设置cookie
		    setCookie(name,value,day){
			    var date = new Date();
			    date.setDate(date.getDate() + day);
			    document.cookie = name + '=' + value + ';expires='+ date;
		    },
		
            //获取cookie
		    getCookie(name){
			    var reg = RegExp(name+'=([^;]+)');
			    var arr = document.cookie.match(reg);
			    if(arr){
			      return arr[1];
			    }else{
			      return '';
			    }
		    },
		
            //删除cookie
	        delCookie(name){
	        	this.setCookie(name,null,-1);
	         },
                remember() {
                    this.rememberChecked = !this.rememberChecked;
                    console.log(this.rememberChecked);
                }
        },
        mounted() {
            $.get("/verification_code",(data) => {
                if(data.code==1) {
                    this.captcha_src = data.data.src;
                }
            });
            if(this.getCookie('email')&& this.getCookie('password')){
                this.email = this.getCookie('email');
                this.password = this.getCookie('password');
                this.rememberChecked = true;
            }
            if(this.rememberChecked == false){
                this.delCookie('email');
				this.delCookie('password');
            }
        }
    });
}