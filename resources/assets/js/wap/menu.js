
if(document.querySelector("#menu")){

    window.$ = window.jQuery = require('jquery');
    window.axios = require('axios');
    window.Vue = require('vue');
    // console.log("menu");
    document.querySelector(".collapses-img").style.height = (window.screen.height - 45 - 336)+"px"; 
    new Vue({
        el: '#menu',
        data: {
            
           
        },
        methods: {
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
            console(){
                console.log("sdf");
                $.get("/home/user/getInfo",(data) => {
                    if(data.code==1 && data.data.status==2) {
                        location.href = "/tz/member92019.html#/";
                    }else{
                        this.textTip("请先登陆！")
                    }
                });
            }
        },
        mounted() {
            
        }
    });
}