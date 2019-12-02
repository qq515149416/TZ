// $('.sidebar-menu li:not(.treeview) a:not(a[target="_blank"])').click(function(event) {
//     // alert("成功自定义");
//     var rId = hex_md5($(this).attr("href"));

//     if(!$("#pjax-container-"+rId).length) {
//         $("#pjax-container").before($("#pjax-container").clone().css({
//             "position": "absolute",
//             "left": 0,
//             "top": 50,
//             "width": $(window).width() - $(".main-sidebar").width(),
//             "z-index": 99
//         })).attr("id","pjax-container-"+rId).css({
//             "z-index": 1
//         });
//     }
//     $.pjax.click(event, {container: '#pjax-container'});
//     // $.pjax({url: $(this).attr("href"), container: '#pjax-container'});
//     event.preventDefault();
// });
// $(document).on('pjax:error', function(event) {
//     event.preventDefault();
// });
// $('.sidebar-menu a:not(a[target="_blank"])').on("pjax:click",function(event) {
//     alert("成功自定义");
//     event.preventDefault();
// })
