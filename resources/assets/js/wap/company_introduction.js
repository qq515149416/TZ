if(document.querySelector("#company_introduction")){
  var news = document.querySelectorAll(".news");
  var optiontext = document.querySelectorAll(".option-text");



//   function machineroom()
document.querySelector(".drop-options p").onclick = function(){
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
  var option_text = document.querySelectorAll(".option-text");
  var option_i = document.querySelectorAll(".option-i");
  var p_value = document.querySelector(".drop-options p");
  for(var i=0;i<option_i.length;i++){
    option_i[i].index=i;
    option_i[i].addEventListener("click",function(){
      for(var j=0;j<option_text.length;j++){
        option_text[j].className="option-text";
      }
      option_text[this.index].className="option-text option-e-active";
      p_value.innerHTML=option_i[this.index].innerHTML;
  
    })
  }
  
  document.addEventListener("touchmove", function(e){
    if(e.target == document.querySelector(".drop-options p")||e.target ==document.querySelector(".select-text") ){
      document.querySelector(".select-text").style.display="block";
     document.querySelector(".drop-options .arrow").style.transform = "rotate(135deg)";
     document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
    }else{
      // moreContent.style.display = "none"
      document.querySelector(".select-text").style.display="none";
     document.querySelector(".drop-options .arrow").style.transform = "rotate(-45deg)";
     document.querySelector(".drop-options .arrow").style.transition = "transform 0.4s";
    }
  })
  }
  if (document.body.clientWidth < 330) {
    document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[0].querySelectorAll("div")[0].style.marginLeft="-50%";
    document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[0].querySelectorAll("div")[2].style.marginRight="-50%";
    document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[1].querySelectorAll("div")[0].style.marginLeft="-50%";
    document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[1].querySelectorAll("div")[2].style.marginRight="-50%";
    document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[2].querySelectorAll("div")[0].style.marginLeft="-50%";
    document.querySelectorAll(".option-text")[2].querySelectorAll(".bottom")[2].querySelectorAll("div")[2].style.marginRight="-50%";
    // document.querySelectorAll(".option-text")[5].querySelector(".bottom").querySelectorAll("div")[0].style.marginLeft="-115px";
    // document.querySelectorAll(".option-text")[5].querySelector(".bottom").querySelectorAll("div")[2].style.marginRight="-115px";
    document.querySelectorAll(".option-text")[5].style.padding="30px 11px";
    var lis = document.querySelectorAll(".option-text")[5].querySelectorAll(".contact-us")[2].querySelectorAll(" ol li");
    for(var i=0; i<lis.length;i++){
        lis[i].style.padding=" 10px 5px";
    }
    document.querySelectorAll(".option-text")[5].querySelectorAll(".contact-us")[2].style.padding="0px 5px 15px 5px";
  }
  // ???????????? ??????
  var personnel_a = document.querySelectorAll(".personnel-a");
  var pagenext = document.querySelector(".pagenext");
  var pagepre = document.querySelector(".pagepre");
  var pagefirst = document.querySelector(".pagefirst");
  var pagelast = document.querySelector(".pagelast");
  var pagelength = personnel_a.length;
  var page = 0;
  
  pagenext.onclick = function () {
      // var pageNumber = document.querySelector("#pageNumber").innerText;
      // console.log(pageNumber);
      for (var j = 0; j < personnel_a.length; j++) {
          personnel_a[j].className = "personnel-a";
      }
      if (page + 1 < pagelength) {
          page = page + 1;
          personnel_a[page].className = "personnel-a active-block";
          document.getElementById("pageNumbers").innerHTML = "0" + (page + 1);
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
          document.getElementById("pageNumbers").innerHTML = "0" + (page + 1);
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
      document.getElementById("pageNumbers").innerHTML = "01" ;
  }
  pagelast.onclick = function () {
      for (var j = 0; j < personnel_a.length; j++) {
          personnel_a[j].className = "personnel-a";
      }
      personnel_a[pagelength - 1].className = "personnel-a active-block";
      document.getElementById("pageNumbers").innerHTML = "0" + pagelength;
  }
  
    // ????????????
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
  if(document.querySelector("#company_news")) {
    goPage(1,10);
}
// ??????????????????
function goPage(pno, psize) {
    var news = document.querySelectorAll(".option-text .news");
    var num = news.length;
    var totalPage = 0;//?????????
    var pageSize = psize;//??????????????????
    //???????????????
    if (num / pageSize > parseInt(num / pageSize)) {
        totalPage = parseInt(num / pageSize) + 1;
    } else {
        totalPage = parseInt(num / pageSize);
    }
    var currentPage = pno;//????????????
    var startRow = (currentPage - 1) * pageSize + 1;//??????????????????  31
    var endRow = currentPage * pageSize;//??????????????????   40
    endRow = (endRow > num) ? num : endRow;
    //??????????????????????????????
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
        tempStr += "<div style=\"width: 70px;\">";
        tempStr += "<img src=\"/images/wap/?????????.png\" onClick=\"goPage(" + (1) + "," + psize + ")\">";
        tempStr += "<img src=\"/images/wap/?????????.png\" onClick=\"goPage(" + (currentPage - 1) + "," + psize + ")\">";
        tempStr += "</div>";

    } else {
        tempStr += "<div style=\"width: 70px;\">";
        tempStr += "<img src=\"/images/wap/?????????.png\" >";
        tempStr += "<img src=\"/images/wap/?????????.png\" >";
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
        tempStr += "<div style=\"width: 70px;\">";
        tempStr += "<img src=\"/images/wap/?????????.png\" onClick=\"goPage(" + (currentPage + 1) + "," + psize + ")\">";
        tempStr += "<img src=\"/images/wap/????????????.png\" onClick=\"goPage(" + (totalPage) + "," + psize + ")\">";
        tempStr += "</div>";
    } else {
        tempStr += "<div style=\"width: 70px;\">";
        tempStr += "<img src=\"/images/wap/?????????.png\" >";
        tempStr += "<img src=\"/images/wap/????????????.png\">";
        tempStr += "</div>";
    }

    document.getElementById("bottom").innerHTML = tempStr;
}
}