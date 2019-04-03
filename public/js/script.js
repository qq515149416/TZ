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
/******/ 	return __webpack_require__(__webpack_require__.s = 46);
/******/ })
/************************************************************************/
/******/ ({

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(47);


/***/ }),

/***/ 47:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


window.onscroll = function () {
  if ($(document).scrollTop() > 82) {
    // console.log($(document).scrollTop());
    $(".tz-main-head").css({
      "background-color": " rgba(16, 21, 44, 1)"
    });
  } else {
    $(".tz-main-head").css({
      "background-color": " rgba(16, 21, 44, 0)"
    });
  }
};
$(function () {
  if ($(document).scrollTop() > 82) {
    console.log($(document).scrollTop());
    $(".tz-main-head").css({
      "background-color": " rgba(16, 21, 44, 1)"
    });
  } else {
    $(".tz-main-head").css({
      "background-color": " rgba(16, 21, 44, 0)"
    });
  }
  $(".tz-main-head").hover(function () {
    if ($(document).scrollTop() > 82) {
      return;
    }
    $(".tz-main-head").css({
      "background-color": " rgba(16, 21, 44, .5)"
    });
  }, function () {
    if ($(document).scrollTop() > 82) {
      return;
    }
    $(".tz-main-head").css({
      "background-color": " rgba(16, 21, 44, 0)"
    });
  });
  $(".service-item").each(function (i) {
    if (i != 0) {
      var item = $(this);
      $(this).find(".body .option-btn").click(function () {
        if ($(this).attr("data-disabled") == "false") {
          return;
        }
        $(item).find(".body .mark").slideDown();
        if (i == 1) {
          $(item).find(".body .mark h3").html("<b>" + $(this).attr("data-title") + "</b> - " + $(this).attr("data-subtitle"));
          if ($(this).attr("data-attrs")) {
            var attrData = eval($(this).attr("data-attrs"));
            $(item).find(".body .mark .info .config ul").empty();
            var domstr = "";
            attrData.forEach(function (e) {
              domstr += "<li>" + e.attr + "\uFF1A" + e.val + "</li>";
            });
            $(item).find(".body .mark .info .config ul").append(domstr);
          }
          $(item).find(".body .mark .info p").html("" + $(this).attr("data-dec"));
          if (Number($(this).attr("data-price"))) {
            $(item).find(".body .mark .unit .price").html("" + $(this).attr("data-price"));
          } else {
            $(item).find(".body .mark .unit").html("&nbsp;");
          }
          $(item).find(".body .mark a").attr("href", $(this).attr("data-url"));
        }
        if (i == 2) {
          $(item).find(".body .mark h3").html("<b>" + $(this).attr("data-title") + "</b> - " + $(this).attr("data-subtitle"));
          if ($(this).attr("data-attrs")) {
            var attrData = eval($(this).attr("data-attrs"));
            $(item).find(".body .mark .info").empty();
            if (attrData.length) {
              var domstr = "";
              attrData.forEach(function (e, i) {

                domstr += "<p>" + e.attr + "\uFF1A" + e.val + "</p>";
              });
              domstr += "<p>\u4EA7\u54C1\u8BF4\u660E\uFF1A" + $(this).attr("data-dec") + "</p>";
              $(item).find(".body .mark .info").append(domstr);
            } else {
              var domstr = "";
              domstr += "<p>" + $(this).attr("data-dec") + "</p>";
              $(item).find(".body .mark .info").append(domstr);
            }
          }
          // $(item).find(".body .mark .info p").eq(0).html(`月度总流量：${$(this).attr("data-flow")}`);
          // $(item).find(".body .mark .info p").eq(1).html(`域名数量：${$(this).attr("data-domain")}`);
          // $(item).find(".body .mark .info p").eq(2).html(`产品说明：${$(this).attr("data-dec")}`);
          if (Number($(this).attr("data-price"))) {
            $(item).find(".body .mark .unit .price").html("" + $(this).attr("data-price"));
          } else {
            $(item).find(".body .mark .unit").html("&nbsp;");
          }
          $(item).find(".body .mark a").attr("href", $(this).attr("data-url"));
        }
        $(item).find(".body .mark .backtrack").off("click");
        $(item).find(".body .mark .backtrack").click(function () {
          $(item).find(".body .mark").slideUp();
        });
      });
    }
  });
  $(".tz-kefu .tz-kefu-top").click(function () {
    $('html,body').animate({ scrollTop: 0 });
  });
  $(".navbar-nav li").hover(function () {
    $(this).find(".dropdown-mark").fadeIn(200);
  }, function () {
    $(this).find(".dropdown-mark").fadeOut(200);
  });
  // $(".tz-kefu .tz-kefu-item").mouseenter(function() {
  //     $(this).find(".tz-kefu-item-info").fadeIn();
  // });
  // $(".tz-kefu").mouseleave(function() {
  //     $(this).find(".tz-kefu-item-info").fadeOut();
  // })
  $(".tz-kefu .tz-kefu-item").hover(function () {
    $(this).find(".tz-kefu-item-info").fadeIn();
  }, function () {
    $(this).find(".tz-kefu-item-info").fadeOut();
  });
  var solutionSwiper = new Swiper('.solution-swiper.swiper-container', {
    direction: 'horizontal', // 垂直切换选项
    loop: true // 循环模式选项
  });
  $('.solution-prev').click(function () {
    solutionSwiper.slidePrev();
  });
  $('.solution-next').click(function () {
    solutionSwiper.slideNext();
  });

  $('.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    if ($(e.target).attr("href") === "#rongyu") {
      var certificateSwiper = new Swiper('.certificate-swiper.swiper-container', {
        direction: 'horizontal', // 垂直切换选项
        loop: true // 循环模式选项
      });
      $('.normal.swiper-certificate-page .glyphicon-chevron-left').click(function () {
        certificateSwiper.slidePrev();
      });
      $('.normal.swiper-certificate-page .glyphicon-chevron-right').click(function () {
        certificateSwiper.slideNext();
      });
      var longCertificateSwiper = new Swiper('.long-certificate-swiper.swiper-container', {
        direction: 'horizontal', // 垂直切换选项
        loop: true // 循环模式选项
      });
      $('.long.swiper-certificate-page .glyphicon-chevron-left').click(function () {
        longCertificateSwiper.slidePrev();
      });
      $('.long.swiper-certificate-page .glyphicon-chevron-right').click(function () {
        longCertificateSwiper.slideNext();
      });
    }
  });
  // 解决方案页面tab切换
  $('#tz-program .tab').find('a.tab-item[href="' + window.location.hash + '"]').addClass('active').tab('show').siblings().removeClass('active');
  $(window).bind('hashchange', function () {
    $('#tz-program .tab').find('a.tab-item[href="' + window.location.hash + '"]').addClass('active').tab('show').siblings().removeClass('active');
  });
  $('#tz-program a.tab-item').on('click', function (e) {
    // e.preventDefault();
    if ($(this).hasClass('active')) {
      e.preventDefault();
    } else {
      $(this).addClass('active').tab('show').siblings().removeClass('active');
    }
  });
  // 服务器托管页面collapse切换
  var $target = $('#tz-server-hosting .collapse-tab').find('a.collapse-tab-item[href="' + window.location.hash + '"]');
  $target.addClass('active').siblings().removeClass('active');
  $('#tz-server-hosting' + ' #' + $target.attr('aria-controls')).collapse('show').siblings().collapse('hide');
  $(window).bind('hashchange', function () {
    var $target = $('#tz-server-hosting .collapse-tab').find('a.collapse-tab-item[href="' + window.location.hash + '"]');
    $target.addClass('active').siblings().removeClass('active');
    $('#tz-server-hosting' + ' #' + $target.attr('aria-controls')).collapse('show').siblings().collapse('hide');
  });
  $('#tz-server-hosting a.collapse-tab-item').on('click', function (e) {
    // e.preventDefault();
    $(this).toggleClass('active').siblings().removeClass('active');
    $('#tz-server-hosting .expand-item.collapse.in').collapse('toggle').siblings().collapse('hide');
  });
});

/***/ })

/******/ });