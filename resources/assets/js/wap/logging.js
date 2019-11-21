import Vue from 'vue';
window.$ = window.jQuery = require('jquery');
    window.axios = require('axios');
    window.Vue = require('vue');
if(document.querySelector("#logging")){
    
    new Vue({
        el: '#logging',
        data: {
            email:"",
        },
        methods: {
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
        },
        mounted() {
            $.get("/home/user/getInfo",(data) => {
                if(data.code==1 && data.data.status==2) {
                    this.email = data.data.email;
                    $("#useremails").html(this.email);
                }
            });
        }
    });
}



