// 售前人员 翻页
var personnel_a = document.querySelectorAll(".personnel-a");
var pagenext = document.querySelector(".pagenext");
var pagepre = document.querySelector(".pagepre");
var pagefirst = document.querySelector(".pagefirst");
var pagelast = document.querySelector(".pagelast");
var pagelength = personnel_a.length;
var page = 0;

pagenext.onclick = function () {
    var pageNumber = document.getElementsByClassName("pageNumber").innerText;
    for (var j = 0; j < personnel_a.length; j++) {
        personnel_a[j].className = "personnel-a";
    }
    if (page + 1 < pagelength) {
        page = page + 1;
        personnel_a[page].className = "personnel-a active-block";
        document.getElementById("pageNumber").innerHTML = "0" + (page + 1);
    } else {
        personnel_a[pagelength - 1].className = "personnel-a active-block";
    }
}
pagepre.onclick = function () {
    for (var j = 0; j < personnel_a.length; j++) {
        personnel_a[j].className = "personnel-a";
    }
    if (page - 1 >= 0) {
        page = page - 1;
        personnel_a[page].className = "personnel-a active-block";
        document.getElementById("pageNumber").innerHTML = "0" + (page + 1);
    } else {
        personnel_a[0].className = "personnel-a active-block";
    }
}
pagefirst.onclick = function () {
    for (var j = 0; j < personnel_a.length; j++) {
        personnel_a[j].className = "personnel-a";
    }
    personnel_a[0].className = "personnel-a active-block";
    page = 0;
    document.getElementById("pageNumber").innerHTML = "0" + (page + 1);
}
pagelast.onclick = function () {
    for (var j = 0; j < personnel_a.length; j++) {
        personnel_a[j].className = "personnel-a";
    }
    personnel_a[pagelength - 1].className = "personnel-a active-block";
    document.getElementById("pageNumber").innerHTML = "0" + pagelength;
}

// 荣誉资质
var honor_a = document.querySelector(".honor-a");
var honor_i_a =honor_a.querySelectorAll(".honor-i");
var pagea = 0;
document.querySelector(".p-nexta").onclick = function(){
    
    for (var j = 0; j < honor_i_a.length; j++) {
        honor_i_a[j].className = "honor-i clear";
    }
    if (pagea + 1 < honor_i_a.length) {
        pagea = pagea + 1;
        honor_i_a[pagea].className = "honor-i clear active";
        document.getElementById("pageNumber").innerHTML = "0" + (pagea + 1);
    } else {
        honor_i_a[honor_i_a.length - 1].className = "honor-i clear active";
    }
}
document.querySelector(".p-prea").onclick = function () {
    for (var j = 0; j < honor_i_a.length; j++) {
        honor_i_a[j].className = "honor-i clear";
    }
    if (pagea - 1 >= 0) {
        pagea = pagea - 1;
        honor_i_a[pagea].className = "honor-i clear active";
        document.getElementById("pageNumber").innerHTML = "0" + (pagea + 1);
    } else {
        honor_i_a[0].className = "honor-i clear active";
    }
}
document.querySelector(".p-firsta").onclick = function () {
    for (var j = 0; j <  honor_i_a.length; j++) {
         honor_i_a[j].className = "honor-i clear";
    }
     honor_i_a[0].className = "honor-i clear active";
    pagea = 0;
    document.getElementById("pageNumber").innerHTML = "0" + (pagea + 1);
}
document.querySelector(".p-lasta").onclick = function () {
    for (var j = 0; j < honor_i_a.length; j++) {
        honor_i_a[j].className = "honor-i clear";
    }
    honor_i_a[honor_i_a.length - 1].className = "honor-i clear active";
    document.getElementById("pageNumber").innerHTML = "0" + honor_i_a.length;
}
var honor_b = document.querySelector(".honor-b");
var honor_i_b =honor_b.querySelectorAll(".honor-i");
var pageb = 0;
document.querySelector(".p-nextb").onclick = function(){
    
    for (var j = 0; j < honor_i_b.length; j++) {
        honor_i_b[j].className = "honor-i clear";
    }
    if (pageb + 1 < honor_i_b.length) {
        pageb = pageb + 1;
        honor_i_b[pageb].className = "honor-i clear active";
        document.getElementById("pageNumberb").innerHTML = "0" + (pageb + 1);
    } else {
        honor_i_b[honor_i_b.length - 1].className = "honor-i clear active";
    }
}
document.querySelector(".p-preb").onclick = function () {
    for (var j = 0; j < honor_i_b.length; j++) {
        honor_i_b[j].className = "honor-i clear";
    }
    if (pageb - 1 >= 0) {
        pageb = pageb - 1;
        honor_i_b[pageb].className = "honor-i clear active";
        document.getElementById("pageNumberb").innerHTML = "0" + (pageb + 1);
    } else {
        honor_i_b[0].className = "honor-i clear active";
    }
}
document.querySelector(".p-firstb").onclick = function () {
    for (var j = 0; j <  honor_i_b.length; j++) {
         honor_i_b[j].className = "honor-i clear";
    }
     honor_i_b[0].className = "honor-i clear active";
    pageb = 0;
    document.getElementById("pageNumberb").innerHTML = "0" + (pageb + 1);
}
document.querySelector(".p-lastb").onclick = function () {
    for (var j = 0; j < honor_i_b.length; j++) {
        honor_i_b[j].className = "honor-i clear";
    }
    honor_i_b[honor_i_b.length - 1].className = "honor-i clear active";
    document.getElementById("pageNumberb").innerHTML = "0" + honor_i_b.length;
}
var honor_c = document.querySelector(".honor-c");
var honor_i_c =honor_c.querySelectorAll(".honor-i");
var pagec = 0;
document.querySelector(".p-nextc").onclick = function(){
    
    for (var j = 0; j < honor_i_c.length; j++) {
        honor_i_c[j].className = "honor-i clear";
    }
    if (pagec + 1 < honor_i_c.length) {
        pagec = pagec + 1;
        honor_i_c[pagec].className = "honor-i clear active";
        document.getElementById("pageNumberc").innerHTML = "0" + (pagec + 1);
    } else {
        honor_i_c[honor_i_c.length - 1].className = "honor-i clear active";
    }
}
document.querySelector(".p-prec").onclick = function () {
    for (var j = 0; j < honor_i_c.length; j++) {
        honor_i_c[j].className = "honor-i clear";
    }
    if (pagec - 1 >= 0) {
        pagec = pagec - 1;
        honor_i_c[pagec].className = "honor-i clear active";
        document.getElementById("pageNumberc").innerHTML = "0" + (pagec + 1);
    } else {
        honor_i_c[0].className = "honor-i clear active";
    }
}
document.querySelector(".p-firstc").onclick = function () {
    for (var j = 0; j <  honor_i_c.length; j++) {
         honor_i_c[j].className = "honor-i clear";
    }
     honor_i_c[0].className = "honor-i clear active";
    pagec = 0;
    document.getElementById("pageNumberc").innerHTML = "0" + (pagec + 1);
}
document.querySelector(".p-lastc").onclick = function () {
    for (var j = 0; j < honor_i_c.length; j++) {
        honor_i_c[j].className = "honor-i clear";
    }
    honor_i_c[honor_i_c.length - 1].className = "honor-i clear active";
    document.getElementById("pageNumberc").innerHTML = "0" + honor_i_c.length;
}

// 新闻公告分页
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
