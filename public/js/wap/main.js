/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 51);
/******/ })
/************************************************************************/
/******/ ({

/***/ 51:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(52);


/***/ }),

/***/ 52:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(53);

__webpack_require__(54);

__webpack_require__(55);

__webpack_require__(56);

__webpack_require__(57);

__webpack_require__(58);

__webpack_require__(59);

__webpack_require__(60);

__webpack_require__(61);

__webpack_require__(62);

__webpack_require__(63);

var fuwulis = document.querySelectorAll("#home .fuwu-li-i");
var itemslis = document.querySelectorAll("#home .items-li");
var fuwuTitleImg = document.querySelectorAll("#home .fuwu-li .tz-main img");
var arrows = document.querySelectorAll("#home .fuwu-li .div-arrow .arrow");
var moreBtn = document.querySelector(".sidebar .more-btn");
var moreContent = document.querySelector(".sidebar .more-content");
var topBtn = document.querySelector(".sidebar .top-btn");
var count = fuwulis.length;
// 按钮切换
for (var i = 0; i < count; i++) {
    fuwulis[i].index = i;
    fuwulis[i].onclick = function () {
        if (itemslis[this.index].style.display == "block") {
            itemslis[this.index].style.display = "none";
            arrows[this.index].style.transform = "rotate(-45deg)";
            arrows[this.index].style.transition = "transform 0.4s";
            if (this.index == 0) {
                fuwuTitleImg[this.index].setAttribute("src", "/images/wap/基础服务（关）.png");
            }
            if (this.index == 1) {
                fuwuTitleImg[this.index].setAttribute("src", "/images/wap/高防基础与应用（关）.png");
            }
            if (this.index == 2) {
                fuwuTitleImg[this.index].setAttribute("src", "/images/wap/专业防御，企业首选（关）.png");
            }
            if (this.index == 3) {
                fuwuTitleImg[this.index].setAttribute("src", "/images/wap/解决方案（关）.png");
            }
        } else {
            itemslis[this.index].style.display = "block";
            arrows[this.index].style.transform = "rotate(135deg)";
            arrows[this.index].style.transition = "transform 0.4s";
            if (this.index == 0) {
                fuwuTitleImg[this.index].setAttribute("src", "/images/wap/基础服务（开）.png");
            }
            if (this.index == 1) {
                fuwuTitleImg[this.index].setAttribute("src", "/images/wap/高防基础与应用（开）.png");
            }
            if (this.index == 2) {
                fuwuTitleImg[this.index].setAttribute("src", "/images/wap/专业防御，企业首选（开）.png");
            }
            if (this.index == 3) {
                fuwuTitleImg[this.index].setAttribute("src", "/images/wap/解决方案（开）.png");
            }
        }
    };
}

// 点击更多
moreBtn.onclick = function () {
    if (moreContent.style.display == "block") {
        moreContent.style.display = "none";
    } else {
        moreContent.style.display = "block";
    }
};
if (document.querySelector("#C_shield")) {
    if (document.body.clientWidth < 330) {
        var pi = document.querySelectorAll(".package-item-i");
        for (var i = 0; i < pi.length; i++) {
            pi[i].style.height = "240px";
        }
    }
}
if (document.querySelector("#server_hosting") || document.querySelector("#high_security_server") || document.querySelector("#high_proof_host") || document.querySelector("#flow_stack_packet") || document.querySelector("#cloud_hosting") || document.querySelector("#server_hire")) {
    if (document.body.clientWidth < 330) {
        var p_li = document.querySelector(".problems-li").querySelectorAll("li");
        for (var i = 0; i < p_li.length; i++) {
            p_li[i].querySelector("p").style.maxWidth = "190px";
        }
    }
}
if (document.querySelector("#search_results")) {
    goPage(1, 8);
}

/***/ }),

/***/ 53:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var moreBtn = document.querySelector(".sidebar .more-btn");
var moreContent = document.querySelector(".sidebar .more-content");
var topBtn = document.querySelector(".sidebar .top-btn"); // 点击更多
moreBtn.onclick = function () {
  if (moreContent.style.display == "block") {
    moreContent.style.display = "none";
  } else {
    moreContent.style.display = "block";
  }
};
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
};
document.addEventListener("touchmove", function (e) {
  moreContent.style.display = "none";
});

// 腾正微信
document.querySelector(".sidebar .more-content .wxCode").onclick = function () {
  document.querySelector(".tz-container .qrCode").style.display = "block";
};
document.querySelector(".tz-container .qrCode .closeCode").onclick = function () {
  document.querySelector(".tz-container .qrCode").style.display = "none";
};

// 菜单
var YunFuwuLiI = document.querySelectorAll("#menu .Yun-fuwu-li-i");
var YunItemsLi = document.querySelectorAll("#menu .Yun-items-li");
var arrow = document.querySelectorAll("#menu .div-arrow .arrow");
for (i = 0; i < YunFuwuLiI.length; i++) {
  YunFuwuLiI[i].index = i;
  YunFuwuLiI[i].onclick = function () {
    if (YunItemsLi[this.index].style.display == "block") {
      YunItemsLi[this.index].style.display = "none";
      arrow[this.index].style.transform = "rotate(-45deg)";
      arrow[this.index].style.transition = "transform 0.4s";
    } else {
      YunItemsLi[this.index].style.display = "block";
      arrow[this.index].style.transform = "rotate(135deg)";
      arrow[this.index].style.transition = "transform 0.4s";
    }
  };
}

// 云主机
// var YunFuwuLiI = document.getElementsByClassName(" Yun-fuwu-li-i");
// var YunItemsLi = document.getElementsByClassName(" Yun-items-li");
//  var arrow = document.querySelectorAll(".div-arrow .arrow");
// for(var i=0; i<YunFuwuLiI.length;i++){
//   YunFuwuLiI[i].index = i;
//   YunFuwuLiI[i].onclick = function(){
//     if(YunItemsLi[this.index].style.display == "block"){
//       YunItemsLi[this.index].style.display = "none";
//       arrow[this.index].style.transform = "rotate(-45deg)";
//       arrow[this.index].style.transition = "transform 0.4s"
//     }
//     else{
//       YunItemsLi[this.index].style.display = "block";
//       arrow[this.index].style.transform = "rotate(135deg)";
//       arrow[this.index].style.transition = "transform 0.4s";
//     }
//   }
// }

// 云主机
var YunFuwuLiIc = document.querySelectorAll("#cloud_hosting .Yun-fuwu-li-i");
var YunItemsLic = document.querySelectorAll("#cloud_hosting .Yun-items-li");
var arrowc = document.querySelectorAll("#cloud_hosting .div-arrow .arrow");
for (i = 0; i < YunFuwuLiIc.length; i++) {
  YunFuwuLiIc[i].index = i;
  YunFuwuLiIc[i].onclick = function () {
    if (YunItemsLic[this.index].style.display == "block") {
      YunItemsLic[this.index].style.display = "none";
      if (this.index <= 4) {
        YunFuwuLiIc[this.index].querySelector("p").style.color = "#252b3a";
      }
      arrowc[this.index].style.transform = "rotate(-45deg)";
      arrowc[this.index].style.transition = "transform 0.4s";
      if (this.index == 9) {
        document.querySelectorAll(".fuwu-li-i")[9].style.borderBottom = "none";
      }
    } else {
      YunItemsLic[this.index].style.display = "block";
      if (this.index <= 4) {
        YunFuwuLiIc[this.index].querySelector("p").style.color = "#162fac";
      }
      arrowc[this.index].style.transform = "rotate(135deg)";
      arrowc[this.index].style.transition = "transform 0.4s";
      if (this.index == 9) {
        document.querySelectorAll(".fuwu-li-i")[9].style.borderBottom = "1px solid #585e7e";
      }
    }
  };
}

// 高防服务器
var high_fuwu_li = document.getElementsByClassName("high_security-fuwu-li");
var high_security_items = document.getElementsByClassName("high_security_items");
var arrows = document.querySelectorAll(".fuwu-li .div-arrow .arrow");
var high_fuwu_li_p = document.getElementsByClassName("height-li-t");
for (var i = 0; i < high_fuwu_li.length; i++) {
  high_fuwu_li[i].index = i;
  high_fuwu_li[i].onclick = function () {
    if (high_security_items[this.index].style.display == "block") {
      high_security_items[this.index].style.display = "none";
      high_fuwu_li_p[this.index].style.color = "#252b3a";
      arrows[this.index].style.transform = "rotate(-45deg)";
      arrows[this.index].style.transition = "transform 0.4s";
    } else {
      high_security_items[this.index].style.display = "block";
      high_fuwu_li_p[this.index].style.color = "#162fac";
      arrows[this.index].style.transform = "rotate(135deg)";
      arrows[this.index].style.transition = "transform 0.4s";
    }
  };
}

// 机房选择
function machineroomtext() {

  var option_text_a = document.querySelectorAll(".option-text-a");
  var select_room_a = document.querySelector("#select-room-a");
  for (var i = 0; i < option_text_a.length; i++) {
    option_text_a[i].index = i;
    if (select_room_a.value == i) {
      for (var j = 0; j < option_text_a.length; j++) {
        option_text_a[j].className = "option-text-a";
      }
      option_text_a[i].className = "option-text-a option-e-active";
    }
  }
}

/***/ }),

/***/ 54:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


//----------------解决方案轮播图
if (document.querySelector("#mobileapp_solution") || document.querySelector("#chess_solution") || document.querySelector("#cabinet_to_rent") || document.querySelector("#home") || document.querySelector("#bandwidth_to_ent") || document.querySelector("#server_hosting") || document.querySelector("#DDOS_high_security_IP3") || document.querySelector("#high_proof_host") || document.querySelector("#cloud_hosting") || document.querySelector("#C_shield") || document.querySelector("#server_hire")) {
    slideshow_main("slideshow");
}
if (document.querySelector("#CDN_speed_up")) {
    slideshow_main("slideshow");
    slideshow_main("slideshow-a");
    slideshow_main("slideshow-b");
    slideshow_main("slideshow-c");
    slideshow_main("slideshow-d");
}
function slideshow_main(id) {
    var slideshow = document.getElementById(id).querySelector(".slideshow");
    var slideshowUl = document.getElementById(id).querySelector(".slideshow-ul");
    var slideshowLl = document.getElementById(id).querySelectorAll(".slideshow-li");
    var slideshowOl = document.getElementById(id).querySelector(".slideshow-ol");
    var screenWidth = document.documentElement.offsetWidth;
    if (!slideshowUl) {
        return;
    }
    // console.log(slideshowLl[0].offsetHeight);
    slideshowUl.style.height = slideshowLl[0].offsetHeight + 'px';
    // slideshowUl.style.height="141px";
    // 生成小圆点
    for (var i = 0; i < slideshowLl.length; i++) {
        var li = document.createElement('li');
        if (i == 0) {
            li.classList.add('point-active');
        } //
        slideshowOl.appendChild(li);
    }
    var left = slideshowLl.length - 1;
    var center = 0;
    var right = 1;
    setTransform();
    var timer = null;
    // 调用定时器
    timer = setInterval(showNext, 3000);
    // 分别绑定touch事件
    var startX = 0; // 手指落点
    var startTime = null; // 开始触摸时间
    slideshowUl.addEventListener('touchstart', touchstartHandler); // 滑动开始绑定的函数 touchstartHandler
    slideshowUl.addEventListener('touchmove', touchmoveHandler); // 持续滑动绑定的函数 touchmoveHandler
    slideshowUl.addEventListener('touchend', touchendHandeler);

    // 轮播图片切换
    function showNext() {
        // 轮转下标
        left = center;
        center = right;
        right++;
        // 极值判断
        if (right > slideshowLl.length - 1) {
            right = 0;
        }
        //添加过渡（多次使用，封装成函数）
        setTransition(1, 1, 0);
        setTransform();
        setPoint();
    }
    // 轮播图片切换上一张
    function showPrev() {
        // 轮转下标
        right = center;
        center = left;
        left--;
        //　极值判断
        if (left < 0) {
            left = slideshowLl.length - 1;
        }
        //添加过渡
        setTransition(0, 1, 1);
        setTransform();
        setPoint();
    }
    // 滑动开始
    function touchstartHandler(e) {
        clearInterval(timer);
        // 记录滑动开始的时间
        startTime = Date.now();
        // 记录手指最开始的落点
        startX = e.changedTouches[0].clientX;
    }
    // 滑动持续中
    function touchmoveHandler(e) {
        // 获取差值 自带正负
        var dx = e.changedTouches[0].clientX - startX;
        // 干掉过渡
        setTransition(0, 0, 0);
        // 归位
        setTransform(dx);
    }
    //　滑动结束
    function touchendHandeler(e) {
        // 在手指松开的时候，要判断当前是否滑动成功
        var dx = e.changedTouches[0].clientX - startX;
        // 获取时间差
        var dTime = Date.now() - startTime;
        // 滑动成功的依据是滑动的距离（绝对值）超过屏幕的三分之一 或者滑动的时间小于300毫秒同时滑动的距离大于30
        if (Math.abs(dx) > screenWidth / 3 || dTime < 300 && Math.abs(dx) > 30) {
            // 滑动成功了
            // 判断用户是往哪个方向滑
            if (dx > 0) {
                showPrev();
            } else {
                showNext();
            }
        } else {
            // 添加上过渡
            setTransition(1, 1, 1);
            // 滑动失败了
            setTransform();
        }

        // 重新启动定时器
        clearInterval(timer);
        // 调用定时器
        timer = setInterval(showNext, 3000);
    }
    // 设置过渡
    function setTransition(a, b, c) {
        if (a) {
            slideshowLl[left].style.transition = 'transform 1s';
        } else {
            slideshowLl[left].style.transition = 'none';
        }
        if (b) {
            slideshowLl[center].style.transition = 'transform 1s';
        } else {
            slideshowLl[center].style.transition = 'none';
        }
        if (c) {
            slideshowLl[right].style.transition = 'transform 1s';
        } else {
            slideshowLl[right].style.transition = 'none';
        }
    }
    //　封装归位
    function setTransform(dx) {
        dx = dx || 0;
        slideshowLl[left].style.transform = 'translateX(' + (-screenWidth + dx) + 'px)';
        slideshowLl[center].style.transform = 'translateX(' + dx + 'px)';
        slideshowLl[right].style.transform = 'translateX(' + (screenWidth + dx) + 'px)';
    }
    // 动态设置小圆点的active类
    var pointsLis = slideshowOl.querySelectorAll('li');
    var tempStr = "<span class=\"progress\"></span>";
    pointsLis[center].innerHTML = tempStr;
    function setPoint() {
        for (var i = 0; i < pointsLis.length; i++) {
            pointsLis[i].classList.remove('point-active');
            pointsLis[center].innerHTML = tempStr;
        }
        pointsLis[center].classList.add('point-active');
    }
}

/***/ }),

/***/ 55:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// 机房介绍
computer_introduce();
function computer_introduce() {
    if (!document.getElementsByClassName("region").length) {
        return;
    }
    var computer_Room = document.getElementsByClassName("region")[0];
    var computerRoom = computer_Room.getElementsByTagName("p");
    var computer_Content = document.getElementsByClassName("computer-content")[0];
    var computerContent = computer_Content.getElementsByTagName("table");
    for (var i = 0; i < computerRoom.length; i++) {
        computerRoom[i].index = i;
        computerRoom[i].onclick = function () {
            for (var k = 0; k < computerRoom.length; k++) {
                computerRoom[k].className = " ";
                computerContent[k].className = " ";
            }
            this.className = "active-room";
            computerContent[this.index].className = "active-tab";
        };
    }
}
//机房选择
// machineroomtext();
// function machineroomtext(){
if (document.querySelector("#cabinet_to_rent") || document.querySelector("#bandwidth_to_ent")) {
    document.querySelector("#select-room-a").onchange = function () {
        var option_text_a = document.querySelectorAll(".option-text-a");
        var select_room_a = document.querySelector("#select-room-a");
        for (var i = 0; i < option_text_a.length; i++) {
            option_text_a[i].index = i;
            if (select_room_a.value == i) {
                console.log(i);
                for (var j = 0; j < option_text_a.length; j++) {
                    option_text_a[j].className = "option-text-a";
                }
                option_text_a[i].className = "option-text-a option-e-active";
            }
        }
    };
}

/***/ }),

/***/ 56:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


if (document.querySelector("#server_hire")) {
    var server_room = function server_room() {
        var rooma = document.querySelector(".server-rooma");
        var selecta = document.getElementById("selecta");
        var selectb = document.getElementById("selectb");
        if (selecta.value == "湖南衡阳机房") {
            document.querySelector(".slideshow-a").style.display = "none";
            document.querySelector(".one-t").style.display = "none";
            document.querySelector(".slideshow").style.display = "block";
            document.querySelector(".nc-a").innerHTML = "16G";
            document.querySelector(".nc-b").innerHTML = "16G";
            document.querySelector(".nc-c").innerHTML = "16G";
            document.querySelector(".nc-d").innerHTML = "16G";
            document.querySelector(".dk-a").innerHTML = "G口 20M";
            document.querySelector(".dk-b").innerHTML = "G口 20M";
            document.querySelector(".dk-c").innerHTML = "G口 20M";
            document.querySelector(".dk-d").innerHTML = "G口 20M";
            document.querySelector(".fy-b").innerHTML = "40G";
            document.querySelector(".fy-c").innerHTML = "80G";
            document.querySelector(".fy-d").innerHTML = "120G";
            if (selectb.value == "联通服务器租用") {
                document.querySelector(".slideshow").style.display = "block";
                document.querySelector(".nothing").style.display = "none";
                document.querySelector(".s-t-a").innerHTML = "衡阳联通A型";
                document.querySelector(".s-t-b").innerHTML = "衡阳联通B型";
                document.querySelector(".s-t-c").innerHTML = "衡阳联通C型";
                document.querySelector(".s-t-d").innerHTML = "衡阳联通D型";
                document.querySelector(".n-ip-a").innerHTML = "1个";
                document.querySelector(".n-ip-b").innerHTML = "1个";
                document.querySelector(".n-ip-c").innerHTML = "1个";
                document.querySelector(".n-ip-d").innerHTML = "1个";
                document.querySelector(".span-a-a").innerHTML = "900";
                document.querySelector(".span-a-b").innerHTML = "8400";
                document.querySelector(".span-b-a").innerHTML = "900";
                document.querySelector(".span-b-b").innerHTML = "8400";
                document.querySelector(".span-c-a").innerHTML = "1400";
                document.querySelector(".span-c-b").innerHTML = "13200";
                document.querySelector(".span-d-a").innerHTML = "2100";
                document.querySelector(".span-d-b").innerHTML = "21600";
            }
            if (selectb.value == "电信服务器租用") {
                document.querySelector(".slideshow").style.display = "block";
                document.querySelector(".nothing").style.display = "none";
                document.querySelector(".s-t-a").innerHTML = "衡阳电信A型";
                document.querySelector(".s-t-b").innerHTML = "衡阳电信B型";
                document.querySelector(".s-t-c").innerHTML = "衡阳电信C型";
                document.querySelector(".s-t-d").innerHTML = "衡阳电信D型";
                document.querySelector(".n-ip-a").innerHTML = "1个";
                document.querySelector(".n-ip-b").innerHTML = "1个";
                document.querySelector(".n-ip-c").innerHTML = "1个";
                document.querySelector(".n-ip-d").innerHTML = "1个";
                document.querySelector(".span-a-a").innerHTML = "900";
                document.querySelector(".span-a-b").innerHTML = "8400";
                document.querySelector(".span-b-a").innerHTML = "900";
                document.querySelector(".span-b-b").innerHTML = "8400";
                document.querySelector(".span-c-a").innerHTML = "1400";
                document.querySelector(".span-c-b").innerHTML = "13200";
                document.querySelector(".span-d-a").innerHTML = "2100";
                document.querySelector(".span-d-b").innerHTML = "21600";
            }
            if (selectb.value == "双线服务器租用") {
                document.querySelector(".slideshow").style.display = "block";
                document.querySelector(".nothing").style.display = "none";
                document.querySelector(".s-t-a").innerHTML = "衡阳双线A型";
                document.querySelector(".s-t-b").innerHTML = "衡阳双线B型";
                document.querySelector(".s-t-c").innerHTML = "衡阳双线C型";
                document.querySelector(".s-t-d").innerHTML = "衡阳双线D型";
                document.querySelector(".n-ip-a").innerHTML = "2个";
                document.querySelector(".n-ip-b").innerHTML = "2个";
                document.querySelector(".n-ip-c").innerHTML = "2个";
                document.querySelector(".n-ip-d").innerHTML = "2个";
                document.querySelector(".span-a-a").innerHTML = "1100";
                document.querySelector(".span-a-b").innerHTML = "10800";
                document.querySelector(".span-b-a").innerHTML = "1100";
                document.querySelector(".span-b-b").innerHTML = "10800";
                document.querySelector(".span-c-a").innerHTML = "1600";
                document.querySelector(".span-c-b").innerHTML = "15600";
                document.querySelector(".span-d-a").innerHTML = "2300";
                document.querySelector(".span-d-b").innerHTML = "24000";
            }
            if (selectb.value == "三线服务器租用") {
                document.querySelector(".s-t-a").innerHTML = "衡阳三线";
                document.querySelector(".slideshow").style.display = "none";
                document.querySelector(".nothing").style.display = "block";
            }
        }
        if (selecta.value == "广东惠州机房") {
            document.querySelector(".slideshow-a").style.display = "none";
            document.querySelector(".slideshow").style.display = "none";
            document.querySelector(".one-t").style.display = "block";
            var one_li = document.querySelectorAll(".one-t .slide-li");
            if (selectb.value == "联通服务器租用") {
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li";
                }
                document.querySelector("#one-b").className = "slide-li active";
            }
            if (selectb.value == "电信服务器租用") {
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li";
                }
                document.querySelector("#one-a").className = "slide-li active";
            }
            if (selectb.value == "双线服务器租用") {
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li";
                }
                document.querySelector("#one-c").className = "slide-li active";
            }
            if (selectb.value == "三线服务器租用") {
                document.querySelector(".one-t").style.display = "none";
                document.querySelector(".one-t").style.display = "none";
                document.querySelector(".nothing").style.display = "block";
            }
        }
        if (selecta.value == "陕西西安机房") {
            document.querySelector(".slideshow-a").style.display = "block";
            document.querySelector(".slideshow").style.display = "none";
            document.querySelector(".nothing").style.display = "none";
            document.querySelector(".one-t").style.display = "none";
            document.querySelector(".nc-a-a").innerHTML = "16G";
            document.querySelector(".fy-b-a").innerHTML = "80G";
            document.querySelector(".fy-c-a").innerHTML = "160G";
            document.querySelector(".fy-d-a").innerHTML = "300G";
            document.querySelector(".nc-b-a").innerHTML = "16G";
            document.querySelector(".nc-c-a").innerHTML = "32G";
            document.querySelector(".nc-d-a").innerHTML = "32G";
            document.querySelector(".dk-a-a").innerHTML = "G口 20M";
            document.querySelector(".dk-b-a").innerHTML = "G口 20M";
            document.querySelector(".dk-c-a").innerHTML = "G口 20M";
            document.querySelector(".dk-d-a").innerHTML = "G口 20M";
            if (selectb.value == "联通服务器租用") {
                document.querySelector(".s-t-a-a").innerHTML = "西安联通A型";
                document.querySelector(".s-t-b-a").innerHTML = "西安联通B型";
                document.querySelector(".s-t-c-a").innerHTML = "西安联通C型";
                document.querySelector(".s-t-d-a").innerHTML = "西安联通D型";
                document.querySelector(".s-t-e").innerHTML = "西安联通";
                document.querySelector(".n-ip-a-a").innerHTML = "1个";
                document.querySelector(".n-ip-b-a").innerHTML = "1个";
                document.querySelector(".n-ip-c-a").innerHTML = "1个";
                document.querySelector(".n-ip-d-a").innerHTML = "1个";
                document.querySelector(".dk-a-a").innerHTML = "G口 20M";
                document.querySelector(".dk-b-a").innerHTML = "G口 20M";
                document.querySelector(".dk-c-a").innerHTML = "G口 100M";
                document.querySelector(".dk-d-a").innerHTML = "G口 200M";
                document.querySelector(".span-a-a-a").innerHTML = "1000";
                document.querySelector(".span-a-b-a").innerHTML = "9600";
                document.querySelector(".span-b-a-a").innerHTML = "1000";
                document.querySelector(".span-b-b-a").innerHTML = "9600";
                document.querySelector(".span-c-a-a").innerHTML = "1800";
                document.querySelector(".span-c-b-a").innerHTML = "18000";
                document.querySelector(".span-d-a-a").innerHTML = "3500";
                document.querySelector(".span-d-b-a").innerHTML = "36000";
            }
            if (selectb.value == "电信服务器租用") {
                document.querySelector(".s-t-a-a").innerHTML = "西安电信A型";
                document.querySelector(".s-t-b-a").innerHTML = "西安电信B型";
                document.querySelector(".s-t-c-a").innerHTML = "西安电信C型";
                document.querySelector(".s-t-d-a").innerHTML = "西安电信D型";
                document.querySelector(".s-t-e").innerHTML = "西安电信";
                document.querySelector(".n-ip-a-a").innerHTML = "1个";
                document.querySelector(".n-ip-b-a").innerHTML = "1个";
                document.querySelector(".n-ip-c-a").innerHTML = "1个";
                document.querySelector(".n-ip-d-a").innerHTML = "1个";
                document.querySelector(".dk-a-a").innerHTML = "G口 20M";
                document.querySelector(".dk-b-a").innerHTML = "G口 50M";
                document.querySelector(".dk-c-a").innerHTML = "G口 100M";
                document.querySelector(".dk-d-a").innerHTML = "G口 200M";
                document.querySelector(".span-a-a-a").innerHTML = "1000";
                document.querySelector(".span-a-b-a").innerHTML = "9600";
                document.querySelector(".span-b-a-a").innerHTML = "1000";
                document.querySelector(".span-b-b-a").innerHTML = "9600";
                document.querySelector(".span-c-a-a").innerHTML = "1800";
                document.querySelector(".span-c-b-a").innerHTML = "18000";
                document.querySelector(".span-d-a-a").innerHTML = "3500";
                document.querySelector(".span-d-b-a").innerHTML = "36000";
            }
            if (selectb.value == "双线服务器租用") {
                document.querySelector(".s-t-a-a").innerHTML = "西安双线A型";
                document.querySelector(".s-t-b-a").innerHTML = "西安双线B型";
                document.querySelector(".s-t-c-a").innerHTML = "西安双线C型";
                document.querySelector(".s-t-d-a").innerHTML = "西安双线D型";
                document.querySelector(".s-t-e").innerHTML = "西安双线";
                document.querySelector(".n-ip-a-a").innerHTML = "2个";
                document.querySelector(".n-ip-b-a").innerHTML = "2个";
                document.querySelector(".n-ip-c-a").innerHTML = "2个";
                document.querySelector(".n-ip-d-a").innerHTML = "2个";
                document.querySelector(".dk-a-a").innerHTML = "G口 20M";
                document.querySelector(".dk-b-a").innerHTML = "G口 20M";
                document.querySelector(".dk-c-a").innerHTML = "G口 100M";
                document.querySelector(".dk-d-a").innerHTML = "G口 200M";
                document.querySelector(".span-a-a-a").innerHTML = "1200";
                document.querySelector(".span-a-b-a").innerHTML = "14400";
                document.querySelector(".span-b-a-a").innerHTML = "1200";
                document.querySelector(".span-b-b-a").innerHTML = "14400";
                document.querySelector(".span-c-a-a").innerHTML = "2000";
                document.querySelector(".span-c-b-a").innerHTML = "24000";
                document.querySelector(".span-d-a-a").innerHTML = "3700";
                document.querySelector(".span-d-b-a").innerHTML = "44400";
            }
            if (selectb.value == "三线服务器租用") {
                document.querySelector(".s-t-a-a").innerHTML = "西安三线A型";
                document.querySelector(".s-t-b-a").innerHTML = "西安三线B型";
                document.querySelector(".s-t-c-a").innerHTML = "西安三线C型";
                document.querySelector(".s-t-d-a").innerHTML = "西安三线D型";
                document.querySelector(".s-t-e").innerHTML = "西安三线";
                document.querySelector(".n-ip-a-a").innerHTML = "3个";
                document.querySelector(".n-ip-b-a").innerHTML = "3个";
                document.querySelector(".n-ip-c-a").innerHTML = "3个";
                document.querySelector(".n-ip-d-a").innerHTML = "3个";
                document.querySelector(".dk-a-a").innerHTML = "G口 20M";
                document.querySelector(".dk-b-a").innerHTML = "G口 20M";
                document.querySelector(".dk-c-a").innerHTML = "G口 100M";
                document.querySelector(".dk-d-a").innerHTML = "G口 200M";
                document.querySelector(".span-a-a-a").innerHTML = "1500";
                document.querySelector(".span-a-b-a").innerHTML = "18000";
                document.querySelector(".span-b-a-a").innerHTML = "1500";
                document.querySelector(".span-b-b-a").innerHTML = "18000";
                document.querySelector(".span-c-a-a").innerHTML = "2300";
                document.querySelector(".span-c-b-a").innerHTML = "27600";
                document.querySelector(".span-d-a-a").innerHTML = "4000";
                document.querySelector(".span-d-b-a").innerHTML = "48000";
            }
        }
    };

    var s1 = document.querySelector("#selecta");
    var s2 = document.querySelector("#selectb");
    document.querySelector("#selectb").onchange = function () {
        server_room();
    };
    document.querySelector("#selecta").onchange = function () {
        server_room();
    };
}

/***/ }),

/***/ 57:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


//----------------解决方案轮播图
slideshow_a();
function slideshow_a() {
    var slideshowa = document.querySelector(".slideshow-a");
    var slideshowUla = document.querySelector(".slideshow-ul-a");
    var slideshowLla = document.querySelectorAll(".slideshow-li-a");
    var slideshowOla = document.querySelector(".slideshow-ol-a");
    var screenWidtha = document.documentElement.offsetWidth;
    if (!slideshowUla) {
        return;
    }
    // slideshowUla.style.height = slideshowLla[0].offsetHeight + 'px';
    slideshowUla.style.height = "202px";
    // 生成小圆点
    for (var i = 0; i < slideshowLla.length; i++) {
        var li = document.createElement('li');
        if (i == 0) {
            li.classList.add('point-active');
        } //
        slideshowOla.appendChild(li);
    }
    var left = slideshowLla.length - 1;
    var center = 0;
    var right = 1;
    setTransform();
    var timer = null;
    // 调用定时器
    timer = setInterval(showNext, 3000);
    // 分别绑定touch事件
    var startX = 0; // 手指落点
    var startTime = null; // 开始触摸时间
    slideshowUla.addEventListener('touchstart', touchstartHandler); // 滑动开始绑定的函数 touchstartHandler
    slideshowUla.addEventListener('touchmove', touchmoveHandler); // 持续滑动绑定的函数 touchmoveHandler
    slideshowUla.addEventListener('touchend', touchendHandeler);

    // 轮播图片切换
    function showNext() {
        // 轮转下标
        left = center;
        center = right;
        right++;
        // 极值判断
        if (right > slideshowLla.length - 1) {
            right = 0;
        }
        //添加过渡（多次使用，封装成函数）
        setTransition(1, 1, 0);
        setTransform();
        setPoint();
    }
    // 轮播图片切换上一张
    function showPrev() {
        // 轮转下标
        right = center;
        center = left;
        left--;
        //　极值判断
        if (left < 0) {
            left = slideshowLla.length - 1;
        }
        //添加过渡
        setTransition(0, 1, 1);
        setTransform();
        setPoint();
    }
    // 滑动开始
    function touchstartHandler(e) {
        clearInterval(timer);
        // 记录滑动开始的时间
        startTime = Date.now();
        // 记录手指最开始的落点
        startX = e.changedTouches[0].clientX;
    }
    // 滑动持续中
    function touchmoveHandler(e) {
        // 获取差值 自带正负
        var dx = e.changedTouches[0].clientX - startX;
        // 干掉过渡
        setTransition(0, 0, 0);
        // 归位
        setTransform(dx);
    }
    //　滑动结束
    function touchendHandeler(e) {
        // 在手指松开的时候，要判断当前是否滑动成功
        var dx = e.changedTouches[0].clientX - startX;
        // 获取时间差
        var dTime = Date.now() - startTime;
        // 滑动成功的依据是滑动的距离（绝对值）超过屏幕的三分之一 或者滑动的时间小于300毫秒同时滑动的距离大于30
        if (Math.abs(dx) > screenWidtha / 3 || dTime < 300 && Math.abs(dx) > 30) {
            // 滑动成功了
            // 判断用户是往哪个方向滑
            if (dx > 0) {
                showPrev();
            } else {
                showNext();
            }
        } else {
            // 添加上过渡
            setTransition(1, 1, 1);
            // 滑动失败了
            setTransform();
        }

        // 重新启动定时器
        clearInterval(timer);
        // 调用定时器
        timer = setInterval(showNext, 3000);
    }
    // 设置过渡
    function setTransition(a, b, c) {
        if (a) {
            slideshowLla[left].style.transition = 'transform 1s';
        } else {
            slideshowLla[left].style.transition = 'none';
        }
        if (b) {
            slideshowLla[center].style.transition = 'transform 1s';
        } else {
            slideshowLla[center].style.transition = 'none';
        }
        if (c) {
            slideshowLla[right].style.transition = 'transform 1s';
        } else {
            slideshowLla[right].style.transition = 'none';
        }
    }
    //　封装归位
    function setTransform(dx) {
        dx = dx || 0;
        slideshowLla[left].style.transform = 'translateX(' + (-screenWidtha + dx) + 'px)';
        slideshowLla[center].style.transform = 'translateX(' + dx + 'px)';
        slideshowLla[right].style.transform = 'translateX(' + (screenWidtha + dx) + 'px)';
    }
    // 动态设置小圆点的active类
    var pointsLis = slideshowOla.querySelectorAll('li');
    var tempStr = "<span class=\"progress\"></span>";
    pointsLis[center].innerHTML = tempStr;
    function setPoint() {
        for (var i = 0; i < pointsLis.length; i++) {
            pointsLis[i].classList.remove('point-active');
            pointsLis[center].innerHTML = tempStr;
        }
        pointsLis[center].classList.add('point-active');
    }
}

/***/ }),

/***/ 58:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


if (document.querySelector("#server_hosting")) {
    var server_h_room = function server_h_room() {
        var rooma = document.querySelector(".server-rooma");
        var select1 = document.getElementById("select1");
        var select2 = document.getElementById("select2");
        // console.log(aa);
        if (select1.value == "湖南衡阳机房") {
            document.querySelector(".slideshow-a").style.display = "none";
            document.querySelector(".one-t").style.display = "none";
            document.querySelector(".slideshow").style.display = "block";
            if (select2.value == "电信1U") {
                document.querySelector(".slideshow").style.display = "block";
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".gga-a")[i].innerHTML = "1U";
                }
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".ipa-a")[i].innerHTML = "1个";
                }
                document.querySelector(".li_t_a").innerHTML = "电信无防企业型";
                document.querySelector(".li_t_b").innerHTML = "电信40G硬防型";
                document.querySelector(".li_t_c").innerHTML = "电信80G硬防型";
                document.querySelector(".li_t_d").innerHTML = "电信120G硬防型";
                document.querySelector(".fya-a").innerHTML = "无";
                document.querySelector(".fya-b").innerHTML = "40G";
                document.querySelector(".fya-c").innerHTML = "80G";
                document.querySelector(".fya-d").innerHTML = "120G";
                document.querySelector(".yfa-a").innerHTML = "800";
                document.querySelector(".yfa-b").innerHTML = "800";
                document.querySelector(".yfa-c").innerHTML = "1300";
                document.querySelector(".yfa-d").innerHTML = "2000";
                document.querySelector(".nfa-a").innerHTML = "7200";
                document.querySelector(".nfa-b").innerHTML = "7200";
                document.querySelector(".nfa-c").innerHTML = "12000";
                document.querySelector(".nfa-d").innerHTML = "20400";
            }
            if (select2.value == "电信2U") {
                document.querySelector(".slideshow").style.display = "block";
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".gga-a")[i].innerHTML = "2U";
                }
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".ipa-a")[i].innerHTML = "1个";
                }
                document.querySelector(".li_t_a").innerHTML = "电信无防企业型";
                document.querySelector(".li_t_b").innerHTML = "电信40G硬防型";
                document.querySelector(".li_t_c").innerHTML = "电信80G硬防型";
                document.querySelector(".li_t_d").innerHTML = "电信120G硬防型";

                document.querySelector(".yfa-a").innerHTML = "1000";
                document.querySelector(".yfa-b").innerHTML = "1000";
                document.querySelector(".yfa-c").innerHTML = "1500";
                document.querySelector(".yfa-d").innerHTML = "2200";
                document.querySelector(".nfa-a").innerHTML = "9600";
                document.querySelector(".nfa-b").innerHTML = "9600";
                document.querySelector(".nfa-c").innerHTML = "14400";
                document.querySelector(".nfa-d").innerHTML = "22800";
            }
            if (select2.value == "联通1U") {
                document.querySelector(".slideshow").style.display = "block";
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".gga-a")[i].innerHTML = "1U";
                }
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".ipa-a")[i].innerHTML = "1个";
                }
                document.querySelector(".li_t_a").innerHTML = "联通无防企业型";
                document.querySelector(".li_t_b").innerHTML = "联通40G硬防型";
                document.querySelector(".li_t_c").innerHTML = "联通80G硬防型";
                document.querySelector(".li_t_d").innerHTML = "联通120G硬防型";

                document.querySelector(".yfa-a").innerHTML = "800";
                document.querySelector(".yfa-b").innerHTML = "800";
                document.querySelector(".yfa-c").innerHTML = "1300";
                document.querySelector(".yfa-d").innerHTML = "2000";
                document.querySelector(".nfa-a").innerHTML = "7200";
                document.querySelector(".nfa-b").innerHTML = "7200";
                document.querySelector(".nfa-c").innerHTML = "12000";
                document.querySelector(".nfa-d").innerHTML = "20400";
            }
            if (select2.value == "联通2U") {
                document.querySelector(".slideshow").style.display = "block";
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".gga-a")[i].innerHTML = "2U";
                }
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".ipa-a")[i].innerHTML = "1个";
                }

                document.querySelector(".li_t_a").innerHTML = "联通无防企业型";
                document.querySelector(".li_t_b").innerHTML = "联通40G硬防型";
                document.querySelector(".li_t_c").innerHTML = "联通80G硬防型";
                document.querySelector(".li_t_d").innerHTML = "联通120G硬防型";

                document.querySelector(".yfa-a").innerHTML = "1000";
                document.querySelector(".yfa-b").innerHTML = "1000";
                document.querySelector(".yfa-c").innerHTML = "1500";
                document.querySelector(".yfa-d").innerHTML = "2200";
                document.querySelector(".nfa-a").innerHTML = "9600";
                document.querySelector(".nfa-b").innerHTML = "9600";
                document.querySelector(".nfa-c").innerHTML = "14400";
                document.querySelector(".nfa-d").innerHTML = "22800";
            }
            if (select2.value == "双线1U") {
                document.querySelector(".slideshow").style.display = "block";
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".gga-a")[i].innerHTML = "1U";
                }
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".ipa-a")[i].innerHTML = "2个";
                }
                document.querySelector(".li_t_a").innerHTML = "双线无防企业型";
                document.querySelector(".li_t_b").innerHTML = "双线40G硬防型";
                document.querySelector(".li_t_c").innerHTML = "双线80G硬防型";
                document.querySelector(".li_t_d").innerHTML = "双线120G硬防型";

                document.querySelector(".yfa-a").innerHTML = "1000";
                document.querySelector(".yfa-b").innerHTML = "1000";
                document.querySelector(".yfa-c").innerHTML = "1500";
                document.querySelector(".yfa-d").innerHTML = "2200";
                document.querySelector(".nfa-a").innerHTML = "9600";
                document.querySelector(".nfa-b").innerHTML = "9600";
                document.querySelector(".nfa-c").innerHTML = "14400";
                document.querySelector(".nfa-d").innerHTML = "22800";
            }
            if (select2.value == "双线2U") {
                document.querySelector(".slideshow").style.display = "block";
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".gga-a")[i].innerHTML = "2U";
                }
                for (var i = 0; i < 4; i++) {
                    document.querySelectorAll(".ipa-a")[i].innerHTML = "2个";
                }
                document.querySelector(".li_t_a").innerHTML = "双线无防企业型";
                document.querySelector(".li_t_b").innerHTML = "双线40G硬防型";
                document.querySelector(".li_t_c").innerHTML = "双线80G硬防型";
                document.querySelector(".li_t_d").innerHTML = "双线120G硬防型";

                document.querySelector(".yfa-a").innerHTML = "1200";
                document.querySelector(".yfa-b").innerHTML = "1200";
                document.querySelector(".yfa-c").innerHTML = "1700";
                document.querySelector(".yfa-d").innerHTML = "2400";
                document.querySelector(".nfa-a").innerHTML = "12000";
                document.querySelector(".nfa-b").innerHTML = "12000";
                document.querySelector(".nfa-c").innerHTML = "16800";
                document.querySelector(".nfa-d").innerHTML = "25200";
            }
            if (select2.value == "三线1U") {
                document.querySelector(".slideshow").style.display = "none";
                document.querySelector(".slideshow-a").style.display = "none";
                document.querySelector(".nothing").style.display = "block";
                document.querySelector(".not_gg").innerHTML = "1U";
            }
            if (select2.value == "三线2U") {
                document.querySelector(".slideshow").style.display = "none";
                document.querySelector(".slideshow-a").style.display = "none";
                document.querySelector(".nothing").style.display = "block";
                document.querySelector(".not_gg").innerHTML = "2U";
            }
        }
        if (select1.value == "广东惠州机房") {
            document.querySelector(".slideshow-a").style.display = "none";
            document.querySelector(".slideshow").style.display = "none";
            document.querySelector(".one-t").style.display = "block";
            var one_li = document.querySelectorAll(".one-t .slide-li");
            if (select2.value == "电信1U") {
                console.log("联通服务器租用");
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li clear";
                }
                document.querySelector("#one-a").className = "slide-li active clear";
            }
            if (select2.value == "电信2U") {
                console.log("电信服务器租用");
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li clear";
                }
                document.querySelector("#one-e").className = "slide-li active clear";
            }
            if (select2.value == "联通1U") {
                console.log("双线服务器租用");
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li clear";
                }
                document.querySelector("#one-b").className = "slide-li active clear";
            }
            if (select2.value == "联通2U") {
                console.log("----------");
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li clear";
                }
                document.querySelector("#one-f").className = "slide-li active clear";
                // document.querySelector(".one-t").style.display="none";
                // document.querySelector(".one-t").style.display="none";
                // document.querySelector(".nothing").style.display="block";
            }
            if (select2.value == "双线1U") {
                console.log("双线服务器租用");
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li clear";
                }
                document.querySelector("#one-c").className = "slide-li active clear";
            }
            if (select2.value == "双线2U") {
                console.log("双线服务器租用");
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li clear";
                }
                document.querySelector("#one-g").className = "slide-li active clear";
            }
            if (select2.value == "三线1U") {
                console.log("双线服务器租用");
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li clear";
                }
                document.querySelector("#one-d").className = "slide-li active clear";
            }
            if (select2.value == "三线2U") {
                console.log("双线服务器租用");
                document.querySelector(".nothing").style.display = "none";
                for (var i = 0; i < one_li.length; i++) {
                    one_li[i].className = "slide-li clear";
                }
                document.querySelector("#one-h").className = "slide-li active clear";
            }
        }
        if (select1.value == "陕西西安机房") {
            document.querySelector(".slideshow-a").style.display = "block";
            document.querySelector(".nothing").style.display = "none";
            document.querySelector(".one-t").style.display = "none";
            document.querySelector(".slideshow").style.display = "none";
            document.querySelector(".fya-a").innerHTML = "80G";
            document.querySelector(".fya-b").innerHTML = "160G";
            document.querySelector(".fya-c").innerHTML = "300G";
            document.querySelector(".dkb-a").innerHTML = "50M";
            document.querySelector(".dkb-b").innerHTML = "100G";
            document.querySelector(".dkb-c").innerHTML = "200G";
            if (select2.value == "电信1U") {
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ggb-a")[i].innerHTML = "1U";
                }
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ipb-a")[i].innerHTML = "1个";
                }
                document.querySelector(".li_t_b_a").innerHTML = "电信80G硬防型";
                document.querySelector(".li_t_b_b").innerHTML = "电信160G硬防型";
                document.querySelector(".li_t_b_c").innerHTML = "电信300G硬防型";

                document.querySelector(".yfb-a").innerHTML = "900";
                document.querySelector(".yfb-b").innerHTML = "8400";
                document.querySelector(".yfb-c").innerHTML = "1700";
                document.querySelector(".nfb-a").innerHTML = "16800";
                document.querySelector(".nfb-b").innerHTML = "3400";
                document.querySelector(".nfb-a").innerHTML = "34800";
            }
            if (select2.value == "电信2U") {
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ggb-a")[i].innerHTML = "2U";
                }
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ipb-a")[i].innerHTML = "1个";
                }
                document.querySelector(".li_t_b_a").innerHTML = "电信80G硬防型";
                document.querySelector(".li_t_b_b").innerHTML = "电信160G硬防型";
                document.querySelector(".li_t_b_c").innerHTML = "电信300G硬防型";
                document.querySelector(".yfb-a").innerHTML = "1100";
                document.querySelector(".yfb-b").innerHTML = "10800";
                document.querySelector(".yfb-c").innerHTML = "1900";
                document.querySelector(".nfb-a").innerHTML = "19200";
                document.querySelector(".nfb-b").innerHTML = "3600";
                document.querySelector(".nfb-a").innerHTML = "37200";
            }
            if (select2.value == "联通1U") {
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ggb-a")[i].innerHTML = "1U";
                }
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ipb-a")[i].innerHTML = "1个";
                }
                document.querySelector(".li_t_b_a").innerHTML = "联通80G硬防型";
                document.querySelector(".li_t_b_b").innerHTML = "联通160G硬防型";
                document.querySelector(".li_t_b_c").innerHTML = "联通300G硬防型";
                document.querySelector(".yfb-a").innerHTML = "900";
                document.querySelector(".yfb-b").innerHTML = "8400";
                document.querySelector(".yfb-c").innerHTML = "1700";
                document.querySelector(".nfb-a").innerHTML = "16800";
                document.querySelector(".nfb-b").innerHTML = "3400";
                document.querySelector(".nfb-a").innerHTML = "34800";
            }
            if (select2.value == "联通2U") {
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ggb-a")[i].innerHTML = "2U";
                }
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ipb-a")[i].innerHTML = "1个";
                }
                document.querySelector(".li_t_b_a").innerHTML = "联通80G硬防型";
                document.querySelector(".li_t_b_b").innerHTML = "联通160G硬防型";
                document.querySelector(".li_t_b_c").innerHTML = "联通300G硬防型";
                document.querySelector(".yfb-a").innerHTML = "1100";
                document.querySelector(".yfb-b").innerHTML = "10800";
                document.querySelector(".yfb-c").innerHTML = "1900";
                document.querySelector(".nfb-a").innerHTML = "19200";
                document.querySelector(".nfb-b").innerHTML = "3600";
                document.querySelector(".nfb-a").innerHTML = "37200";
            }
            if (select2.value == "双线1U") {
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ggb-a")[i].innerHTML = "1U";
                }
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ipb-a")[i].innerHTML = "2个";
                }
                document.querySelector(".li_t_b_a").innerHTML = "双线80G硬防型";
                document.querySelector(".li_t_b_b").innerHTML = "双线160G硬防型";
                document.querySelector(".li_t_b_c").innerHTML = "双线300G硬防型";
                document.querySelector(".yfb-a").innerHTML = "1100";
                document.querySelector(".yfb-b").innerHTML = "10800";
                document.querySelector(".yfb-c").innerHTML = "1900";
                document.querySelector(".nfb-a").innerHTML = "19200";
                document.querySelector(".nfb-b").innerHTML = "3600";
                document.querySelector(".nfb-a").innerHTML = "37200";
            }
            if (select2.value == "双线2U") {
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ggb-a")[i].innerHTML = "2U";
                }
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ipb-a")[i].innerHTML = "2个";
                }
                document.querySelector(".li_t_b_a").innerHTML = "双线80G硬防型";
                document.querySelector(".li_t_b_b").innerHTML = "双线160G硬防型";
                document.querySelector(".li_t_b_c").innerHTML = "双线300G硬防型";
                document.querySelector(".yfb-a").innerHTML = "1300";
                document.querySelector(".yfb-b").innerHTML = "13200";
                document.querySelector(".yfb-c").innerHTML = "2100";
                document.querySelector(".nfb-a").innerHTML = "21600";
                document.querySelector(".nfb-b").innerHTML = "3800";
                document.querySelector(".nfb-a").innerHTML = "39600";
            }
            if (select2.value == "三线1U") {
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ggb-a")[i].innerHTML = "1U";
                }
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ipb-a")[i].innerHTML = "3个";
                }
                document.querySelector(".li_t_b_a").innerHTML = "三线80G硬防型";
                document.querySelector(".li_t_b_b").innerHTML = "三线160G硬防型";
                document.querySelector(".li_t_b_c").innerHTML = "三线300G硬防型";
                document.querySelector(".yfb-a").innerHTML = "1400";
                document.querySelector(".yfb-b").innerHTML = "12000";
                document.querySelector(".yfb-c").innerHTML = "2200";
                document.querySelector(".nfb-a").innerHTML = "20400";
                document.querySelector(".nfb-b").innerHTML = "3900";
                document.querySelector(".nfb-a").innerHTML = "38400";
            }
            if (select2.value == "三线2U") {
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ggb-a")[i].innerHTML = "2U";
                }
                for (var i = 0; i < 3; i++) {
                    document.querySelectorAll(".ipb-a")[i].innerHTML = "3个";
                }
                document.querySelector(".li_t_b_a").innerHTML = "三线80G硬防型";
                document.querySelector(".li_t_b_b").innerHTML = "三线160G硬防型";
                document.querySelector(".li_t_b_c").innerHTML = "三线300G硬防型";
                document.querySelector(".yfb-a").innerHTML = "1600";
                document.querySelector(".yfb-b").innerHTML = "14400";
                document.querySelector(".yfb-c").innerHTML = "2400";
                document.querySelector(".nfb-a").innerHTML = "22800";
                document.querySelector(".nfb-b").innerHTML = "4100";
                document.querySelector(".nfb-a").innerHTML = "40800";
            }
        }
    };

    var s1 = document.querySelector("#select1");
    var s2 = document.querySelector("#select2");
    if (document.body.clientWidth < 330) {
        document.querySelector(".compouter-advantage").style.backgroundSize = "320px 345px";
    }
    document.querySelector("#select1").onchange = function () {
        server_h_room();
    };
    document.querySelector("#select2").onchange = function () {
        server_h_room();
    };
}

/***/ }),

/***/ 59:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// CDN加速
if (document.querySelector("#CDN_speed_up")) {
    var accelerate_li = document.querySelector(".accelerate_class").getElementsByTagName("li");
    var class_item = document.querySelectorAll(".class-item");
    var class_item_a = document.querySelector(".class-item-a");
    var class_i_active = document.querySelector(".class-i-active");
    var CDN_up = document.querySelector(".CDN_up");
    var classitema = document.querySelector(".class-item-a");
    var rectangular_l = document.querySelector(".rectangular-l").querySelector("div");
    rectangular_l.style.height = document.querySelector(".rectangular").offsetHeight - 30 + "px";
    CDN_up.style.height = classitema.offsetHeight + 'px';
    for (var i = 0; i < accelerate_li.length; i++) {
        accelerate_li[i].index = i;
        accelerate_li[i].onclick = function () {
            for (var j = 0; j < accelerate_li.length; j++) {

                accelerate_li[j].className = " ";
                class_item[j].className = "class-item ";
            }
            document.querySelector(".CDN_up").style.height = "100%";
            this.className = "class-active";
            class_item[this.index].className = "class-item class-i-active";
            class_item_a.style.display = "none";
        };
    }
}

/***/ }),

/***/ 60:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


if (document.querySelector("#company_introduction")) {
    var machineroom = function machineroom() {
        var arrows = document.querySelector(".drop-options .arrow");
        if (document.querySelector(".select-text").style.display == "none") {
            document.querySelector(".select-text").style.display = "block";
            arrows.style.transform = "rotate(135deg)";
            arrows.style.transition = "transform 0.4s";
        } else {
            document.querySelector(".select-text").style.display = "none";
            arrows.style.transform = "rotate(-45deg)";
            arrows.style.transition = "transform 0.4s";
        }
        var option_text = document.querySelectorAll(".option-text");
        var option_i = document.querySelectorAll(".option-i");
        var p_value = document.querySelector(".drop-options p");
        for (var i = 0; i < option_i.length; i++) {
            option_i[i].index = i;
            option_i[i].addEventListener("click", function () {
                for (var j = 0; j < option_text.length; j++) {
                    option_text[j].className = "option-text";
                }
                option_text[this.index].className = "option-text option-e-active";
                p_value.innerHTML = option_i[this.index].innerHTML;
            });
        }

        document.addEventListener("touchmove", function (e) {
            if (e.target == document.querySelector(".drop-options p") || e.target == document.querySelector(".select-text")) {
                document.querySelector(".select-text").style.display = "block";
                document.querySelector(".drop-options .arrow").style.transform = "rotate(135deg)";
                document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
            } else {
                // moreContent.style.display = "none"
                document.querySelector(".select-text").style.display = "none";
                document.querySelector(".drop-options .arrow").style.transform = "rotate(-45deg)";
                document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
            }
        });
    };

    // 新闻公告分页
    var goPage = function goPage(pno, psize) {
        var news = document.querySelectorAll(".option-text .news");
        var num = news.length;
        var totalPage = 0; //总页数
        var pageSize = psize; //每页显示行数
        //总共分几页
        if (num / pageSize > parseInt(num / pageSize)) {
            totalPage = parseInt(num / pageSize) + 1;
        } else {
            totalPage = parseInt(num / pageSize);
        }
        var currentPage = pno; //当前页数
        var startRow = (currentPage - 1) * pageSize + 1; //开始显示的行  31
        var endRow = currentPage * pageSize; //结束显示的行   40
        endRow = endRow > num ? num : endRow;
        //遍历显示数据实现分页
        for (var i = 1; i < num + 1; i++) {
            var irow = news[i - 1];
            if (i >= startRow && i <= endRow) {
                irow.style.display = "block";
            } else {
                irow.style.display = "none";
            }
        }

        var tempStr = "";
        if (currentPage > 1) {
            tempStr += "<div style=\"width: 90px;\">";
            tempStr += "<img src=\"/images/wap/第一页.png\" onClick=\"goPage(" + 1 + "," + psize + ")\">";
            tempStr += "<img src=\"/images/wap/上一页.png\" onClick=\"goPage(" + (currentPage - 1) + "," + psize + ")\">";
            tempStr += "</div>";
        } else {
            tempStr += "<div style=\"width: 90px;\">";
            tempStr += "<img src=\"/images/wap/第一页.png\" >";
            tempStr += "<img src=\"/images/wap/上一页.png\" >";
            tempStr += "</div>";
        }
        if (currentPage >= 10) {
            tempStr += "<div class=\"page\" id=\"page\">";
            tempStr += "<span>" + currentPage + "</span>";
        } else {
            tempStr += "<div class=\"page\" id=\"page\">";
            tempStr += "<span>" + "0" + currentPage + "</span>";
        }
        if (totalPage >= 10) {
            tempStr += "/" + totalPage;
            tempStr += "</div>";
        } else {
            tempStr += "/0" + totalPage;
            tempStr += "</div>";
        }
        if (currentPage < totalPage) {
            tempStr += "<div style=\"width: 90px;\">";
            tempStr += "<img src=\"/images/wap/下一页.png\" onClick=\"goPage(" + (currentPage + 1) + "," + psize + ")\">";
            tempStr += "<img src=\"/images/wap/最后一页.png\" onClick=\"goPage(" + totalPage + "," + psize + ")\">";
            tempStr += "</div>";
        } else {
            tempStr += "<div style=\"width: 90px;\">";
            tempStr += "<img src=\"/images/wap/下一页.png\" >";
            tempStr += "<img src=\"/images/wap/最后一页.png\">";
            tempStr += "</div>";
        }

        document.getElementById("bottom").innerHTML = tempStr;
    };

    var news = document.querySelectorAll(".news");
    var optiontext = document.querySelectorAll(".option-text");
    for (var i = 0; i < news.length; i++) {
        news[i].index = i;
        news[i].onclick = function () {
            for (var j = 0; j < optiontext.length; j++) {
                optiontext[j].className = "option-text";
            }
            document.querySelector(".news-content").style.display = "block";
        };
    }
    // 公司简介
    if (document.querySelector(".drop-options p")) {
        document.querySelector(".drop-options p").addEventListener("click", machineroom);
    }

    if (document.body.clientWidth < 330) {
        document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[0].querySelectorAll("div")[0].style.marginLeft = "-50%";
        document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[0].querySelectorAll("div")[2].style.marginRight = "-50%";
        document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[1].querySelectorAll("div")[0].style.marginLeft = "-50%";
        document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[1].querySelectorAll("div")[2].style.marginRight = "-50%";
        document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[2].querySelectorAll("div")[0].style.marginLeft = "-50%";
        document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[2].querySelectorAll("div")[2].style.marginRight = "-50%";
        document.querySelectorAll(".option-text")[5].querySelector(".bottom").querySelectorAll("div")[0].style.marginLeft = "-47%";
        document.querySelectorAll(".option-text")[5].querySelector(".bottom").querySelectorAll("div")[2].style.marginRight = "-47%";
        document.querySelectorAll(".option-text")[5].style.padding = "30px 11px";
        var lis = document.querySelectorAll(".option-text")[5].querySelectorAll(".contact-us")[2].querySelectorAll(" ol li");
        for (var i = 0; i < lis.length; i++) {
            lis[i].style.padding = " 10px 3px";
        }
        document.querySelectorAll(".option-text")[5].querySelectorAll(".contact-us")[2].style.padding = "0px 5px 15px 5px";
    }
    // 售前人员 翻页
    var personnel_a = document.querySelectorAll(".personnel-a");
    var pagenext = document.querySelector(".pagenext");
    var pagepre = document.querySelector(".pagepre");
    var pagefirst = document.querySelector(".pagefirst");
    var pagelast = document.querySelector(".pagelast");
    var pagelength = personnel_a.length;
    var page = 0;

    pagenext.onclick = function () {
        // var pageNumber = document.querySelector("#pageNumber").innerText;
        // console.log(pageNumber);
        for (var j = 0; j < personnel_a.length; j++) {
            personnel_a[j].className = "personnel-a";
        }
        if (page + 1 < pagelength) {
            page = page + 1;
            personnel_a[page].className = "personnel-a active-block";
            document.getElementById("pageNumbers").innerHTML = "0" + (page + 1);
        } else {
            personnel_a[pagelength - 1].className = "personnel-a active-block";
        }
    };
    pagepre.onclick = function () {
        for (var j = 0; j < personnel_a.length; j++) {
            personnel_a[j].className = "personnel-a";
        }
        if (page - 1 >= 0) {
            page = page - 1;
            personnel_a[page].className = "personnel-a active-block";
            document.getElementById("pageNumbers").innerHTML = "0" + (page + 1);
        } else {
            personnel_a[0].className = "personnel-a active-block";
        }
    };
    pagefirst.onclick = function () {
        for (var j = 0; j < personnel_a.length; j++) {
            personnel_a[j].className = "personnel-a";
        }
        personnel_a[0].className = "personnel-a active-block";
        page = 0;
        document.getElementById("pageNumbers").innerHTML = "01";
    };
    pagelast.onclick = function () {
        for (var j = 0; j < personnel_a.length; j++) {
            personnel_a[j].className = "personnel-a";
        }
        personnel_a[pagelength - 1].className = "personnel-a active-block";
        document.getElementById("pageNumbers").innerHTML = "0" + pagelength;
    };

    // 荣誉资质
    var honor_a = document.querySelector(".honor-a");
    var honor_i_a = honor_a.querySelectorAll(".honor-i");
    var pagea = 0;
    document.querySelector(".p-nexta").onclick = function () {

        for (var j = 0; j < honor_i_a.length; j++) {
            honor_i_a[j].className = "honor-i clear";
        }
        if (pagea + 1 < honor_i_a.length) {
            pagea = pagea + 1;
            honor_i_a[pagea].className = "honor-i clear active";
            document.getElementById("pageNumber").innerHTML = "0" + (pagea + 1);
        } else {
            honor_i_a[honor_i_a.length - 1].className = "honor-i clear active";
        }
    };
    document.querySelector(".p-prea").onclick = function () {
        for (var j = 0; j < honor_i_a.length; j++) {
            honor_i_a[j].className = "honor-i clear";
        }
        if (pagea - 1 >= 0) {
            pagea = pagea - 1;
            honor_i_a[pagea].className = "honor-i clear active";
            document.getElementById("pageNumber").innerHTML = "0" + (pagea + 1);
        } else {
            honor_i_a[0].className = "honor-i clear active";
        }
    };
    document.querySelector(".p-firsta").onclick = function () {
        for (var j = 0; j < honor_i_a.length; j++) {
            honor_i_a[j].className = "honor-i clear";
        }
        honor_i_a[0].className = "honor-i clear active";
        pagea = 0;
        document.getElementById("pageNumber").innerHTML = "0" + (pagea + 1);
    };
    document.querySelector(".p-lasta").onclick = function () {
        for (var j = 0; j < honor_i_a.length; j++) {
            honor_i_a[j].className = "honor-i clear";
        }
        honor_i_a[honor_i_a.length - 1].className = "honor-i clear active";
        document.getElementById("pageNumber").innerHTML = "0" + honor_i_a.length;
    };
    var honor_b = document.querySelector(".honor-b");
    var honor_i_b = honor_b.querySelectorAll(".honor-i");
    var pageb = 0;
    document.querySelector(".p-nextb").onclick = function () {

        for (var j = 0; j < honor_i_b.length; j++) {
            honor_i_b[j].className = "honor-i clear";
        }
        if (pageb + 1 < honor_i_b.length) {
            pageb = pageb + 1;
            honor_i_b[pageb].className = "honor-i clear active";
            document.getElementById("pageNumberb").innerHTML = "0" + (pageb + 1);
        } else {
            honor_i_b[honor_i_b.length - 1].className = "honor-i clear active";
        }
    };
    document.querySelector(".p-preb").onclick = function () {
        for (var j = 0; j < honor_i_b.length; j++) {
            honor_i_b[j].className = "honor-i clear";
        }
        if (pageb - 1 >= 0) {
            pageb = pageb - 1;
            honor_i_b[pageb].className = "honor-i clear active";
            document.getElementById("pageNumberb").innerHTML = "0" + (pageb + 1);
        } else {
            honor_i_b[0].className = "honor-i clear active";
        }
    };
    document.querySelector(".p-firstb").onclick = function () {
        for (var j = 0; j < honor_i_b.length; j++) {
            honor_i_b[j].className = "honor-i clear";
        }
        honor_i_b[0].className = "honor-i clear active";
        pageb = 0;
        document.getElementById("pageNumberb").innerHTML = "0" + (pageb + 1);
    };
    document.querySelector(".p-lastb").onclick = function () {
        for (var j = 0; j < honor_i_b.length; j++) {
            honor_i_b[j].className = "honor-i clear";
        }
        honor_i_b[honor_i_b.length - 1].className = "honor-i clear active";
        document.getElementById("pageNumberb").innerHTML = "0" + honor_i_b.length;
    };
    var honor_c = document.querySelector(".honor-c");
    var honor_i_c = honor_c.querySelectorAll(".honor-i");
    var pagec = 0;
    document.querySelector(".p-nextc").onclick = function () {

        for (var j = 0; j < honor_i_c.length; j++) {
            honor_i_c[j].className = "honor-i clear";
        }
        if (pagec + 1 < honor_i_c.length) {
            pagec = pagec + 1;
            honor_i_c[pagec].className = "honor-i clear active";
            document.getElementById("pageNumberc").innerHTML = "0" + (pagec + 1);
        } else {
            honor_i_c[honor_i_c.length - 1].className = "honor-i clear active";
        }
    };
    document.querySelector(".p-prec").onclick = function () {
        for (var j = 0; j < honor_i_c.length; j++) {
            honor_i_c[j].className = "honor-i clear";
        }
        if (pagec - 1 >= 0) {
            pagec = pagec - 1;
            honor_i_c[pagec].className = "honor-i clear active";
            document.getElementById("pageNumberc").innerHTML = "0" + (pagec + 1);
        } else {
            honor_i_c[0].className = "honor-i clear active";
        }
    };
    document.querySelector(".p-firstc").onclick = function () {
        for (var j = 0; j < honor_i_c.length; j++) {
            honor_i_c[j].className = "honor-i clear";
        }
        honor_i_c[0].className = "honor-i clear active";
        pagec = 0;
        document.getElementById("pageNumberc").innerHTML = "0" + (pagec + 1);
    };
    document.querySelector(".p-lastc").onclick = function () {
        for (var j = 0; j < honor_i_c.length; j++) {
            honor_i_c[j].className = "honor-i clear";
        }
        honor_i_c[honor_i_c.length - 1].className = "honor-i clear active";
        document.getElementById("pageNumberc").innerHTML = "0" + honor_i_c.length;
    };
    if (document.querySelector("#company_news")) {
        goPage(1, 10);
    }
}

/***/ }),

/***/ 61:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var help_home_s = document.querySelectorAll(".option-text .help-home-s");
for (var i = 0; i < help_home_s.length; i++) {
    help_home_s[i].addEventListener("click", function () {
        document.querySelector(".option-text").style.display = "none";
        document.querySelector(".help-home-content").style.display = "block";
    });
}
function goPage(pno, psize) {
    var news = document.querySelectorAll(".option-text .news");
    var num = news.length;
    var totalPage = 0; //总页数
    var pageSize = psize; //每页显示行数
    //总共分几页
    if (num / pageSize > parseInt(num / pageSize)) {
        totalPage = parseInt(num / pageSize) + 1;
    } else {
        totalPage = parseInt(num / pageSize);
    }
    var currentPage = pno; //当前页数
    var startRow = (currentPage - 1) * pageSize + 1; //开始显示的行  31
    var endRow = currentPage * pageSize; //结束显示的行   40
    endRow = endRow > num ? num : endRow;
    //遍历显示数据实现分页
    for (var i = 1; i < num + 1; i++) {
        var irow = news[i - 1];
        if (i >= startRow && i <= endRow) {
            irow.style.display = "block";
        } else {
            irow.style.display = "none";
        }
    }

    var tempStr = "";
    if (currentPage > 1) {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"/images/wap/第一页.png\" onClick=\"goPage(" + 1 + "," + psize + ")\">";
        tempStr += "<img src=\"/images/wap/上一页.png\" onClick=\"goPage(" + (currentPage - 1) + "," + psize + ")\">";
        tempStr += "</div>";
    } else {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"/images/wap/第一页.png\" >";
        tempStr += "<img src=\"/images/wap/上一页.png\" >";
        tempStr += "</div>";
    }
    if (currentPage >= 10) {
        tempStr += "<div class=\"page\" id=\"page\">";
        tempStr += "<span>" + currentPage + "</span>";
    } else {
        tempStr += "<div class=\"page\" id=\"page\">";
        tempStr += "<span>" + "0" + currentPage + "</span>";
    }
    if (totalPage >= 10) {
        tempStr += "/" + totalPage;
        tempStr += "</div>";
    } else {
        tempStr += "/0" + totalPage;
        tempStr += "</div>";
    }
    if (currentPage < totalPage) {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"/images/wap/下一页.png\" onClick=\"goPage(" + (currentPage + 1) + "," + psize + ")\">";
        tempStr += "<img src=\"/images/wap/最后一页.png\" onClick=\"goPage(" + totalPage + "," + psize + ")\">";
        tempStr += "</div>";
    } else {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"/images/wap/下一页.png\" >";
        tempStr += "<img src=\"/images/wap/最后一页.png\">";
        tempStr += "</div>";
    }

    document.getElementById("bottom").innerHTML = tempStr;
}

/***/ }),

/***/ 62:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


if (document.querySelector("#help_center_home")) {
  var helpcenter = document.querySelector(".helpcenter");
  helpcenter.onclick = function () {
    var arrows = document.querySelector(".drop-options .arrow");
    if (document.querySelector(".select-text").style.display == "none") {
      document.querySelector(".select-text").style.display = "block";
      arrows.style.transform = "rotate(135deg)";
      arrows.style.transition = "transform 0.4s";
    } else {
      document.querySelector(".select-text").style.display = "none";
      arrows.style.transform = "rotate(-45deg)";
      arrows.style.transition = "transform 0.4s";
    }
    var option_i = document.querySelectorAll(".option-i");
    var p_value = document.querySelector(".drop-options p");
    for (var i = 0; i < option_i.length; i++) {
      option_i[i].index = i;
      option_i[i].addEventListener("click", function () {
        p_value.innerHTML = option_i[this.index].innerHTML;
        document.querySelector(".option-text").style.display = "block";
        document.querySelector(".help-home-content").style.display = "none";
      });
    }
    document.addEventListener("touchmove", function (e) {
      if (e.target == document.querySelector(".drop-options p") || e.target == document.querySelector(".select-text")) {
        document.querySelector(".select-text").style.display = "block";
        document.querySelector(".drop-options .arrow").style.transform = "rotate(135deg)";
        document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
      } else {
        document.querySelector(".select-text").style.display = "none";
        document.querySelector(".drop-options .arrow").style.transform = "rotate(-45deg)";
        document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
      }
    });
  };
  if (document.querySelector("#help-p")) {
    goPage(1, 8);
  }
}

/***/ }),

/***/ 63:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// 新闻公告分页
if (document.querySelector("#company_news")) {
    goPage(1, 10);
}
// 新闻公告分页
function goPage(pno, psize) {
    var news = document.querySelectorAll(".option-text .news");
    var num = news.length;
    var totalPage = 0; //总页数
    var pageSize = psize; //每页显示行数
    //总共分几页
    if (num / pageSize > parseInt(num / pageSize)) {
        totalPage = parseInt(num / pageSize) + 1;
    } else {
        totalPage = parseInt(num / pageSize);
    }
    var currentPage = pno; //当前页数
    var startRow = (currentPage - 1) * pageSize + 1; //开始显示的行  31
    var endRow = currentPage * pageSize; //结束显示的行   40
    endRow = endRow > num ? num : endRow;
    //遍历显示数据实现分页
    for (var i = 1; i < num + 1; i++) {
        var irow = news[i - 1];
        if (i >= startRow && i <= endRow) {
            irow.style.display = "block";
        } else {
            irow.style.display = "none";
        }
    }

    var tempStr = "";
    if (currentPage > 1) {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"/images/wap/第一页.png\" onClick=\"goPage(" + 1 + "," + psize + ")\">";
        tempStr += "<img src=\"/images/wap/上一页.png\" onClick=\"goPage(" + (currentPage - 1) + "," + psize + ")\">";
        tempStr += "</div>";
    } else {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"/images/wap/第一页.png\" >";
        tempStr += "<img src=\"/images/wap/上一页.png\" >";
        tempStr += "</div>";
    }
    if (currentPage >= 10) {
        tempStr += "<div class=\"page\" id=\"page\">";
        tempStr += "<span>" + currentPage + "</span>";
    } else {
        tempStr += "<div class=\"page\" id=\"page\">";
        tempStr += "<span>" + "0" + currentPage + "</span>";
    }
    if (totalPage >= 10) {
        tempStr += "/" + totalPage;
        tempStr += "</div>";
    } else {
        tempStr += "/0" + totalPage;
        tempStr += "</div>";
    }
    if (currentPage < totalPage) {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"/images/wap/下一页.png\" onClick=\"goPage(" + (currentPage + 1) + "," + psize + ")\">";
        tempStr += "<img src=\"/images/wap/最后一页.png\" onClick=\"goPage(" + totalPage + "," + psize + ")\">";
        tempStr += "</div>";
    } else {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"/images/wap/下一页.png\" >";
        tempStr += "<img src=\"/images/wap/最后一页.png\">";
        tempStr += "</div>";
    }

    document.getElementById("bottom").innerHTML = tempStr;
}

/***/ })

/******/ });