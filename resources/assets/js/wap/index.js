var moreBtn = document.querySelector(".sidebar .more-btn");
var moreContent = document.querySelector(".sidebar .more-content");
var topBtn = document.querySelector(".sidebar .top-btn");// 点击更多
moreBtn.onclick = function () {
    if (moreContent.style.display == "block") {
        moreContent.style.display = "none"
    } else {
        moreContent.style.display = "block"
    }
}
//点击置顶
var timer = null;
topBtn.onclick = function () {
    timer = setInterval(function () {
        var oTop = document.documentElement.scrollTop || document.body.scrollTop;
        var ispeed = Math.floor(-oTop / 7);
        document.documentElement.scrollTop = document.body.scrollTop = oTop + ispeed;
        if (oTop == 0) {
            clearInterval(timer);
        }
    }, 30);
}
document.addEventListener("touchmove", function(e){
  moreContent.style.display = "none"
})

// 腾正微信
document.querySelector(".sidebar .more-content .wxCode").onclick = function () {
    document.querySelector(".tz-container .qrCode").style.display = "block";
}
document.querySelector(".tz-container .qrCode .closeCode").onclick = function () {
    document.querySelector(".tz-container .qrCode").style.display = "none";
}





// 云主机
var YunFuwuLiI = document.getElementsByClassName(" Yun-fuwu-li-i");
var YunItemsLi = document.getElementsByClassName(" Yun-items-li");
 var arrow = document.querySelectorAll(".div-arrow .arrow");
for(i=0; i<YunFuwuLiI.length;i++){
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

// 高防服务器
var high_fuwu_li =document.getElementsByClassName("high_security-fuwu-li");
var high_security_items = document.getElementsByClassName("high_security_items");
var arrows = document.querySelectorAll(".fuwu-li .div-arrow .arrow");
var high_fuwu_li_p =document.getElementsByClassName("height-li-t");
for(var i=0; i<high_fuwu_li.length; i++){
    high_fuwu_li[i].index = i;
    high_fuwu_li[i].onclick = function(){
        if(high_security_items[this.index].style.display == "block"){
            high_security_items[this.index].style.display = "none";
            high_fuwu_li_p[this.index].style.color = "#252b3a";
            arrows[this.index].style.transform = "rotate(-45deg)";
            arrows[this.index].style.transition = "transform 0.4s";
        }else{
            high_security_items[this.index].style.display = "block";
            high_fuwu_li_p[this.index].style.color = "#162fac";
            arrows[this.index].style.transform = "rotate(135deg)";
            arrows[this.index].style.transition = "transform 0.4s";
        }
    }
}


// 机房选择
function machineroomtext(){

  var option_text_a = document.querySelectorAll(".option-text-a");
  var select_room_a = document.querySelector("#select-room-a");
  for(var i=0;i<option_text_a.length;i++){
    option_text_a[i].index=i;
    if(select_room_a.value==i){
      console.log(i);
      for(var j=0;j<option_text_a.length;j++){
      option_text_a[j].className="option-text-a";
    }
    option_text_a[i].className="option-text-a option-e-active";
  }
  }
}

// 公司简介

function machineroom(){
  var arrows = document.querySelector(".drop-options .arrow");
  if(document.querySelector(".select-text").style.display=="none"){
    document.querySelector(".select-text").style.display="block";
    arrows.style.transform = "rotate(135deg)";
    arrows.style.transition = "transform 0.4s";
  }else{
    document.querySelector(".select-text").style.display="none";
    arrows.style.transform = "rotate(-45deg)";
    arrows.style.transition = "transform 0.4s";
  }
  var option_text = document.querySelectorAll(".option-text");
  var option_i = document.querySelectorAll(".option-i");
  var p_value = document.querySelector(".drop-options p");
  for(var i=0;i<option_i.length;i++){
    option_i[i].index=i;
    option_i[i].addEventListener("click",function(){
      for(var j=0;j<option_text.length;j++){
        option_text[j].className="option-text";
      }
      option_text[this.index].className="option-text option-e-active";
      p_value.innerHTML=option_i[this.index].innerHTML;

    })
  }

  document.addEventListener("touchmove", function(e){
    if(e.target == document.querySelector(".drop-options p")||e.target ==document.querySelector(".select-text") ){
      document.querySelector(".select-text").style.display="block";
     document.querySelector(".drop-options .arrow").style.transform = "rotate(135deg)";
     document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
    }else{
      moreContent.style.display = "none"
      document.querySelector(".select-text").style.display="none";
     document.querySelector(".drop-options .arrow").style.transform = "rotate(-45deg)";
     document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
    }
  })
}
