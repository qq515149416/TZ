import "./article";

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
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
}
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
            if($(this).attr("data-url")) {
                location.href = $(this).attr("data-url");
            }
          return;
        }
        $(item).find(".body .mark").slideDown();
        if (i == 1) {
          $(item).find(".body .mark h3").html(`<b>${$(this).attr("data-title")}</b> - ${$(this).attr("data-subtitle")}`);
          if ($(this).attr("data-attrs")) {
            var attrData = eval($(this).attr("data-attrs"));
            $(item).find(".body .mark .info .config ul").empty();
            var domstr = "";
            attrData.forEach(function (e) {
              domstr += `<li>${e.attr}：${e.val}</li>`;
            });
            $(item).find(".body .mark .info .config ul").append(domstr);
          }
          $(item).find(".body .mark .info p").html(`${$(this).attr("data-dec")}`);
          if (Number($(this).attr("data-price"))) {
            $(item).find(".body .mark .unit .price").html(`${$(this).attr("data-price")}`);
          } else {
            $(item).find(".body .mark .unit").html("&nbsp;");
          }
          $(item).find(".body .mark a").attr("href", $(this).attr("data-url"));
        }
        if (i == 2) {
          $(item).find(".body .mark h3").html(`<b>${$(this).attr("data-title")}</b> - ${$(this).attr("data-subtitle")}`);
          if ($(this).attr("data-attrs")) {
            var attrData = eval($(this).attr("data-attrs"));
            $(item).find(".body .mark .info").empty();
            if (attrData.length) {
              var domstr = "";
              attrData.forEach(function (e, i) {

                domstr += `<p>${e.attr}：${e.val}</p>`;
              });
              domstr += `<p>产品说明：${$(this).attr("data-dec")}</p>`
              $(item).find(".body .mark .info").append(domstr);
            } else {
              var domstr = "";
              domstr += `<p>${$(this).attr("data-dec")}</p>`
              $(item).find(".body .mark .info").append(domstr);
            }
          }
          // $(item).find(".body .mark .info p").eq(0).html(`月度总流量：${$(this).attr("data-flow")}`);
          // $(item).find(".body .mark .info p").eq(1).html(`域名数量：${$(this).attr("data-domain")}`);
          // $(item).find(".body .mark .info p").eq(2).html(`产品说明：${$(this).attr("data-dec")}`);
          if (Number($(this).attr("data-price"))) {
            $(item).find(".body .mark .unit .price").html(`${$(this).attr("data-price")}`);
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
    } else {
        var item = $(this);
        console.log(item.find(".body .option-btn"));
        item.find(".body .option-btn").click(function () {
            if($(this).attr("data-url")) {
                location.href = $(this).attr("data-url");
            }
        });
    }
  });
  $(".tz-kefu .tz-kefu-top").click(function () {
    $('html,body').animate({scrollTop: 0});
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
      $('.normal.swiper-certificate-page .glyphicon-chevron-left').off("click").click(function () {
        certificateSwiper.slidePrev();
      });
      $('.normal.swiper-certificate-page .glyphicon-chevron-right').off("click").click(function () {
        certificateSwiper.slideNext();
      });
      var longCertificateSwiper = new Swiper('.long-certificate-swiper.swiper-container', {
        direction: 'horizontal', // 垂直切换选项
        loop: true // 循环模式选项
      });
      $('.long.swiper-certificate-page .glyphicon-chevron-left').off("click").click(function () {
        longCertificateSwiper.slidePrev();
      });
      $('.long.swiper-certificate-page .glyphicon-chevron-right').off("click").click(function () {
        longCertificateSwiper.slideNext();
      });
    }
  });
  if(location.href.indexOf("aboutus/rongyu") > -1) {
      var certificateSwiper = new Swiper('.certificate-swiper.swiper-container', {
        direction: 'horizontal', // 垂直切换选项
        loop: true // 循环模式选项
      });
      $('.normal.swiper-certificate-page .glyphicon-chevron-left').off("click");
      $('.normal.swiper-certificate-page .glyphicon-chevron-left').click(function () {
        certificateSwiper.slidePrev();
      });
      $('.normal.swiper-certificate-page .glyphicon-chevron-right').off("click");
      $('.normal.swiper-certificate-page .glyphicon-chevron-right').click(function () {
        certificateSwiper.slideNext();
      });
      var longCertificateSwiper = new Swiper('.long-certificate-swiper.swiper-container', {
        direction: 'horizontal', // 垂直切换选项
        loop: true // 循环模式选项
      });
      $('.long.swiper-certificate-page .glyphicon-chevron-left').off("click");
      $('.long.swiper-certificate-page .glyphicon-chevron-left').click(function () {
        longCertificateSwiper.slidePrev();
      });
      $('.long.swiper-certificate-page .glyphicon-chevron-right').off("click");
      $('.long.swiper-certificate-page .glyphicon-chevron-right').click(function () {
        longCertificateSwiper.slideNext();
      });
  }
//   叠加包购买
$("#buyOverlayPackage").on("shown.bs.modal",function(e) {
    var showInfo = '';
    showInfo += '<p>名称：'+$(e.relatedTarget).attr("data-name")+'</p>';
    showInfo += '<p>天数：'+$(e.relatedTarget).attr("data-time")+'</p>';
    showInfo += '<p>价格：'+$(e.relatedTarget).attr("data-price")+'</p>';
    $(this).find(".show-info").empty().append(showInfo);
    var post_id = $(e.relatedTarget).attr("data-id");
    var oBuy_num = $(this).find("#buy_num");
    $(this).find(".buy").off("click");
    $(this).find(".buy").click(function() {
        if(!oBuy_num.val()) {
            alert("数量不能为空");
            return ;
        }
        $.post("/home/overlay/buyNowByCustomer",{
            overlay_id: post_id,
            buy_num: oBuy_num.val()
        },function(data) {
            if(data.code==1) {
                $('#buyOverlayPackage').modal('hide');
                location.href = location.protocol+"//"+location.hostname+"/tz/member92019.html#/userOverlayPackage";
            }
            alert(data.msg);
        });
    });
});
  /**
   * 服务器托管页面collapse切换
   */
  $('#tz-server-hosting .expand-item.collapse')
      .on('show.bs.collapse', function () {
        $('#tz-server-hosting .collapse-tab').find('a.' + $(this).attr('id')).addClass('active').siblings().removeClass('active');
      })
      .on('hidden.bs.collapse', function () {
        $('#tz-server-hosting .collapse-tab').find('a.' + $(this).attr('id')).removeClass('active');
      });
  let $target = $('#tz-server-hosting .collapse-tab').find('a.collapse-tab-item[href="' + window.location.hash + '"]');
  $target.addClass('active').siblings().removeClass('active');
  $('#tz-server-hosting' + ' #' + $target.attr('aria-controls')).collapse('show').siblings().collapse('hide');
  $(window).bind('hashchange', function () {
    let $target = $('#tz-server-hosting .collapse-tab').find('a.collapse-tab-item[href="' + window.location.hash + '"]');
    $target.addClass('active').siblings().removeClass('active');
    $('#tz-server-hosting' + ' #' + $target.attr('aria-controls')).collapse('show').siblings().collapse('hide');
  });
  $('#tz-server-hosting a.collapse-tab-item').on('click', function (e) {
    // e.preventDefault();
    // $(this).toggleClass('active').siblings().removeClass('active');
    $('#tz-server-hosting .expand-item.collapse.in').collapse('toggle').siblings().collapse('hide');
  });
  /**
   * 安全防护主页-产品矩阵的hover效果
   */
  $('#tz-protection .product-matrix .item').on('mouseover', function (e) {
    let $parent = $(this).parent('.item-group');
    $parent.find('.item-group-title').css('color', '#2139b7');
    $parent.find('.flow-line').hide()
    $parent.find('.flow-line-hover').show();
    $parent.on('mouseleave', function (e) {
      $(this).find('.item-group-title').css('color', '#959595');
      $(this).find('.flow-line').show();
      $(this).find('.flow-line-hover').hide();
    });
  });
  /**
   * 安全防护主页-客户应用场景的tab切换
   */
  $('#protection .client-scene a.tab-item').on('click', function (e) {
    if ($(this).hasClass('active')) {
      e.preventDefault();
    } else {
      $(this).addClass('active').tab('show').siblings().removeClass('active');
    }
  });

// 数据中心机房图片
if(document.getElementById("thumbnail")) {
    var roomSwiper = new Swiper ('#thumbnail', {
        direction: 'horizontal', // 垂直切换选项
        loop: true, // 循环模式选项
        autoplay: true,
        // 如果需要分页器
        pagination: {
          el: '.swiper-pagination',
        }
      });
      //鼠标覆盖停止自动切换
      roomSwiper.el.onmouseover = function(){
        roomSwiper.autoplay.stop();
      }

      roomSwiper.el.onmouseout = function(){
        roomSwiper.autoplay.start();
      }
}
// 云的产品优势
if(document.getElementById("product")) {
    var roomSwiper = new Swiper ('#product', {
        direction: 'horizontal', // 垂直切换选项
        // loop: true, // 循环模式选项
        // 如果需要分页器
        pagination: {
          el: '.swiper-pagination',
          clickable :true
        }
    });
}

if(document.getElementById("downloadRoom")) {
    $("#downloadRoom").click(function() {
        $.get("/datacenter/json/"+$(this).attr("data-page"),function(data) {
            if(data.code==1) {
                tableToExcel([data.data]);
            }
        });
    });
}

//   高防ip购买
  $("#purchaseTime").on("shown.bs.modal",function(event) {
    let purchaseTime = $(this);
    purchaseTime.find(".btn.ok").off("click");
    purchaseTime.find(".btn.ok").click(function() {
        $.get(location.protocol+"//"+location.hostname+"/home/defenseIp/buyDefenseIpNow",{
            package_id: event.relatedTarget.dataset.id,
            buy_time: purchaseTime.find(".duration").val()
        },function(data) {
            alert(data.msg);
            if(data.code==1) {
                // console.log(data.data);
                location.href = "/dist/highDefensePay.html?orderid="+data.data;
            }
        })
    });
});
});
function tableToExcel(jsonData){
    //列标题
    let str = '<tr><td>数据中心级别</td><td>机房面积</td><td>机柜总数</td><td>出口总带宽</td><td>防火墙设备</td><td>电力设备</td><td>数据中心地址</td></tr>';
    //循环遍历，每行加入tr标签，每个单元格加td标签
    for(let i = 0 ; i < jsonData.length ; i++ ){
      str+='<tr>';
      for(let item in jsonData[i]){
          //增加\t为了不让表格显示科学计数法或者其他格式
          str+=`<td>${ jsonData[i][item] + '\t'}</td>`;
      }
      str+='</tr>';
    }
    //Worksheet名
    let worksheet = 'Sheet1'
    let uri = 'data:application/vnd.ms-excel;base64,';

    //下载的表格模板数据
    let template = `<html xmlns:o="urn:schemas-microsoft-com:office:office"
    xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">
    <head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
      <x:Name>${worksheet}</x:Name>
      <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet>
      </x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->
      </head><body><table>${str}</table></body></html>`;
    //下载模板
    window.location.href = uri + base64(template);
}
//输出base64编码
function base64 (s) { return window.btoa(unescape(encodeURIComponent(s))) }
