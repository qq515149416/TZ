function helpcenter(){
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
  var option_i = document.querySelectorAll(".option-i");
  var p_value = document.querySelector(".drop-options p");
  for(var i=0;i<option_i.length;i++){
    option_i[i].index=i;
    option_i[i].addEventListener("click",function(){
      p_value.innerHTML=option_i[this.index].innerHTML;
      document.querySelector(".option-text").style.display="block";
      document.querySelector(".help-home-content").style.display="none";
    })
    }
    document.addEventListener("touchmove", function(e){
        if(e.target == document.querySelector(".drop-options p")||e.target ==document.querySelector(".select-text") ){
          document.querySelector(".select-text").style.display="block";
         document.querySelector(".drop-options .arrow").style.transform = "rotate(135deg)";
         document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
        }else{
          moreContent.style.display = "none"
          document.querySelector(".select-text").style.display="none";
         document.querySelector(".drop-options .arrow").style.transform = "rotate(-45deg)";
         document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
        }
      })
}
// var help_home_s = document.querySelectorAll(".option-text .help-home-s");
// for(var i=0;i<help_home_s.length;i++){
//     help_home_s[i].addEventListener("click",function(){
//         document.querySelector(".option-text").style.display="none";
//        document.querySelector(".help-home-content").style.display="block";
  
//       })
// }