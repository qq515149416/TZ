var news = document.querySelectorAll(".news");
var optiontext = document.querySelectorAll(".option-text");
for(var i=0;i<news.length;i++){
    news[i].index=i;
    news[i].onclick = function(){
        for(var j=0 ;j<optiontext.length;j++){
            optiontext[j].className="option-text";
        }
        document.querySelector(".news-content").style.display="block";

    }
}
