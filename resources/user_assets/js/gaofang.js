
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
            return '<span class="renew mr-2" data-toggle="modal" data-target="#renewModal" data-more=\''+JSON.stringify(row)+'\' data-bn="'+row.business_number+'">续费</span>\
            <a class="view" href="/user/detail/'+row.id+'">查看</a>';
        }
        $("#renewModal").off("shown.bs.modal");
        $("#renewModal").on("shown.bs.modal",function(e) {
            var showInfo = ShowInfo.createInstantiate("/home/user/userSituation");
            var self = this;
            var price = 0;
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
    }
})