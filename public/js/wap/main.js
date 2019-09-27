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

var fuwulis = document.getElementsByClassName("fuwu-li-i");
var itemslis = document.getElementsByClassName("items-li");
var fuwuTitleImg = document.querySelectorAll(".fuwu-li .tz-main img");
var arrows = document.querySelectorAll(".fuwu-li .div-arrow .arrow");
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

// 云主机
var YunFuwuLiI = document.getElementsByClassName(" Yun-fuwu-li-i");
var YunItemsLi = document.getElementsByClassName(" Yun-items-li");
var arrow = document.querySelectorAll(".div-arrow .arrow");
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
      console.log(i);
      for (var j = 0; j < option_text_a.length; j++) {
        option_text_a[j].className = "option-text-a";
      }
      option_text_a[i].className = "option-text-a option-e-active";
    }
  }
}

// 公司简介

function machineroom() {
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
      moreContent.style.display = "none";
      document.querySelector(".select-text").style.display = "none";
      document.querySelector(".drop-options .arrow").style.transform = "rotate(-45deg)";
      document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
    }
  });
}

/***/ }),

/***/ 54:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


//----------------解决方案轮播图
slideshow_main();
function slideshow_main() {
    var slideshow = document.querySelector(".slideshow");
    var slideshowUl = document.querySelector(".slideshow-ul");
    var slideshowLl = document.querySelectorAll(".slideshow-li");
    var slideshowOl = document.querySelector(".slideshow-ol");
    var screenWidth = document.documentElement.offsetWidth;
    if (!slideshowUl) {
        return;
    }
    console.log(slideshowLl[0].offsetHeight);
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

/***/ }),

/***/ 56:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function server_room() {
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
}

/***/ }),

/***/ 57:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


//----------------解决方案轮播图
slideshow_a();
function slideshow_a() {
    var slideshow_a = document.querySelector(".slideshow-a");
    var slideshowUl_a = document.querySelector(".slideshow-ul-a");
    var slideshowLl_a = document.querySelectorAll(".slideshow-li-a");
    var slideshowOl_a = document.querySelector(".slideshow-ol-a");
    var screenWidth_a = document.documentElement.offsetWidth;
    if (!slideshowUl_a) {
        return;
    }
    // slideshowUl_a.style.height = slideshowLl_a[0].offsetHeight + 'px';
    slideshowUl_a.style.height = "202px";
    // 生成小圆点
    for (var i = 0; i < slideshowLl_a.length; i++) {
        var li = document.createElement('li');
        if (i == 0) {
            li.classList.add('point-active');
        } //
        slideshowOl_a.appendChild(li);
    }
    var left_a = slideshowLl_a.length - 1;
    var center_a = 0;
    var right_a = 1;
    setTransform_a();
    var timer_a = null;
    // 调用定时器
    timer_a = setInterval(showNext_a, 3000);
    // 分别绑定touch事件
    var startX = 0; // 手指落点
    var startTime = null; // 开始触摸时间
    slideshowUl_a.addEventListener('touchstart', touchstartHandler_a); // 滑动开始绑定的函数 touchstartHandler_a
    slideshowUl_a.addEventListener('touchmove', touchmoveHandler_a); // 持续滑动绑定的函数 touchmoveHandler_a
    slideshowUl_a.addEventListener('touchend', touchendHandeler_a);

    // 轮播图片切换
    function showNext_a() {
        // 轮转下标
        left_a = center_a;
        center_a = right_a;
        right_a++;
        // 极值判断
        if (right_a > slideshowLl_a.length - 1) {
            right_a = 0;
        }
        //添加过渡（多次使用，封装成函数）
        setTransition_a(1, 1, 0);
        setTransform_a();
        setPoint_a();
    }
    // 轮播图片切换上一张
    function showPrev_a() {
        // 轮转下标
        right_a = center_a;
        center_a = left_a;
        left_a--;
        //　极值判断
        if (left_a < 0) {
            left_a = slideshowLl_a.length - 1;
        }
        //添加过渡
        setTransition_a(0, 1, 1);
        setTransform_a();
        setPoint_a();
    }
    // 滑动开始
    function touchstartHandler_a(e) {
        clearInterval(timer_a);
        // 记录滑动开始的时间
        startTime = Date.now();
        // 记录手指最开始的落点
        startX = e.changedTouches[0].clientX;
    }
    // 滑动持续中
    function touchmoveHandler_a(e) {
        // 获取差值 自带正负
        var dx = e.changedTouches[0].clientX - startX;
        // 干掉过渡
        setTransition_a(0, 0, 0);
        // 归位
        setTransform_a(dx);
    }
    //　滑动结束
    function touchendHandeler_a(e) {
        // 在手指松开的时候，要判断当前是否滑动成功
        var dx = e.changedTouches[0].clientX - startX;
        // 获取时间差
        var dTime = Date.now() - startTime;
        // 滑动成功的依据是滑动的距离（绝对值）超过屏幕的三分之一 或者滑动的时间小于300毫秒同时滑动的距离大于30
        if (Math.abs(dx) > screenWidth_a / 3 || dTime < 300 && Math.abs(dx) > 30) {
            // 滑动成功了
            // 判断用户是往哪个方向滑
            if (dx > 0) {
                showPrev_a();
            } else {
                showNext_a();
            }
        } else {
            // 添加上过渡
            setTransition_a(1, 1, 1);
            // 滑动失败了
            setTransform_a();
        }

        // 重新启动定时器
        clearInterval(timer_a);
        // 调用定时器
        timer_a = setInterval(showNext_a, 3000);
    }
    // 设置过渡
    function setTransition_a(a, b, c) {
        if (a) {
            slideshowLl_a[left_a].style.transition = 'transform 1s';
        } else {
            slideshowLl_a[left_a].style.transition = 'none';
        }
        if (b) {
            slideshowLl_a[center_a].style.transition = 'transform 1s';
        } else {
            slideshowLl_a[center_a].style.transition = 'none';
        }
        if (c) {
            slideshowLl_a[right_a].style.transition = 'transform 1s';
        } else {
            slideshowLl_a[right_a].style.transition = 'none';
        }
    }
    //　封装归位
    function setTransform_a(dx) {
        dx = dx || 0;
        slideshowLl_a[left_a].style.transform = 'translateX(' + (-screenWidth + dx) + 'px)';
        slideshowLl_a[center_a].style.transform = 'translateX(' + dx + 'px)';
        slideshowLl_a[right_a].style.transform = 'translateX(' + (screenWidth + dx) + 'px)';
    }
    // 动态设置小圆点的active类
    var pointsLis_a = slideshowOl_a.querySelectorAll('li');
    var tempStr_a = "<span class=\"progress\"></span>";
    pointsLis_a[center_a].innerHTML = tempStr_a;
    function setPoint_a() {
        for (var i = 0; i < pointsLis_a.length; i++) {
            pointsLis_a[i].classList.remove('point-active');
            pointsLis_a[center_a].innerHTML = tempStr_a;
        }
        pointsLis_a[center_a].classList.add('point-active');
    }
}

/***/ }),

/***/ 58:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function server_h_room() {
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

/***/ })

/******/ });