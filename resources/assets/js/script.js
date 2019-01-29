window.onscroll = function() {
    if($(document).scrollTop() > 82) {
        console.log($(document).scrollTop());
        $(".tz-main-head").css({
            "background-color": " rgba(16, 21, 44, 1)"
        });
    } else {
        $(".tz-main-head").css({
            "background-color": " rgba(16, 21, 44, 0)"
        });
    }
}
$(function() {
    if($(document).scrollTop() > 82) {
        console.log($(document).scrollTop());
        $(".tz-main-head").css({
            "background-color": " rgba(16, 21, 44, 1)"
        });
    } else {
        $(".tz-main-head").css({
            "background-color": " rgba(16, 21, 44, 0)"
        });
        $(".tz-main-head").hover(function() {
            $(".tz-main-head").css({
                "background-color": " rgba(16, 21, 44, .5)"
            });
        },function() {
            $(".tz-main-head").css({
                "background-color": " rgba(16, 21, 44, 0)"
            });
        });
    }
    $(".service-item").each(function(i) {
        if(i!=0) {
            var item = $(this);
            $(this).find(".body .option-btn").click(function() {
                if($(this).attr("data-disabled")=="false") {
                    return ;
                }
                $(item).find(".body .mark").slideDown();
                if(i==1) {
                    $(item).find(".body .mark h3").html(`<b>${$(this).attr("data-title")}</b> - ${$(this).attr("data-subtitle")}`);
                    if($(this).attr("data-attrs")) {
                        var attrData = eval($(this).attr("data-attrs"));
                        $(item).find(".body .mark .info .config ul").empty();
                        var domstr = "";
                        attrData.forEach(function(e) {
                            domstr += `<li>${e.attr}：${e.val}</li>`;
                        });
                        $(item).find(".body .mark .info .config ul").append(domstr);
                    }
                    $(item).find(".body .mark .info p").html(`${$(this).attr("data-dec")}`);
                    if(Number($(this).attr("data-price"))) {
                        $(item).find(".body .mark .unit .price").html(`${$(this).attr("data-price")}`);
                    } else {
                        $(item).find(".body .mark .unit").html("&nbsp;");
                    }
                    $(item).find(".body .mark a").attr("href",$(this).attr("data-url"));
                }
                if(i==2) {
                    $(item).find(".body .mark h3").html(`<b>${$(this).attr("data-title")}</b> - ${$(this).attr("data-subtitle")}`);
                    if($(this).attr("data-attrs")) {
                        var attrData = eval($(this).attr("data-attrs"));
                        $(item).find(".body .mark .info").empty();
                        if(attrData.length) {
                            var domstr = "";
                            attrData.forEach(function(e,i) {

                                domstr += `<p>${e.attr}：${e.val}</p>`;
                            });
                            domstr+=`<p>产品说明：${$(this).attr("data-dec")}</p>`
                            $(item).find(".body .mark .info").append(domstr);
                        } else {
                            var domstr = "";
                            domstr+=`<p>${$(this).attr("data-dec")}</p>`
                            $(item).find(".body .mark .info").append(domstr);
                        }
                    }
                    // $(item).find(".body .mark .info p").eq(0).html(`月度总流量：${$(this).attr("data-flow")}`);
                    // $(item).find(".body .mark .info p").eq(1).html(`域名数量：${$(this).attr("data-domain")}`);
                    // $(item).find(".body .mark .info p").eq(2).html(`产品说明：${$(this).attr("data-dec")}`);
                    if(Number($(this).attr("data-price"))) {
                        $(item).find(".body .mark .unit .price").html(`${$(this).attr("data-price")}`);
                    } else {
                        $(item).find(".body .mark .unit").html("&nbsp;");
                    }
                    $(item).find(".body .mark a").attr("href",$(this).attr("data-url"));
                }
                $(item).find(".body .mark .backtrack").off("click");
                $(item).find(".body .mark .backtrack").click(function() {
                    $(item).find(".body .mark").slideUp();
                });
            });
        }
    });
    $(".tz-kefu .tz-kefu-top").click(function() {
        $('html,body').animate({scrollTop:0});
    });
    $(".navbar-nav li").hover(function() {
        $(this).find(".dropdown-mark").fadeIn(200);
    },function() {
        $(this).find(".dropdown-mark").fadeOut(200);
    });
    // $(".tz-kefu .tz-kefu-item").mouseenter(function() {
    //     $(this).find(".tz-kefu-item-info").fadeIn();
    // });
    // $(".tz-kefu").mouseleave(function() {
    //     $(this).find(".tz-kefu-item-info").fadeOut();
    // })
    $(".tz-kefu .tz-kefu-item").hover(function() {
        $(this).find(".tz-kefu-item-info").fadeIn();
    },function() {
        $(this).find(".tz-kefu-item-info").fadeOut();
    });
    var solutionSwiper = new Swiper('.swiper-container',{
        direction: 'horizontal', // 垂直切换选项
        loop: true // 循环模式选项
    });
    $('.solution-prev').click(function(){
        solutionSwiper.slidePrev();
    });
    $('.solution-next').click(function(){
        solutionSwiper.slideNext();
    });

});