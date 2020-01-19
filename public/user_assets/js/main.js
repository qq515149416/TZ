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


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var Search = function () {
    function Search() {
        _classCallCheck(this, Search);
    }

    _createClass(Search, null, [{
        key: 'createInstantiate',
        value: function createInstantiate() {
            if (!Search.instantiate) {
                Search.instantiate = new Search();
            }
            return Search.instantiate;
        }
    }]);

    return Search;
}();

var ShowInfo = function () {
    function ShowInfo(url) {
        var _this = this;

        var param = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

        _classCallCheck(this, ShowInfo);

        this.getData(url, param, function (data) {
            Object.assign(_this, data);
            _this.start();
        });
    }

    _createClass(ShowInfo, [{
        key: 'ready',
        value: function ready(callbrak) {
            var _this2 = this;

            if (!this.start) {
                this.start = function () {
                    callbrak.call(_this2);
                    // callbrak();
                };
            } else {
                callbrak.call(this);
            }
        }
    }, {
        key: 'intoHTML',
        value: function intoHTML(selector, template) {
            $(selector).html(template);
        }
    }, {
        key: 'getData',
        value: function getData(url) {
            var param = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
            var callbark = arguments[2];

            $.get(url, param, function (data) {
                if (data.code === 1) {
                    callbark(data.data);
                }
            });
        }
    }], [{
        key: 'createInstantiate',
        value: function createInstantiate(url) {
            var param = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

            if (!ShowInfo.instantiate) {
                ShowInfo.instantiate = new ShowInfo(url, param);
            }
            return ShowInfo.instantiate;
        }
    }]);

    return ShowInfo;
}();

$(function () {
    // $(".main-nav li.nav-item:eq(3) .card").hide();
    $(".main-nav li.nav-item").mouseenter(function () {
        $(this).find(".card").fadeIn(500);
    }).mouseleave(function () {
        $(this).find(".card").fadeOut(500);
    });
    if ($("#server").length) {
        $.fn.bootstrapTable.locales['zh-CN']["formatShowingRows"] = function () {
            return '\n                <div class="bs-checkbox">\n                    <label class="my-0">\n                        <input type="checkbox" name="btSelectAll" onchange="tableSelectAll()" />\n                        <span></span>\n                    </label>\n                </div>\n                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#renewModal">\u7EED\u8D39</button>\n            ';
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
    $('#payDate').datetimepicker({
        format: 'yyyy-mm-dd',
        language: "zh-CN",
        minView: 2,
        // autoclose: true,
        todayBtn: "linked",
        forceParse: false
    });
    $('#orderDate').datetimepicker({
        format: 'yyyy-mm-dd',
        language: "zh-CN",
        minView: 2,
        // autoclose: true,
        todayBtn: "linked",
        forceParse: false
    });
    $("#server #table_data").on("check-all.bs.table", function () {
        $("#table_data").data("isCheckAll", true);
        if (!$(".pagination-detail input[name='btSelectAll']:checked").length) {
            $(".pagination-detail input[name='btSelectAll']").prop("checked", true);
        }
    });
    $("#server #table_data").on("uncheck-all.bs.table", function () {
        $("#table_data").data("isCheckAll", false);
        // console.log($(".pagination-detail input[name='btSelectAll']"));
        if ($(".pagination-detail input[name='btSelectAll']:checked").length) {
            $(".pagination-detail input[name='btSelectAll']").prop("checked", false);
        }
    });

    var showInfo = ShowInfo.createInstantiate("/home/user/userSituation");
    showInfo.ready(function () {
        this.intoHTML("#user_admin .global-balance", this.user.money);
        var cert = this.user.email && this.user.msg_phone && this.user.msg_qq;
        this.intoHTML("#index .user-info h5", this.user.nickname + '<span class="font-medium status badge badge-light ml-2">' + (cert ? '已认证' : '未认证') + '</span>');
        this.intoHTML("#index .user-info p:eq(0)", '账号：' + this.user.name);
        this.intoHTML("#index .user-info p:eq(1)", '联系电话：' + this.user.msg_phone);
        this.intoHTML("#index .balance", this.user.money);
        this.intoHTML("#index .user-mailbox span:eq(0)", '常用邮箱&nbsp;&nbsp;' + this.user.email);
        this.intoHTML("#index .user-mailbox span:eq(1)", this.user.email ? '已绑定' : '未绑定');
        this.intoHTML("#index .user-phone span:eq(0)", '手机号码&nbsp;&nbsp;' + this.user.msg_phone);
        this.intoHTML("#index .user-phone span:eq(1)", this.user.msg_phone ? '已绑定' : '未绑定');
        this.intoHTML("#index .user-qq span:eq(0)", 'QQ号码&nbsp;&nbsp;' + this.user.msg_qq);
        this.intoHTML("#index .user-qq span:eq(1)", this.user.msg_qq ? '已绑定' : '未绑定');
        this.intoHTML("#index .sales-name", this.sales.sale_name);
        this.intoHTML("#index .sales-qq", 'QQ号码&nbsp;&nbsp;' + this.sales.QQ);
        this.intoHTML("#index .sales-phone", '手机号码&nbsp;&nbsp;' + this.sales.phone);
        this.intoHTML("#index .idc-status span:eq(0)", '运行中：' + this.idc.use);
        this.intoHTML("#index .idc-status span:eq(1)", '需续费：' + this.idc.renew);
        this.intoHTML("#index .dip-status span:eq(0)", '运行中：' + this.dip.use);
        this.intoHTML("#index .dip-status span:eq(1)", '需续费：' + this.dip.renew);
    });

    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        if ($(e.target).attr("data-filter") != "all") {
            $($(e.target).attr("href")).find("#table_data").bootstrapTable("filterBy", {
                machineroom_name: $(e.target).attr("data-filter")
            });
        } else {
            $($(e.target).attr("href")).find("#table_data").bootstrapTable("filterBy", {});
        }
    });
    $(".toolbar button[type='button']").click(function () {
        $(this).addClass("active").siblings().removeClass("active");
        if ($(this).attr("data-filter") != "all") {
            $("#" + $(this).attr("data-from")).find("#table_data").bootstrapTable("filterBy", {
                endding_time: $(this).attr("data-filter")
            }, {
                filterAlgorithm: function filterAlgorithm(row, filters) {
                    // console.log(row,filters);
                    var now = Math.round(new Date().getTime() / 1000);
                    var near = filters.endding_time * 24 * 60 * 60;
                    var expire = Math.round(new Date(row.endding_time).getTime() / 1000);
                    if (expire - near <= now && expire > now) {
                        return true;
                    }
                    return false;
                }
            });
        } else {
            $("#" + $(this).attr("data-from")).find("#table_data").bootstrapTable("filterBy", {}, {
                filterAlgorithm: 'and'
            });
        }
    });
    $(".toolbar button[type='submit']").parent().submit(function () {
        console.log($("#" + $(this).attr("data-from")).find("#inputSearch"));
        if ($("#" + $(this).attr("data-from")).find("#inputSearch").val()) {
            $("#" + $(this).attr("data-from")).find("#table_data").bootstrapTable("filterBy", {
                ip: $("#" + $(this).attr("data-from")).find("#inputSearch").val(),
                machine_number: $("#" + $(this).attr("data-from")).find("#inputSearch").val()
            }, {
                filterAlgorithm: 'or'
            });
        } else {
            $("#" + $(this).attr("data-from")).find("#table_data").bootstrapTable("filterBy", {}, {
                filterAlgorithm: 'and'
            });
        }
        return false;
    });
    // $("#renewModal select[name='business']").UCFormSelect();
    $("#rechargeModal").on("shown.bs.modal", function (e) {
        var self = this;
        $(self).data("pay_type", $(this).find(".select-type-pay > ul > li.active").attr("data-type"));
        showInfo.ready(function () {
            this.intoHTML("#rechargeModal .recharge-item:eq(0) .recharge-value", '<strong class="mr-1">' + this.user.money + '</strong>元');
        });
        $(this).find(".select-type-pay > ul > li").click(function () {
            $(this).addClass("active").siblings().removeClass("active");
            $(self).data("pay_type", $(this).attr("data-type"));
        });
        $(this).find("#rechargePost").off("click");
        $(this).find("#rechargePost").click(function () {
            if ($(self).data("pay_type") == "alipay") {
                $.get("/home/recharge/payIndex", {
                    pay_for: 1,
                    total_amount: $(self).find(".recharge-item:eq(1) .recharge-value input").val(),
                    subject: '在线充值',
                    trade_no: Math.ceil(100 + Math.random() * 1000)
                }, function (data) {
                    if (data.code == 1) {
                        location.href = "/home/recharge/goToPay?trade_id=" + data.data + "&way=web";
                    } else {
                        alert(data.msg);
                    }
                });
            } else {
                $.get("/home/recharge/rechargeByWechat", {
                    pay_for: 1,
                    total_amount: $(self).find(".recharge-item:eq(1) .recharge-value input").val(),
                    subject: '在线充值',
                    trade_no: Math.ceil(100 + Math.random() * 1000)
                }, function (data) {
                    if (data.code == 1) {
                        new QRCode($(self).find("#weixin_pay")[0], data.data);
                        $(self).find(".alert").show(500);
                    }
                });
            }
        });
    });
    $("#payModal").on("shown.bs.modal", function (e) {
        var self = this;
        $(self).find("select[name='business']").UCFormSelect();
        showInfo.ready(function () {
            this.intoHTML("#payModal .balance .amount", this.user.money + "&nbsp;元");
        });
        $(self).find("#postPay").click(function () {
            $.post("/home/customer/payOrderByBalance", {
                order_id: $(self).find("select[name='business'] option:selected").map(function () {
                    var data = JSON.parse($(this).val());
                    return data.id;
                }).toArray()
            }, function (data) {
                alert(data.msg);
                if (data.code == 1) {
                    $(self).modal('hide');
                }
            });
        });
        $.get("/home/customer/orderList", {
            business_sn: $(e.relatedTarget).attr("data-business"),
            status: 0
        }, function (data) {
            if (data.code == 1) {
                var option = data.data.map(function (item) {
                    return "<option value='" + JSON.stringify(item) + "' >" + item.resource + "</option>";
                }).join("");
                $(self).find("select[name='business']").empty().html(option);
                $(self).find("select[name='business']").on("change", function () {
                    var price = 0;
                    $(this).find("option:selected").each(function () {
                        var data = JSON.parse($(this).val());
                        price += Number(data.payable_money);
                        // console.log(price);
                    });
                    $(self).find(".price .amount").html(price);
                });
                $(self).find("select[name='business']").UCFormSelect("destroy");
                $(self).find("select[name='business']").UCFormSelect();
            }
        });
    });
    $("#renewModal").on("shown.bs.modal", function (e) {
        var self = this;
        $(self).find("select[name='business']").UCFormSelect();
        $(self).find("#postRenew").off("click");
        $(self).find(".duration-select-btn").off("click");
        var business = [];
        if (!$(e.relatedTarget).attr("data-more")) {
            business = $("#table_data").bootstrapTable("getAllSelections");
        } else {
            business = [JSON.parse($(e.relatedTarget).attr("data-more"))];
        }
        console.log(business);
        $.get("/home/customer/new_all_renew", {
            business_id: business.map(function (item) {
                return item.id;
            })
        }, function (data) {
            if (data.code == 1) {
                var price = 0;
                var option = ["<optgroup label='IP'>" + data.data.IP.map(function (item) {
                    return "<option value='" + JSON.stringify(item) + "' >" + item.machine_sn + ": " + item.resource + "</option>";
                }).join("") + "</optgroup>", "<optgroup label='CPU'>" + data.data.cpu.map(function (item) {
                    return "<option value='" + JSON.stringify(item) + "' >" + item.machine_sn + ": " + item.resource + "</option>";
                }).join("") + "</optgroup>", "<optgroup label='硬盘'>" + data.data.harddisk.map(function (item) {
                    return "<option value='" + JSON.stringify(item) + "' >" + item.machine_sn + ": " + item.resource + "</option>";
                }).join("") + "</optgroup>", "<optgroup label='内存'>" + data.data.memory.map(function (item) {
                    return "<option value='" + JSON.stringify(item) + "' >" + item.machine_sn + ": " + item.resource + "</option>";
                }).join("") + "</optgroup>", "<optgroup label='带宽'>" + data.data.bandwidth.map(function (item) {
                    return "<option value='" + JSON.stringify(item) + "' >" + item.machine_sn + ": " + item.resource + "</option>";
                }).join("") + "</optgroup>", "<optgroup label='防御'>" + data.data.protected.map(function (item) {
                    return "<option value='" + JSON.stringify(item) + "' >" + item.machine_sn + ": " + item.resource + "</option>";
                }).join("") + "</optgroup>"];
                $(self).find("select[name='business']").empty();
                business.forEach(function (item) {
                    $(self).find("select[name='business']").append("<option value='" + JSON.stringify(item) + "' disabled selected>" + item.business_type + "-" + item.business_number + "</option>");
                });
                $(self).find("select[name='business']").append(option.join(""));
                $(self).find("select[name='business']").UCFormSelect("destroy");
                $(self).find("select[name='business']").UCFormSelect();
                showInfo.ready(function () {
                    this.intoHTML("#renewModal .balance .amount", this.user.money + "&nbsp;元");
                });
                price = JSON.parse($(self).find("select[name='business'] option:selected").val()).money;
                $(self).find(".price .amount").html(price * $(self).find(".duration-select-btn").attr("data-month"));
                $(self).find("select[name='business']").on("change", function () {
                    $(this).find("option:selected").each(function () {
                        var data = JSON.parse($(this).val());
                        price += Number(data.price || data.money);
                        // console.log(price);
                    });
                    $(self).find(".price .amount").html(price * $(self).find(".duration-select-btn").attr("data-month"));
                });

                $(self).find(".duration-select-btn").click(function () {
                    $(this).addClass("active").siblings().removeClass("active");
                    $(self).find(".price .amount").html(price * $(this).attr("data-month"));
                });

                $(self).find("#postRenew").click(function () {
                    // console.log({
                    //     business_number: $(e.relatedTarget).attr("data-bn"),
                    //     price: business.money,
                    //     length: $(self).find(".duration-select-btn.active").attr("data-month"),
                    //     resource_type: business.type,
                    //     orders: $(self).find("select[name='business'] option:selected").filter(function() {
                    //         return JSON.parse($(this).val()).order_sn
                    //     }).map(function() {
                    //         return JSON.parse($(this).val()).order_sn
                    //     }).toArray()
                    // })
                    $.post("/home/customer/newrenew", {
                        resource: $(self).find("select[name='business'] option:selected").map(function () {
                            var result = JSON.parse($(this).val());
                            return {
                                id: result.id,
                                resource_type: result.resource_type || result.type,
                                price: result.price || result.money
                            };
                        }).toArray(),
                        length: $(self).find(".duration-select-btn.active").attr("data-month")
                    }, function (data) {
                        alert(data.msg);
                        if (data.code == 1) {
                            $(self).modal('hide');
                            location.href = '/dist/highDefensePay.html?session_id=' + data.data;
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
    return '<span class="play mr-2" data-toggle="modal" data-target="#payModal" data-business="' + row.business_number + '">支付</span>\
    <span class="renew mr-2" data-toggle="modal" data-target="#renewModal" data-more=\'' + JSON.stringify(row) + '\' data-bn="' + row.business_number + '">续费</span>\
    <a class="view" href="/user/detail">查看</a>';
};
window.showFormatter = function (value, row) {
    return '<span class="view" data-order-sn="' + row.order_sn + '">查看</span>';
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