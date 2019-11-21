
if(document.querySelector("#registered")){
  window.axios = require('axios');
  window.$ = window.jQuery = require('jquery');
  window.Vue = require('vue');
//   document.querySelector(".close-salesman").onclick = function(){
//       document.querySelector(".select").style.display="none";
//       document.body.style.overflow = "auto";
//     }
//   document.querySelector(".select-salesman").onclick= function(){
//       document.querySelector(".select").style.display="block";
//       document.body.style.overflow = "hidden";
//   }
 
  function waitSendVerificationCode(frequency,callbrak) {
    if(frequency > 0) {
        callbrak && callbrak();
        frequency --;
        setTimeout(waitSendVerificationCode,1000,frequency,callbrak);
    } else {
        callbrak && callbrak();
    }
}
    
 
  new Vue({
    $salesmans:[],
    el: '#registered',
    data: {
        email: "",
        password: "",
        password_confirmation: "",
        token: "",
        salesman:  "0",
        agreeChecked: true,
        nickname:"",
        msg_phone:"",
        msg_qq:"",
        get_token: {
            verification_code: "",
            captcha_src: "",
            wait_time: 0,
            btn_text: "获取验证码"
        },
        errors: {
            email: false,
            password_confirmation: false
        },
        salesmans: [
            
        ]
    },
    methods: {
        s_salesman(){
          document.querySelector(".select").style.display="block";
          document.body.style.overflow = "hidden";
        },
        close_salesman(){
          document.querySelector(".select").style.display="none";
          document.body.style.overflow = "auto";
        },
        closeremind(){
          document.querySelector(".r-remind").style.display="none";
        },
        //提示框
        textTip(str, t, callBack) {
          t = t || 2000;
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
          }, t);
        },
        EmailTextTip(str) {
          var mytip = document.querySelector('.r-remind')
            
          mytip.style.display="block";
          mytip.querySelector(".remind p").innerHTML = str;
        },
        //注册
        registered() {
                $.post("/auth/registerByEmail",{
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    token: this.token,
                    salesman: $('input[name="salesman"]:checked').attr('id'),
                    msg_qq: this.msg_qq,
                    msg_phone: this.msg_phone,
                    nickname: this.nickname

                },(data) => {
                    if(data.code==1) {
                        this.textTip("注册成功");
                        this.email="";
                        this.password="";
                        this.password_confirmation="";
                        this.token = "";
                        this.get_token.verification_code = "";
                        this.msg_qq="";
                        this.msg_phone="";
                        this.nickname="";
                        location.href = "/tz/member92019.html#/";
                    } else {
                        this.textTip(data.msg);
                        this.switchCaptchaSrc();
                    }
                });
        },
        
        //邮箱
        getToken() {
            if(this.get_token.wait_time > 0) {
                return ;
            }
            
            $.post("/auth/sendEmailCode?r="+Math.floor(Math.random() * 10000),{
                email: this.email,
                captcha: this.get_token.verification_code
            },(data) => {
                if(data.code == 1) {
                  this.EmailTextTip("验证码已发送到你的邮箱，请留意查收");
                    this.get_token.wait_time = 60;
                    $("#get-verification-code").val("重新获取（"+this.get_token.wait_time+")");
                    waitSendVerificationCode(this.get_token.wait_time,() => {
                        if(this.get_token.wait_time > 0) {
                            this.get_token.wait_time --;
                            $("#get-verification-code").val("重新获取（"+this.get_token.wait_time+")");
                        } else {
                          $("#get-verification-code").val("获取验证码");
                        }
                    });
                } else {
                    this.textTip(data.msg);
                    this.switchCaptchaSrc();
                }
            });
        },
        switchCaptchaSrc() {
            $.get("/verification_code",(data) => {
                if(data.code==1) {
                    this.get_token.captcha_src = data.data.src;
                }
            });
        }
    },
    mounted() {
        $.get("/verification_code",(data) => {
            if(data.code==1) {
                // this.get_token.captcha_src = data.data.src;
                this.switchCaptchaSrc();
                this.salesmans = [];
                $.get("/auth/getAllSalesman", (res) => {
                    if(res.code==1) {
                        this.salesmans = res.data;
                        console.log(this.salesmans);
                        for(var i=0;i<this.salesmans.length;i++){//循环数组中的所有的元素
                            //获得盒子,向盒子里面循环添加li,li里面附带a标签 
                            $("#salesman-form").append("<div><input type='radio' name='salesman' id='"+this.salesmans[i]['id']+"' value='"+this.salesmans[i]['name']+"'><label></label>"+this.salesmans[i]['name']+"</div>");    
                                $("#linews"+i).attr("class",'linews');      
                            }
                    }
                });
            }
        });
    },
    watch: {
    }
});


}
