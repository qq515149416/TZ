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
/******/ 	return __webpack_require__(__webpack_require__.s = 70);
/******/ })
/************************************************************************/
/******/ ({

/***/ 70:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(71);


/***/ }),

/***/ 71:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(function () {
    // $(".main-nav li.nav-item:eq(3) .card").hide();
    $(".main-nav li.nav-item").mouseenter(function () {
        $(this).find(".card").fadeIn(500);
    }).mouseleave(function () {
        $(this).find(".card").fadeOut(500);
    });
    $.get("/home/user/userSituation", function (data) {
        console.log(data);
        if (data.code === 1) {
            $("#user_admin .global-balance").html(data.data.user.money);
            var cert = data.data.user.email && data.data.user.msg_phone && data.data.user.msg_qq;
            $("#index .user-info h5").html(data.data.user.nickname + '<span class="font-medium status badge badge-light ml-2">' + (cert ? '已认证' : '未认证') + '</span>');
            $("#index .user-info p:eq(0)").html('账号：' + data.data.user.name);
            $("#index .user-info p:eq(1)").html('联系电话：' + data.data.user.msg_phone);
            $("#index .balance").html(data.data.user.money);
            $("#index .user-mailbox span:eq(0)").html('常用邮箱&nbsp;&nbsp;' + data.data.user.email);
            $("#index .user-mailbox span:eq(1)").html(data.data.user.email ? '已绑定' : '未绑定');
            $("#index .user-phone span:eq(0)").html('手机号码&nbsp;&nbsp;' + data.data.user.msg_phone);
            $("#index .user-phone span:eq(1)").html(data.data.user.msg_phone ? '已绑定' : '未绑定');
            $("#index .user-qq span:eq(0)").html('QQ号码&nbsp;&nbsp;' + data.data.user.msg_qq);
            $("#index .user-qq span:eq(1)").html(data.data.user.msg_qq ? '已绑定' : '未绑定');
            $("#index .sales-name").html(data.data.sales.sale_name);
            $("#index .sales-qq").html('QQ号码&nbsp;&nbsp;' + data.data.sales.QQ);
            $("#index .sales-phone").html('手机号码&nbsp;&nbsp;' + data.data.sales.phone);
            $("#index .idc-status span:eq(0)").html('运行中：' + data.data.idc.use);
            $("#index .idc-status span:eq(1)").html('需续费：' + data.data.idc.renew);
            $("#index .dip-status span:eq(0)").html('运行中：' + data.data.dip.use);
            $("#index .dip-status span:eq(1)").html('需续费：' + data.data.dip.renew);
            $("#renewModal .balance .amount").html(data.data.user.money + "&nbsp;元");
        }
    });
    if ($("#server").length) {
        $.fn.bootstrapTable.locales['zh-CN']["formatShowingRows"] = function () {
            return '\n                <div class="bs-checkbox">\n                    <label class="my-0">\n                        <input type="checkbox" name="btSelectAll" onchange="tableSelectAll()" />\n                        <span></span>\n                    </label>\n                </div>\n                <button type="button" class="btn btn-primary">\u7EED\u8D39</button>\n            ';
        };
        $.fn.bootstrapTable.locales['zh-CN']["formatRecordsPerPage"] = function () {
            return "";
        };
    } else {
        $.fn.bootstrapTable.locales['zh-CN']["formatShowingRows"] = function () {
            return "";
        };
        $.fn.bootstrapTable.locales['zh-CN']["formatRecordsPerPage"] = function () {
            return "";
        };
    }

    $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales['zh-CN']);
    $("#server #table_data").on("check-all.bs.table", function () {
        $("#table_data").data("isCheckAll", true);
        if (!$(".pagination-detail input[name='btSelectAll']:checked").length) {
            $(".pagination-detail input[name='btSelectAll']").prop("checked", true);
        }
    });
    $("#table_data").on("uncheck-all.bs.table", function () {
        $("#table_data").data("isCheckAll", false);
        // console.log($(".pagination-detail input[name='btSelectAll']"));
        if ($(".pagination-detail input[name='btSelectAll']:checked").length) {
            $(".pagination-detail input[name='btSelectAll']").prop("checked", false);
        }
    });
    // $("#renewModal select[name='business']").UCFormSelect();
    $("#renewModal").on("shown.bs.modal", function (e) {
        var self = this;
        $(self).find("select[name='business']").UCFormSelect();
        $.get("/home/customer/all_renew", {
            business_sn: $(e.relatedTarget).attr("data-bn")
        }, function (data) {
            if (data.code == 1) {
                var price = 0;
                console.log($(e.relatedTarget).attr("data-more"));
                var business = JSON.parse($(e.relatedTarget).attr("data-more"));
                var option = ["<optgroup label='IP'>" + data.data.IP.map(function (item) {
                    return "<option value='" + JSON.stringify(item) + "' >" + item.resource + "</option>";
                }).join("") + "</optgroup>"];
                $(self).find("select[name='business']").empty().html("<option value='" + JSON.stringify(business) + "' disabled selected>" + business.business_type + "-" + business.business_number + "</option>" + option.join(""));
                $(self).find("select[name='business']").UCFormSelect("destroy");
                $(self).find("select[name='business']").UCFormSelect();
                price = JSON.parse($(self).find("select[name='business'] option:selected").val()).money;
                $(self).find(".price .amount").html(price * 6);
                $(self).find("select[name='business']").on("change", function () {
                    $(this).find("option:selected").each(function () {
                        var data = JSON.parse($(this).val());
                        price += Number(data.price || data.money);
                        // console.log(price);
                    });
                    $(self).find(".price .amount").html(price * 6);
                });
                $(self).find(".duration-select-btn").click(function () {
                    $(this).addClass("active").siblings().removeClass("active");
                    $(self).find(".price .amount").html(price * $(this).attr("data-month"));
                });
                $(self).find("#postRenew").click(function () {
                    console.log({
                        business_number: $(e.relatedTarget).attr("data-bn"),
                        price: business.money,
                        length: $(self).find(".duration-select-btn.active").attr("data-month"),
                        resource_type: business.type,
                        orders: $(self).find("select[name='business'] option:selected").filter(function () {
                            return JSON.parse($(this).val()).order_sn;
                        }).map(function () {
                            return JSON.parse($(this).val()).order_sn;
                        }).toArray()
                    });
                    $.post("/home/customer/renewresource", {
                        business_number: $(e.relatedTarget).attr("data-bn"),
                        price: business.money,
                        length: $(self).find(".duration-select-btn.active").attr("data-month"),
                        resource_type: business.type,
                        orders: $(self).find("select[name='business'] option:selected").filter(function () {
                            return JSON.parse($(this).val()).order_sn;
                        }).map(function () {
                            return JSON.parse($(this).val()).order_sn;
                        }).toArray()
                    }, function (data) {
                        alert(data.msg);
                        if (data.code == 1) {
                            $(self).modal('hide');
                        }
                    });
                });
            }
        });
    });
    // $("#server #table_data").bootstrapTable({

    // });
    // $(".main-content .top-nav li a").click(function() {
    //     $(".main-content .top-nav li a").removeClass("active");
    //     $(this).addClass("active");
    // })
});

window.tableSelectAll = function () {
    if (!$("#table_data").data("isCheckAll")) {
        $("#table_data").bootstrapTable("checkAll");
        $("#table_data").data("isCheckAll", true);
    } else {
        $("#table_data").bootstrapTable("uncheckAll");
        $("#table_data").data("isCheckAll", false);
    }
};
window.ipFormatter = function (value, row) {
    var detail = JSON.parse(row.resource_detail);
    return detail.ip;
};
window.bandwidthFormatter = function (value, row) {
    var detail = JSON.parse(row.resource_detail);
    return detail.bandwidth;
};
window.protectFormatter = function (value, row) {
    var detail = JSON.parse(row.resource_detail);
    return detail.protect;
};
window.resourceDetailFormatter = function (value, row) {
    var detail = JSON.parse(value);
    return "CPU:" + detail.cpu + "&nbsp;&nbsp;内存：" + detail.memory;
};
window.harddiskFormatter = function (value, row) {
    var detail = JSON.parse(row.resource_detail);
    return detail.harddisk;
};
window.createdAtFormatter = function (value, row) {
    var detail = JSON.parse(row.resource_detail);
    return detail.created_at;
};
window.operatFormatter = function (value, row) {
    return '<span class="play mr-2">支付</span>\
    <span class="renew mr-2" data-toggle="modal" data-target="#renewModal" data-more=\'' + JSON.stringify(row) + '\' data-bn="' + row.business_number + '">续费</span>\
    <a class="view" href="/user/detail">查看</a>';
};
window.process_data = function (res) {
    if (res.code == 1) {
        return res.data;
    } else {
        return [];
    }
};
window.rowStyle = function (row, index) {
    return {
        classes: "font-regular"
    };
};

/***/ })

/******/ });