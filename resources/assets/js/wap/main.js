var fuwulis = document.querySelectorAll("#home .fuwu-li-i");
var itemslis = document.querySelectorAll("#home .items-li");
var fuwuTitleImg = document.querySelectorAll("#home .fuwu-li .tz-main img");
var arrows = document.querySelectorAll("#home .fuwu-li .div-arrow .arrow");
var moreBtn = document.querySelector(".sidebar .more-btn");
var moreContent = document.querySelector(".sidebar .more-content");
var topBtn = document.querySelector(".sidebar .top-btn");
var count = fuwulis.length;
// 按钮切换
for(var i=0; i<count; i++){
    fuwulis[i].index = i;
    fuwulis[i].onclick = function(){
        if(itemslis[this.index].style.display == "block"){
            itemslis[this.index].style.display = "none";
            arrows[this.index].style.transform = "rotate(-45deg)";
            arrows[this.index].style.transition = "transform 0.4s";
            if(this.index==0){
                fuwuTitleImg[this.index].setAttribute("src","/images/wap/基础服务（关）.png");
            }
            if(this.index==1){
                fuwuTitleImg[this.index].setAttribute("src","/images/wap/高防基础与应用（关）.png");
            }
            if(this.index==2){
                fuwuTitleImg[this.index].setAttribute("src","/images/wap/专业防御，企业首选（关）.png");
            }
            if(this.index==3){
                fuwuTitleImg[this.index].setAttribute("src","/images/wap/解决方案（关）.png");
            }
            
        }else{
            itemslis[this.index].style.display = "block";
            arrows[this.index].style.transform = "rotate(135deg)";
            arrows[this.index].style.transition = "transform 0.4s";
            if(this.index==0){
                fuwuTitleImg[this.index].setAttribute("src","/images/wap/基础服务（开）.png");
            }
            if(this.index==1){
                fuwuTitleImg[this.index].setAttribute("src","/images/wap/高防基础与应用（开）.png");
            }
            if(this.index==2){
                fuwuTitleImg[this.index].setAttribute("src","/images/wap/专业防御，企业首选（开）.png");
            }
            if(this.index==3){
                fuwuTitleImg[this.index].setAttribute("src","/images/wap/解决方案（开）.png");
            }
        }
    }
}
    // 菜单
    var YunFuwuLiI = document.querySelectorAll("#menu .Yun-fuwu-li-i");
    var YunItemsLi = document.querySelectorAll("#menu .Yun-items-li");
    var arrow = document.querySelectorAll("#menu .div-arrow .arrow");
    for(var i=0; i<YunFuwuLiI.length;i++){
      YunFuwuLiI[i].index = i;
      YunFuwuLiI[i].onclick = function(){
        if(YunItemsLi[this.index].style.display == "block"){
          YunItemsLi[this.index].style.display = "none";
          arrow[this.index].style.transform = "rotate(-45deg)";
          arrow[this.index].style.transition = "transform 0.4s"  
        }
        
        else{
          YunItemsLi[this.index].style.display = "block";
          arrow[this.index].style.transform = "rotate(135deg)";
          arrow[this.index].style.transition = "transform 0.4s";
        }
      }
    }

// 点击更多
moreBtn.onclick = function(){
    if(moreContent.style.display=="block"){
        moreContent.style.display="none"
    }else{
        moreContent.style.display="block"
    }
}
if(document.querySelector("#C_shield")){
    if(document.body.clientWidth<330){
            var pi =document.querySelectorAll(".package-item-i");
        for(var i=0;i<pi.length;i++){
            pi[i].style.height="240px";
        }
      }
}
if(document.querySelector("#server_hosting") || document.querySelector("#high_security_server") || document.querySelector("#high_proof_host") || document.querySelector("#flow_stack_packet") || document.querySelector("#cloud_hosting") || document.querySelector("#server_hire")) {
    if (document.body.clientWidth < 330) {
        var p_li = document.querySelector(".problems-li").querySelectorAll("li");
        for (var i = 0; i < p_li.length; i++) {
            p_li[i].querySelector("p").style.maxWidth = "190px";
        }
    }
}
if(document.querySelector("#search_results")){
    
}

$.get("/home/user/getInfo",(data) => {
    if(data.code==1 && data.data.status==2) {
        $(".main-header .user img").attr("src","/images/wap/登录与注册点击.png")
        $(".main-header .user a").attr("href","/wap/logging")
    }else{
        $(".main-header .user a").attr("href","/wap/login_register_menu")
        $(".main-header .user img").attr("src","/images/wap/登录与注册.png")
    }
});

  
import "./jquery.min.js";
import "./index.js";
import "./slideshow.js";
import "./computer_introduce.js";
import "./server_hire.js";
import "./slideshow_a.js";
import "./server_hosting.js";
import "./cdn_speed_up.js";
import "./company_introduction.js";
import "./goPage.js";
import "./help_center_home.js";
import "./page.js";
import "./registered.js";
import "./login.js";
import "./logging.js";
import "./menu.js";