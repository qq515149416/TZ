$(function() {
    // $(".main-nav li.nav-item:eq(3) .card").hide();
    $(".main-nav li.nav-item").mouseenter(function() {
        $(this).find(".card").fadeIn(500);
    }).mouseleave(function() {
        $(this).find(".card").fadeOut(500);
    });
    $.get("/home/user/userSituation",function(data) {
        console.log(data);
        if(data.code===1) {
            $("#user_admin .global-balance").html(data.data.user.money);
           const cert = data.data.user.email && data.data.user.msg_phone && data.data.user.msg_qq;
           $("#index .user-info h5").html(data.data.user.nickname+'<span class="font-medium status badge badge-light ml-2">'+(cert ? '已认证' : '未认证')+'</span>');
           $("#index .user-info p:eq(0)").html('账号：'+data.data.user.name);
           $("#index .user-info p:eq(1)").html('联系电话：'+data.data.user.msg_phone);
           $("#index .balance").html(data.data.user.money);
           $("#index .user-mailbox span:eq(0)").html('常用邮箱&nbsp;&nbsp;'+data.data.user.email);
           $("#index .user-mailbox span:eq(1)").html(data.data.user.email ? '已绑定' : '未绑定');
           $("#index .user-phone span:eq(0)").html('手机号码&nbsp;&nbsp;'+data.data.user.msg_phone);
           $("#index .user-phone span:eq(1)").html(data.data.user.msg_phone ? '已绑定' : '未绑定');
           $("#index .user-qq span:eq(0)").html('QQ号码&nbsp;&nbsp;'+data.data.user.msg_qq);
           $("#index .user-qq span:eq(1)").html(data.data.user.msg_qq ? '已绑定' : '未绑定');
           $("#index .sales-name").html(data.data.sales.sale_name);
           $("#index .sales-qq").html('QQ号码&nbsp;&nbsp;'+data.data.sales.QQ);
           $("#index .sales-phone").html('手机号码&nbsp;&nbsp;'+data.data.sales.phone);
           $("#index .idc-status span:eq(0)").html('运行中：'+data.data.idc.use);
           $("#index .idc-status span:eq(1)").html('需续费：'+data.data.idc.renew);
           $("#index .dip-status span:eq(0)").html('运行中：'+data.data.dip.use);
           $("#index .dip-status span:eq(1)").html('需续费：'+data.data.dip.renew);
        }
    });
    if($("#server").length) {
        $.fn.bootstrapTable.locales['zh-CN']["formatShowingRows"] = function() {
            return `
                <div class="bs-checkbox">
                    <label class="my-0">
                        <input type="checkbox" name="btSelectAll" />
                        <span></span>
                    </label>
                </div>
                <button type="button" class="btn btn-primary">续费</button>
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
    $("#renewModal select[name='business']").UCFormSelect();
    // $(".main-content .top-nav li a").click(function() {
    //     $(".main-content .top-nav li a").removeClass("active");
    //     $(this).addClass("active");
    // })
});