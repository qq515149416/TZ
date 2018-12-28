$(function(){
    var href = window.location.href,
        referrer = document.referrer;
    $(function(){
    	$("#hideid").removeClass("cur");
    });
    
    $(".chi-parent").hover(function() {
        var className = this.className,
            width = '100px',
            height = 'auto';
        $(this).addClass("cur");
    },function() {
        $(this).removeClass("cur");
    });
    	
    
    var curElem;
    $(".kf-chi li").click(function() {
        if(curElem){
            $(".curs").removeClass("curs");
            $(curElem).find(".chiqq").stop().slideUp();            
        }
        $(this).addClass("curs");
        $(this).find(".chiqq").stop().slideDown();
        curElem = this;
    });
    $(function(){
    $(this).find(".oneq").stop().slideDown();
    $(".curs").addClass("curs");
    curElem = this;
});

    
    try {
         if ($(window).width() >= 1440) {
            $(".ic1").addClass("cur");
        }else {
            $(".ic1").removeClass("cur");
        }    
    }catch (e){};
    
    
    $(".jssh").hover(function() {
        $(".jssh-m ").addClass("ssh");
    },function() {
        $(".jssh-m ").removeClass("ssh");
    });

});
