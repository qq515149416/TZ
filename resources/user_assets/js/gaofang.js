
$(function() {
    if($("#gaofang").length) {
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
        $.fn.bootstrapTable.locales['zh-CN']["formatShowingRows"] = function(pageFrom, pageTo, totalRows) {
            return "共"+totalRows+"页";
        }
        window.operatFormatter = function (value, row) {
            return '<span class="useip mr-2" data-toggle="modal" data-target="#useIpModal" data-bn="'+row.business_number+'">使用</span>\
            <span class="renew mr-2" data-toggle="modal" data-target="#renewModal" data-more=\''+JSON.stringify(row)+'\' data-bn="'+row.business_number+'">续费</span>\
            <a class="view" href="/user/gaofang_detail/'+row.id+'">查看</a>';
        }
        $("#useIpModal").off("shown.bs.modal");
        $("#useIpModal").on("shown.bs.modal",function(e) {
            var self = this;
            $(self).find("#postUseIp").off("click");
            $(self).find("#postUseIp").click(function() {
                $.post("/home/defenseIp/setTarget",{
                    business_id: $(e.relatedTarget).attr("data-bn"),
                    target_ip: $(self).find("#use_ip_text").val()
                },function(data) {
                    alert(data.msg);
                    if(data.code==1) {
                        $(self).modal('hide');
                        $("#gaofang #table_data").bootstrapTable('refresh');
                    }
                });
            });
        });
        $("#renewModal").off("shown.bs.modal");
        $("#renewModal").on("shown.bs.modal",function(e) {
            var showInfo = ShowInfo.createInstantiate("/home/user/userSituation");
            var self = this;
            var price = 0;
            $(self).find("#renewModalLabel span").html("高防IP");
            $(self).find("select[name='business']").UCFormSelect();
            $(self).find("#postRenew").off("click");
            $(self).find(".duration-select-btn").off("click");
            var business = [];
            if(!$(e.relatedTarget).attr("data-more")) {
                business = $("#table_data").bootstrapTable("getAllSelections");
            } else {
                business = [JSON.parse($(e.relatedTarget).attr("data-more"))];
            }
            $(self).find("select[name='business']").empty();
            business.forEach(function(item) {
                $(self).find("select[name='business']").append("<option value='"+JSON.stringify(item)+"' disabled selected>"+item.defense_ip+"-"+item.business_number+"</option>");
            });
            $(self).find("select[name='business']").UCFormSelect("destroy");
            $(self).find("select[name='business']").UCFormSelect();
            showInfo.ready(function() {
                this.intoHTML("#renewModal .balance .amount",this.user.money+"&nbsp;元");
            });
            price = JSON.parse($(self).find("select[name='business'] option:selected").val()).price;
            console.log(price,$(self).find("select[name='business'] option:selected").val());
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
                $.get("/home/defenseIp/renewDefenseIp",{
                    business_id: JSON.parse($(self).find("select[name='business'] option:selected").val()).id,
                    buy_time: $(self).find(".duration-select-btn.active").attr("data-month")
                },function(data) {
                    alert(data.msg);
                    if(data.code==1) {
                        $(self).modal('hide');
                        location.href = '/dist/highDefensePay.html?orderid=' + data.data
                    }
                });
            });

        });

        $(".filter form button[type='submit']").parent().submit(function() {
            if($("#"+$(this).attr("data-from")).find("#orderId").val()) {
                $("#"+$(this).attr("data-from")).find("#table_data").bootstrapTable("filterBy",{
                    [$("#"+$(this).attr("data-from")).find("#type").val()]: $("#"+$(this).attr("data-from")).find("#orderId").val()
                })
            } else {
                $("#"+$(this).attr("data-from")).find("#table_data").bootstrapTable("filterBy",{});
            }
            return false
        });

        $("#gaofangBuyModal").off("shown.bs.modal");
        $("#gaofangBuyModal").on("shown.bs.modal",function(e) {
            var length = 1;
            var showInfo = ShowInfo.createInstantiate("/home/user/userSituation");
            var self = this;
            showInfo.ready(function() {
                this.intoHTML("#gaofangBuyModal .balance .amount",this.user.money+"&nbsp;元");
            });
            $.get("/gaofang/package",function(data) {
                if(data.code==1) {
                    var liDomStr = data.data.map(item => `
                    <li data-price="${item.price}" data-id="${item.id}">
                        <div class="product-wrap d-block w-100">
                            <h4 class="font-heavy mb-4">${item.name}</h4>
                            <div class="price mb-4">
                                <div class="amount">
                                    ${item.price}
                                </div>
                                <div class="unit font-regular">
                                    元/月
                                </div>
                            </div>
                            <ul class="product-config ml-4 pl-1 mb-4 pb-1">
                                <li>
                                    <span class="attr font-medium mr-2">防御值</span>
                                    <span class="val font-medium">${item.protection_value}G</span>
                                </li>
                                <li>
                                    <span class="attr font-medium mr-2">机&nbsp;&nbsp;&nbsp;&nbsp;房</span>
                                    <span class="val font-medium">${item.site}</span>
                                </li>
                            </ul>
                        </div>
                    </li>
                    `);
                    $(self).find(".gaofang-product ul").empty().append(liDomStr);
                    $(self).find(".gaofang-product li").off("click");
                    $(self).find(".gaofang-product li").click(function() {
                        $(this).addClass("active").siblings().removeClass("active");
                        $(self).find(".modal-body > .price > .amount").html(length * $(this).attr("data-price"));
                    });
                    $(self).find(".modal-body > .duration > .duration-select > .duration-select-btn").off("click");
                    $(self).find(".modal-body > .duration > .duration-select > .duration-select-btn").click(function() {
                        $(this).addClass("active").siblings().removeClass("active");
                        length = $(this).attr("data-month");
                        var price = $(self).find(".modal-body > .gaofang-product li.active").attr("data-price");
                        $(self).find(".modal-body > .price > .amount").html(length * price);
                    });
                    $(self).find("#postBuy").off("click");
                    $(self).find("#postBuy").click(function() {
                        $.get("/home/defenseIp/buyDefenseIpNow",{
                            package_id: $(self).find(".modal-body > .gaofang-product li.active").attr("data-id"),
                            buy_time: length
                        },function(data) {
                            alert(data.msg);
                            if(data.code==1) {
                                location.href = "/dist/highDefensePay.html?orderid="+data.data;
                            }
                        });
                    });
                }
            });
            
        });
        
    }
    if($("#detail.gaofang").length) {
        $("#detail > .container-fluid > .row").height($(window).height() - 58 - 24 - 48);
    }
})