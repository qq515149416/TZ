//----------------解决方案轮播图
var slideshow_a = document.querySelector(".slideshow-a");
var slideshowUl_a = document.querySelector(".slideshow-ul-a");
var slideshowLl_a = document.querySelectorAll(".slideshow-li-a");
var slideshowOl_a = document.querySelector(".slideshow-ol-a");
var screenWidth_a = document.documentElement.offsetWidth;
// slideshowUl_a.style.height = slideshowLl_a[0].offsetHeight + 'px';
slideshowUl_a.style.height="202px";
// 生成小圆点
for (var i = 0; i < slideshowLl_a.length; i++) {
    var li = document.createElement('li');
    if (i == 0) {
        li.classList.add('point-active');
    }//
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
slideshowUl_a.addEventListener('touchmove', touchmoveHandler_a);  // 持续滑动绑定的函数 touchmoveHandler_a
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
    if (Math.abs(dx) > screenWidth_a / 3 || (dTime < 300 && Math.abs(dx) > 30)) {
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
pointsLis_a[center_a].innerHTML= tempStr_a;
function setPoint_a() {
    for (var i = 0; i < pointsLis_a.length; i++) {
        pointsLis_a[i].classList.remove('point-active');
        pointsLis_a[center_a].innerHTML= tempStr_a;
    }
    pointsLis_a[center_a].classList.add('point-active');
}