//----------------解决方案轮播图
if(document.querySelector("#mobileapp_solution") || document.querySelector("#chess_solution") || document.querySelector("#cabinet_to_rent") || document.querySelector("#home") || document.querySelector("#bandwidth_to_ent") || document.querySelector("#server_hosting") || document.querySelector("#DDOS_high_security_IP3") || document.querySelector("#high_proof_host") || document.querySelector("#cloud_hosting") || document.querySelector("#C_shield") || document.querySelector("#server_hire")) {
  slideshow_main("slideshow");
}
if(document.querySelector("#CDN_speed_up")) {
  slideshow_main("slideshow");
slideshow_main("slideshow-a");
slideshow_main("slideshow-b");
slideshow_main("slideshow-c");
slideshow_main("slideshow-d");
}
function slideshow_main(id) {
    // var slideshow = document.getElementById(id).querySelector(".slideshow");
    var slideshowUl = document.getElementById(id).querySelector(".slideshow-ul");
    var slideshowLl = document.getElementById(id).querySelectorAll(".slideshow-li");
    var slideshowOl = document.getElementById(id).querySelector(".slideshow-ol");
    var screenWidth = document.documentElement.offsetWidth;
    if(!slideshowUl) {
        return ;
    }
    // console.log(slideshowLl[0].offsetHeight);
    slideshowUl.style.height = slideshowLl[0].offsetHeight + 'px';
    // slideshowUl.style.height="141px";
    // 生成小圆点
    for (var i = 0; i < slideshowLl.length; i++) {
        var li = document.createElement('li');
        if (i == 0) {
            li.classList.add('point-active');
        }//
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
    slideshowUl.addEventListener('touchmove', touchmoveHandler);  // 持续滑动绑定的函数 touchmoveHandler
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
        if (Math.abs(dx) > screenWidth / 3 || (dTime < 300 && Math.abs(dx) > 30)) {
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
    pointsLis[center].innerHTML= tempStr;
    function setPoint() {
        for (var i = 0; i < pointsLis.length; i++) {
            pointsLis[i].classList.remove('point-active');
            pointsLis[center].innerHTML= tempStr;
        }
        pointsLis[center].classList.add('point-active');
    }
}
