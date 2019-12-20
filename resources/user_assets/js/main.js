$(function() {
    // $(".main-nav li.nav-item:eq(3) .card").hide();
    $(".main-nav li.nav-item").mouseenter(function() {
        $(this).find(".card").fadeIn(500);
    }).mouseleave(function() {
        $(this).find(".card").fadeOut(500);
    });
});