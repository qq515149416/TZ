import createEchart from './echarts';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
class ShowInfo {
    constructor(url,param={}) {
        this.getData(url,param,(data) => {
            Object.assign(this,data);
            this.start();
        })
    }
    ready(callbrak) {
        if(!this.start) {
            this.start = () => {
                callbrak.call(this);
                // callbrak();
            }
        } else {
            callbrak.call(this);
        }
    }
    intoHTML(selector,template) {
        $(selector).html(template);
    }
    getData(url,param={},callbark) {
        $.get(url,param,function(data) {
            if(data.code===1) {
                callbark(data.data);
            }
        });
    }
    static createInstantiate(url,param={}) {
        if(!ShowInfo.instantiate) {
            ShowInfo.instantiate = new ShowInfo(url,param);
        }
        return ShowInfo.instantiate;
    }
}
function dateFormat(date) {
    var month = (date.getMonth() + 1) < 10 ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
    var day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
    var hours = date.getHours() < 10 ? "0"+date.getHours() : date.getHours();
    var minutes = date.getMinutes() < 10 ? "0"+date.getMinutes() : date.getMinutes();
    var seconds = date.getSeconds() < 10 ? "0"+date.getSeconds() : date.getSeconds();
    return date.getFullYear() + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
}
$(function() {
    // $(".main-nav li.nav-item:eq(3) .card").hide();
    // $.post("/api/v1/dip/showDIPFlow?apiKey=99b8a3765286d2def368acd5d40db041&timestamp=1582096339075&hash=0a7671f22a1b3bcecbc9b75712bca495");
    $(".main-nav li.nav-item").mouseenter(function() {
        $(this).find(".card").fadeIn(500);
    }).mouseleave(function() {
        $(this).find(".card").fadeOut(500);
    });
    if($("#server").length) {
        $.fn.bootstrapTable.locales['zh-CN']["formatShowingRows"] = function() {
            return `
                <div class="bs-checkbox">
                    <label class="my-0">
                        <input type="checkbox" name="btSelectAll" onchange="tableSelectAll()" />
                        <span></span>
                    </label>
                </div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#renewModal">续费</button>
            `
        }
        $.fn.bootstrapTable.locales['zh-CN']["formatRecordsPerPage"] = function() {
            return ""
        }
    } else {
        $.fn.bootstrapTable.locales['zh-CN']["formatShowingRows"] = function() {
            return ""
        }
        $.fn.bootstrapTable.locales['zh-CN']["formatRecordsPerPage"] = function() {
            return ""
        }
    }
    
    
    $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales['zh-CN']);
    $('#payDate').datetimepicker({
        format: 'yyyy-mm-dd',
        language: "zh-CN",
        minView: 2,
        autoclose: true,
        todayBtn: "linked"
    }).on('changeDate', function(ev){
        if(!$('#orderDate').val()) {
            return ;
        }
        var date = ev.date;
        var end_date = new Date($('#orderDate').val() + " 00:00:00");
        $("#order #table_data").bootstrapTable("filterBy",{
            cur_date: date,
            end_date
        },{
            filterAlgorithm: function(row,filters) {
                // console.log(row,filters)
                var created_at = new Date(row.created_at);
                var pay_time = new Date(row.pay_time);
                if(Math.round(created_at.getTime()/1000) > Math.round(filters.cur_date.getTime()/1000) && Math.round(created_at.getTime()/1000) < Math.round(filters.end_date.getTime()/1000)) {
                    return true;
                }
                if(Math.round(pay_time.getTime()/1000) > Math.round(filters.cur_date.getTime()/1000) && Math.round(pay_time.getTime()/1000) < Math.round(filters.end_date.getTime()/1000)) {
                    return true;
                }
            }
        })
    });
    $('#orderDate').datetimepicker({
        format: 'yyyy-mm-dd',
        language: "zh-CN",
        minView: 2,
        autoclose: true,
        todayBtn: "linked"
    }).on('changeDate', function(ev){
        if(!$('#payDate').val()) {
            return ;
        }
        var date = ev.date;
        var start_date = new Date($('#payDate').val() + " 00:00:00");
        $("#order #table_data").bootstrapTable("filterBy",{
            cur_date: date,
            start_date
        },{
            filterAlgorithm: function(row,filters) {
                // console.log(row,filters)
                var created_at = new Date(row.created_at);
                var pay_time = new Date(row.pay_time);
                if(Math.round(created_at.getTime()/1000) < Math.round(filters.cur_date.getTime()/1000) && Math.round(created_at.getTime()/1000) > Math.round(filters.start_date.getTime()/1000)) {
                    return true;
                }
                if(Math.round(pay_time.getTime()/1000) < Math.round(filters.cur_date.getTime()/1000) && Math.round(pay_time.getTime()/1000) > Math.round(filters.start_date.getTime()/1000)) {
                    return true;
                }
            }
        })
    });
    $("#order .filter").submit(function(e) {
        if($('#payDate').val() && $('#orderDate').val()) {
            var end_date = new Date($('#orderDate').val() + " 00:00:00");
            var start_date = new Date($('#payDate').val() + " 00:00:00");
            $("#order #table_data").bootstrapTable("filterBy",{
                cur_date: end_date,
                start_date,
                order_id: $("#orderId").val()
            },{
                filterAlgorithm: function(row,filters) {
                    // console.log(row,filters)
                    var created_at = new Date(row.created_at);
                    var pay_time = new Date(row.pay_time);
                    if(Math.round(created_at.getTime()/1000) < Math.round(filters.cur_date.getTime()/1000) && Math.round(created_at.getTime()/1000) > Math.round(filters.start_date.getTime()/1000)) {
                        return row.order_sn==filters.order_id;
                    }
                    if(Math.round(pay_time.getTime()/1000) < Math.round(filters.cur_date.getTime()/1000) && Math.round(pay_time.getTime()/1000) > Math.round(filters.start_date.getTime()/1000)) {
                        return row.order_sn==filters.order_id;
                    }
                    return row.order_sn==filters.order_id;
                }
            })
            return false;
        }
        $("#order #table_data").bootstrapTable("filterBy",{
            order_sn: $("#orderId").val()
        },{
            filterAlgorithm: 'and'
        });
        return false;
    });
    $('#selectDate').datetimepicker({
        format: 'yyyy-mm-dd HH:ii',
        language: "zh-CN",
        // minView: 2,
        autoclose: true,
        todayBtn: "linked"
    }).on('changeDate', function(ev){
        // console.log(ev);
        var date = ev.date;
        $.post("/home/defenseIp/getStatistics",{
            business_id: $("#flow_echars").attr("data-business-id"),
            ip: $("#flow_echars").attr("data-business-ip"),
            date: dateFormat(date) 
        },function(data) {
            if(data.code==1) {
                let dateMap = new Map();
                let dateSet = new Set();
                data.data.forEach((item, index, arr) => {
                    // console.log(dateFormat(new Date(item.time * 1000),"yyyy-mm-dd HH:MM:ss"));
                    let date = new Date(item.time * 1000)
                    let dateString = date.getFullYear() + '-' + date.getMonth() + '-' + date.getDay() + ' ' + date.getHours() + ':' + date.getMinutes()
                    if (dateMap.has(dateString)) {
                        // item["upstream_bandwidth_up"] += dateMap.get(date.getHours() + ":" + date.getMinutes())["upstream_bandwidth_up"];
                        // item["bandwidth_down"] += dateMap.get(date.getHours() + ":" + date.getMinutes())["bandwidth_down"];
                        let maxUpstreamBandwidthUp = Math.max(item['upstream_bandwidth_up'], dateMap.get(dateString)['upstream_bandwidth_up'])
                        let maxBandwidthDown = Math.max(item['bandwidth_down'], dateMap.get(dateString)['bandwidth_down'])
                        item['upstream_bandwidth_up'] = maxUpstreamBandwidthUp
                        item['bandwidth_down'] = maxBandwidthDown
                    }
                    dateMap.set(dateString, item)
                });
                for (let value of dateMap.values()) {
                    dateSet.add(value)
                }
                createEchart(dateSet, 'flow_echars', {
                    ip: $("#flow_echars").attr("data-business-ip")
                });
            }
        });
    });
    if($("#flow_echars").length) {
        const dateFormatComponent = require('dateformat');
        let date = new Date(new Date().getTime() - 24 * 60 * 60 * 1000);
        $.post("/home/defenseIp/getStatistics",{
            business_id: $("#flow_echars").attr("data-business-id"),
            ip: $("#flow_echars").attr("data-business-ip"),
            date: dateFormatComponent(date,"yyyy-mm-dd hh:MM:ss")
        },function(data) {
            if(data.code==1) {
                let dateMap = new Map();
                let dateSet = new Set();
                data.data.forEach((item, index, arr) => {
                    // console.log(dateFormat(new Date(item.time * 1000),"yyyy-mm-dd HH:MM:ss"));
                    let date = new Date(item.time * 1000)
                    let dateString = date.getFullYear() + '-' + date.getMonth() + '-' + date.getDay() + ' ' + date.getHours() + ':' + date.getMinutes()
                    if (dateMap.has(dateString)) {
                        // item["upstream_bandwidth_up"] += dateMap.get(date.getHours() + ":" + date.getMinutes())["upstream_bandwidth_up"];
                        // item["bandwidth_down"] += dateMap.get(date.getHours() + ":" + date.getMinutes())["bandwidth_down"];
                        let maxUpstreamBandwidthUp = Math.max(item['upstream_bandwidth_up'], dateMap.get(dateString)['upstream_bandwidth_up'])
                        let maxBandwidthDown = Math.max(item['bandwidth_down'], dateMap.get(dateString)['bandwidth_down'])
                        item['upstream_bandwidth_up'] = maxUpstreamBandwidthUp
                        item['bandwidth_down'] = maxBandwidthDown
                    }
                    dateMap.set(dateString, item)
                });
                for (let value of dateMap.values()) {
                    dateSet.add(value)
                }
                createEchart(dateSet, 'flow_echars', {
                    ip: $("#flow_echars").attr("data-business-ip")
                });
            }
        });
    }
    
    $("#server #table_data").on("check-all.bs.table",function() {
        $("#table_data").data("isCheckAll",true);
        if(!$(".pagination-detail input[name='btSelectAll']:checked").length) {
            $(".pagination-detail input[name='btSelectAll']").prop("checked",true);
        }
    });
    $("#server #table_data").on("uncheck-all.bs.table",function() {
        $("#table_data").data("isCheckAll",false);
        // console.log($(".pagination-detail input[name='btSelectAll']"));
        if($(".pagination-detail input[name='btSelectAll']:checked").length) {
            $(".pagination-detail input[name='btSelectAll']").prop("checked",false);
        }
    });

    var showInfo = ShowInfo.createInstantiate("/home/user/userSituation");
    showInfo.ready(function() {
        this.intoHTML("#user_admin .global-balance",this.user.money);
        const cert = this.user.email && this.user.msg_phone && this.user.msg_qq;
        this.intoHTML("#index .user-info h5",this.user.nickname+'<span class="font-medium status badge badge-light ml-2">'+(cert ? '已认证' : '未认证')+'</span>');
        this.intoHTML("#user_admin .global-user-info h5 span:eq(0)",this.user.nickname);
        this.intoHTML("#user_admin .global-user-info h5 span:eq(1)",(cert ? '已认证' : '未认证'));
        this.intoHTML("#user_admin .global-kefu-name",this.sales.sale_name);
        this.intoHTML("#user_admin .global-kefu-qq",this.sales.QQ);
        this.intoHTML("#user_admin .global-kefu-phone",this.sales.phone);
        this.intoHTML("#index .user-info p:eq(0)",'账号：'+this.user.name);
        this.intoHTML("#index .user-info p:eq(1)",'联系电话：'+this.user.msg_phone);
        this.intoHTML("#index .balance",this.user.money);
        this.intoHTML("#index .user-mailbox span:eq(0)",'常用邮箱&nbsp;&nbsp;'+this.user.email);
        this.intoHTML("#index .user-mailbox span:eq(1)",this.user.email ? '已绑定' : '未绑定');
        this.intoHTML("#index .user-phone span:eq(0)",'手机号码&nbsp;&nbsp;'+this.user.msg_phone);
        this.intoHTML("#index .user-phone span:eq(1)",this.user.msg_phone ? '已绑定' : '未绑定');
        this.intoHTML("#index .user-qq span:eq(0)",'QQ号码&nbsp;&nbsp;'+this.user.msg_qq);
        this.intoHTML("#index .user-qq span:eq(1)",this.user.msg_qq ? '已绑定' : '未绑定');
        this.intoHTML("#index .sales-name",this.sales.sale_name);
        this.intoHTML("#index .sales-qq",'QQ号码&nbsp;&nbsp;'+this.sales.QQ);
        this.intoHTML("#index .sales-phone",'手机号码&nbsp;&nbsp;'+this.sales.phone);
        this.intoHTML("#index .idc-status span:eq(0)",'运行中：'+this.idc.use);
        this.intoHTML("#index .idc-status span:eq(1)",'需续费：'+this.idc.renew);
        this.intoHTML("#index .dip-status span:eq(0)",'运行中：'+this.dip.use);
        this.intoHTML("#index .dip-status span:eq(1)",'需续费：'+this.dip.renew);
    });
    
    $('a[data-toggle="tab"]').on("shown.bs.tab",function(e) {
        if($(e.target).attr("data-filter") != "all") {
            $($(e.target).attr("href")).find("#table_data").bootstrapTable("filterBy",{
                machineroom_name: $(e.target).attr("data-filter")
            });
        } else {
            $($(e.target).attr("href")).find("#table_data").bootstrapTable("filterBy",{});
        }
        
    });
    $(".toolbar button[type='button']").click(function() {
        $(this).addClass("active").siblings().removeClass("active");
        if($(this).attr("data-filter") != "all") {
            $("#"+$(this).attr("data-from")).find("#table_data").bootstrapTable("filterBy",{
                endding_time: $(this).attr("data-filter")
            },{
                filterAlgorithm: function(row,filters) {
                    // console.log(row,filters);
                    var now = Math.round(new Date().getTime()/1000);
                    var near = filters.endding_time * 24 * 60 * 60;
                    var expire =  Math.round(new Date(row.endding_time).getTime()/1000);
                    if((expire - near) <= now && expire > now) {
                        return true;
                    }
                    return false;
                }
            });
        } else {
            $("#"+$(this).attr("data-from")).find("#table_data").bootstrapTable("filterBy",{},{
                filterAlgorithm: 'and'
            });
        }
    });
    $(".toolbar button[type='submit']").parent().submit(function() {
        console.log($("#"+$(this).attr("data-from")).find("#inputSearch"));
        if($("#"+$(this).attr("data-from")).find("#inputSearch").val()) {
            $("#"+$(this).attr("data-from")).find("#table_data").bootstrapTable("filterBy",{
                ip: $("#"+$(this).attr("data-from")).find("#inputSearch").val(),
                machine_number: $("#"+$(this).attr("data-from")).find("#inputSearch").val()
            },{
                filterAlgorithm: 'or'
            });
        } else {
            $("#"+$(this).attr("data-from")).find("#table_data").bootstrapTable("filterBy",{},{
                filterAlgorithm: 'and'
            });
        }
        return false;
    })
    // $("#renewModal select[name='business']").UCFormSelect();
    $("#orderDetailModal").on("shown.bs.modal",function(e) {
        $(this).find(".order-id").html($(e.relatedTarget).attr("data-order-sn"));
        $(this).find(".type").html($(e.relatedTarget).attr("data-order-type"));
        $(this).find(".create-at").html($(e.relatedTarget).attr("data-created-at"));
        $(this).find(".pay-datetime").html($(e.relatedTarget).attr("data-pay-time"));
        $(this).find(".handle").html("￥"+$(e.relatedTarget).attr("data-price"));
        $(this).find(".actual").html("￥"+$(e.relatedTarget).attr("data-payable-money"));
    });
    $("#rechargeModal").on("shown.bs.modal",function(e) {
        var self = this;
        $(self).data("pay_type",$(this).find(".select-type-pay > ul > li.active").attr("data-type"));
        showInfo.ready(function() {
            this.intoHTML("#rechargeModal .recharge-item:eq(0) .recharge-value",'<strong class="mr-1">'+this.user.money+'</strong>元');
        });
        $(this).find(".select-type-pay > ul > li").click(function() {
            $(this).addClass("active").siblings().removeClass("active");
            $(self).data("pay_type",$(this).attr("data-type"));
        });
        $(this).find("#rechargePost").off("click")
        $(this).find("#rechargePost").click(function() {
            if($(self).data("pay_type") == "alipay") {
                $.get("/home/recharge/payIndex",{
                    pay_for: 1,
                    total_amount: $(self).find(".recharge-item:eq(1) .recharge-value input").val(),
                    subject: '在线充值',
                    trade_no: Math.ceil(100 + (Math.random() * 1000))
                },function(data) {
                    if(data.code==1) {
                        location.href = "/home/recharge/goToPay?trade_id="+data.data+"&way=web";
                    } else {
                        alert(data.msg);
                    }
                });
            } else {
                $.get("/home/recharge/rechargeByWechat",{
                    pay_for: 1,
                    total_amount: $(self).find(".recharge-item:eq(1) .recharge-value input").val(),
                    subject: '在线充值',
                    trade_no: Math.ceil(100 + (Math.random() * 1000))
                },function(data) {
                    if(data.code==1) {
                        new QRCode($(self).find("#weixin_pay")[0], data.data);
                        $(self).find(".alert").show(500);
                    }
                });
            }
            
        });
    });
    $("#payModal").on("shown.bs.modal",function(e) {
        var self = this;
        $(self).find("select[name='business']").UCFormSelect();
        showInfo.ready(function() {
            this.intoHTML("#payModal .balance .amount",this.user.money+"&nbsp;元");
        });
        $(self).find("#postPay").click(function() {
            $.post("/home/customer/payOrderByBalance",{
                order_id: $(self).find("select[name='business'] option:selected").map(function() {
                    var data = JSON.parse($(this).val());
                    return data.id
                }).toArray()
            },function(data) {
                alert(data.msg);
                if(data.code==1) {
                    $(self).modal('hide');
                }
            });
        });
        $.get("/home/customer/orderList",{
            business_sn: $(e.relatedTarget).attr("data-business"),
            status: 0
        },function(data) {
            if(data.code==1) {
                var option = data.data.map(function(item) {
                    return "<option value='"+JSON.stringify(item)+"' >"+item.resource+"</option>"
                }).join("");
                $(self).find("select[name='business']").empty().html(option);
                $(self).find("select[name='business']").on("change",function() {
                    var price = 0;
                    $(this).find("option:selected").each(function() {
                        var data = JSON.parse($(this).val());
                        price += Number(data.payable_money);
                        // console.log(price);
                    });
                    $(self).find(".price .amount").html(price);
                });
                $(self).find("select[name='business']").UCFormSelect("destroy");
                $(self).find("select[name='business']").UCFormSelect();
            } else {
                $(self).find("select[name='business']").empty();
                $(self).find(".price .amount").html("0");
                $(self).find("select[name='business']").UCFormSelect("destroy");
                $(self).find("select[name='business']").UCFormSelect();
            }
        })
    });
    $("#renewModal").on("shown.bs.modal",function(e) {
        var self = this;
        $(self).find("select[name='business']").UCFormSelect();
        $(self).find("#postRenew").off("click");
        $(self).find(".duration-select-btn").off("click");
        var business = [];
        if(!$(e.relatedTarget).attr("data-more")) {
            business = $("#table_data").bootstrapTable("getAllSelections");
        } else {
            business = [JSON.parse($(e.relatedTarget).attr("data-more"))];
        }
        console.log(business);
        $.get("/home/customer/new_all_renew",{
            business_id: business.map(item => item.id)
        },function(data) {
            if(data.code==1) {
                var price = 0;
                var option = [
                    "<optgroup label='IP'>" + 
                        data.data.IP.map(function(item) {
                            return "<option value='"+JSON.stringify(item)+"' >"+item.machine_sn+": "+item.resource+"</option>"
                        }).join("")
                    + "</optgroup>",
                    "<optgroup label='CPU'>" + 
                        data.data.cpu.map(function(item) {
                            return "<option value='"+JSON.stringify(item)+"' >"+item.machine_sn+": "+item.resource+"</option>"
                        }).join("")
                    + "</optgroup>",
                    "<optgroup label='硬盘'>" + 
                        data.data.harddisk.map(function(item) {
                            return "<option value='"+JSON.stringify(item)+"' >"+item.machine_sn+": "+item.resource+"</option>"
                        }).join("")
                    + "</optgroup>",
                    "<optgroup label='内存'>" + 
                        data.data.memory.map(function(item) {
                            return "<option value='"+JSON.stringify(item)+"' >"+item.machine_sn+": "+item.resource+"</option>"
                        }).join("")
                    + "</optgroup>",
                    "<optgroup label='带宽'>" + 
                        data.data.bandwidth.map(function(item) {
                            return "<option value='"+JSON.stringify(item)+"' >"+item.machine_sn+": "+item.resource+"</option>"
                        }).join("")
                    + "</optgroup>",
                    "<optgroup label='防御'>" + 
                        data.data.protected.map(function(item) {
                            return "<option value='"+JSON.stringify(item)+"' >"+item.machine_sn+": "+item.resource+"</option>"
                        }).join("")
                    + "</optgroup>"
                ];
                $(self).find("select[name='business']").empty();
                business.forEach(function(item) {
                    $(self).find("select[name='business']").append("<option value='"+JSON.stringify(item)+"' disabled selected>"+item.business_type+"-"+item.business_number+"</option>");
                });
                $(self).find("select[name='business']").append(option.join(""));
                $(self).find("select[name='business']").UCFormSelect("destroy");
                $(self).find("select[name='business']").UCFormSelect();
                showInfo.ready(function() {
                    this.intoHTML("#renewModal .balance .amount",this.user.money+"&nbsp;元");
                });
                price = JSON.parse($(self).find("select[name='business'] option:selected").val()).money;
                $(self).find(".price .amount").html(price * $(self).find(".duration-select-btn").attr("data-month"));
                $(self).find("select[name='business']").on("change",function() {
                    $(this).find("option:selected").each(function() {
                        var data = JSON.parse($(this).val());
                        price += Number(data.price || data.money);
                        // console.log(price);
                    });
                    $(self).find(".price .amount").html(price * $(self).find(".duration-select-btn").attr("data-month"));
                })
                
                $(self).find(".duration-select-btn").click(function() {
                    $(this).addClass("active").siblings().removeClass("active");
                    $(self).find(".price .amount").html(price * $(this).attr("data-month"));
                });
                
                $(self).find("#postRenew").click(function() {
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
                    $.post("/home/customer/newrenew",{
                        resource: $(self).find("select[name='business'] option:selected").map(function() {
                            var result = JSON.parse($(this).val());
                            return {
                                id: result.id,
                                resource_type: result.resource_type || result.type,
                                price: result.price || result.money
                            }
                        }).toArray(),
                        length: $(self).find(".duration-select-btn.active").attr("data-month")
                    },function(data) {
                        alert(data.msg);
                        if(data.code==1) {
                            $(self).modal('hide');
                            location.href = '/dist/highDefensePay.html?session_id=' + data.data
                        }
                    })
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

window.tableSelectAll = function() {
    if(!$("#table_data").data("isCheckAll")) {
        $("#table_data").bootstrapTable("checkAll");
        $("#table_data").data("isCheckAll",true);
    } else {
        $("#table_data").bootstrapTable("uncheckAll");
        $("#table_data").data("isCheckAll",false);
    }
    
}
window.ipFormatter = function (value, row) {
    var detail = JSON.parse(row.resource_detail);
    return detail.ip;
}
window.bandwidthFormatter = function (value, row) {
    var detail = JSON.parse(row.resource_detail);
    return detail.bandwidth;
}
window.protectFormatter = function (value, row) {
    var detail = JSON.parse(row.resource_detail);
    return detail.protect;
}
window.resourceDetailFormatter = function (value, row) {
    var detail = JSON.parse(value);
    return "CPU:" + detail.cpu + "&nbsp;&nbsp;内存：" + detail.memory;
}
window.harddiskFormatter = function (value, row) {
    var detail = JSON.parse(row.resource_detail);
    return detail.harddisk;
}
window.createdAtFormatter = function (value, row) {
    var detail = JSON.parse(row.resource_detail);
    return detail.created_at;
}
window.operatFormatter = function (value, row) {
    return '<span class="play mr-2" data-toggle="modal" data-target="#payModal" data-business="'+row.business_number+'">支付</span>\
    <span class="renew mr-2" data-toggle="modal" data-target="#renewModal" data-more=\''+JSON.stringify(row)+'\' data-bn="'+row.business_number+'">续费</span>\
    <a class="view" href="/user/detail/'+row.id+'">查看</a>';
}
window.showFormatter = function(value, row) {
    return '<span class="view" data-order-sn="'+row.order_sn+'" data-payable-money="'+row.payable_money+'" data-price="'+row.price+'" data-pay-time="'+(row.pay_time || "")+'" data-created-at="'+row.created_at+'" data-order-type="'+row.order_type+'" data-toggle="modal" data-target="#orderDetailModal">查看</span>'
}
window.process_data = function (res) {
    if(res.code == 1) {
        return res.data;
    } else {
        return [];
    }
}
window.rowStyle = function (row, index) {
    return {
        classes: "font-regular"
    }
}