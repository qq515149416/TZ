$(function() {
    $("#article .content-list .nav-tabs li a").click(function(e) {
       location.href = $(this).attr("href");
    });
});
