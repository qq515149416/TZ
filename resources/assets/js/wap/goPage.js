
var help_home_s = document.querySelectorAll(".option-text .help-home-s");
var testabc = document.querySelectorAll(".testabc");
var content = document.querySelectorAll(".option-text .help-home-content");
for(var i=0;i<help_home_s.length;i++){
    help_home_s[i].index = i;
    help_home_s[i].addEventListener("click",function(){
        content[this.index].style.display="block";
        for(var i=0;i<testabc.length;i++){
            testabc[i].style.display="none";
        }
        if(document.querySelector("#help_center_home")){
            if(document.querySelector(".helpcenter").innerHTML=="高防服务器"){
                console.log("高防服务器");
                if(document.querySelector(".title2")){
                    document.querySelector(".title2").style.display="none";
                }
            }
        }
       
       document.querySelector( "#bottom").style.display="none";
      })
}


