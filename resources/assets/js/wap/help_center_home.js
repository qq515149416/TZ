if(document.querySelector("#help_center_home")){
    var helpcenter = document.querySelector(".helpcenter");
    helpcenter.onclick = function(){
        var arrows = document.querySelector(".drop-options .arrow");
      if(document.querySelector(".select-text").style.display=="none"){
        document.querySelector(".select-text").style.display="block";
        arrows.style.transform = "rotate(135deg)";
        arrows.style.transition = "transform 0.4s";
      }else{
        document.querySelector(".select-text").style.display="none";
        arrows.style.transform = "rotate(-45deg)";
        arrows.style.transition = "transform 0.4s";
      }

        document.addEventListener("touchmove", function(e){
            if(e.target == document.querySelector(".drop-options p")||e.target ==document.querySelector(".select-text") ){
              document.querySelector(".select-text").style.display="block";
             document.querySelector(".drop-options .arrow").style.transform = "rotate(135deg)";
             document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
            }else{
              document.querySelector(".select-text").style.display="none";
             document.querySelector(".drop-options .arrow").style.transform = "rotate(-45deg)";
             document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
            }
          })
    }
    if(document.querySelector("#help-p") ) {
      // goPage(1,8)
    }
}
