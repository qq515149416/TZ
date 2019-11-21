//----------------解决方案轮播图
slideshow_a();
function slideshow_a() {
    var slideshowa = document.querySelector(".slideshow-a");
    var slideshowUla = document.querySelector(".slideshow-ul-a");
    var slideshowLla = document.querySelectorAll(".slideshow-li-a");
    var slideshowOla = document.querySelector(".slideshow-ol-a");
    var screenWidtha = document.documentElement.offsetWidth;
    if(!slideshowUla) {
        return ;
    }
    // slideshowUla.style.height = slideshowLla[0].offsetHeight + 'px';
    slideshowUla.style.height="202px";
    // 生成小圆点
    for (var i = 0; i < slideshowLla.length; i++) {
        var li = document.createElement('li');
        if (i == 0) {
            li.classList.add('point-active');
        }//
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
    slideshowUla.addEventListener('touchmove', touchmoveHandler);  // 持续滑动绑定的函数 touchmoveHandler
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
        if (Math.abs(dx) > screenWidtha / 3 || (dTime < 300 && Math.abs(dx) > 30)) {
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
    pointsLis[center].innerHTML= tempStr;
    function setPoint() {
        for (var i = 0; i < pointsLis.length; i++) {
            pointsLis[i].classList.remove('point-active');
            pointsLis[center].innerHTML= tempStr;
        }
        pointsLis[center].classList.add('point-active');
    }
}
