function goPage(pno, psize) {
    var news = document.querySelectorAll(".option-text .news");
    var num = news.length;
    var totalPage = 0;//总页数
    var pageSize = psize;//每页显示行数
    //总共分几页 
    if (num / pageSize > parseInt(num / pageSize)) {
        totalPage = parseInt(num / pageSize) + 1;
    } else {
        totalPage = parseInt(num / pageSize);
    }
    var currentPage = pno;//当前页数
    var startRow = (currentPage - 1) * pageSize + 1;//开始显示的行  31 
    var endRow = currentPage * pageSize;//结束显示的行   40
    endRow = (endRow > num) ? num : endRow;
    //遍历显示数据实现分页
    for (var i = 1; i < (num + 1); i++) {
        var irow = news[i - 1];
        if (i >= startRow && i <= endRow) {
            irow.style.display = "block";
        } else {
            irow.style.display = "none";
        }
    }

    var tempStr = "";
    if (currentPage > 1) {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"../image/android/drawable-xhdpi/第一页.png\" onClick=\"goPage(" + (1) + "," + psize + ")\">";
        tempStr += "<img src=\"../image/android/drawable-xhdpi/上一页.png\" onClick=\"goPage(" + (currentPage - 1) + "," + psize + ")\">";
        tempStr += "</div>";

    } else {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"../image/android/drawable-xhdpi/第一页.png\" >";
        tempStr += "<img src=\"../image/android/drawable-xhdpi/上一页.png\" >";
        tempStr += "</div>";
    }
    if (currentPage >=10 ) {
        tempStr += "<div class=\"page\" id=\"page\">";
        tempStr += "<span>"  + currentPage + "</span>" 
    } else {
        tempStr += "<div class=\"page\" id=\"page\">";
        tempStr += "<span>" + "0" + currentPage + "</span>" 
    }
    if(totalPage>=10){
        tempStr += "/" + totalPage;
        tempStr += "</div>";
    }else{
        tempStr += "/0" + totalPage;
        tempStr += "</div>";
    }
    if (currentPage < totalPage) {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"../image/android/drawable-xhdpi/下一页.png\" onClick=\"goPage(" + (currentPage + 1) + "," + psize + ")\">";
        tempStr += "<img src=\"../image/android/drawable-xhdpi/最后一页.png\" onClick=\"goPage(" + (totalPage) + "," + psize + ")\">";
        tempStr += "</div>";
    } else {
        tempStr += "<div style=\"width: 90px;\">";
        tempStr += "<img src=\"../image/android/drawable-xhdpi/下一页.png\" >";
        tempStr += "<img src=\"../image/android/drawable-xhdpi/最后一页.png\">";
        tempStr += "</div>";
    }

    document.getElementById("bottom").innerHTML = tempStr;
}
var help_home_s = document.querySelectorAll(".option-text .help-home-s");
for(var i=0;i<help_home_s.length;i++){
    help_home_s[i].addEventListener("click",function(){
        document.querySelector(".option-text").style.display="none";
       document.querySelector(".help-home-content").style.display="block";
  
      })
}