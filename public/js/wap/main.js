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
var slideshow = document.querySelector(".slideshow");
var slideshowUl = document.querySelector(".slideshow-ul");
var slideshowLl = document.querySelectorAll(".slideshow-li");
var slideshowOl = document.querySelector(".slideshow-ol");
var screenWidth = document.documentElement.offsetWidth;
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

/***/ })

/******/ });