// CDN加速
if(document.querySelector("#CDN_speed_up")) {
    var accelerate_li = document.querySelector(".accelerate_class").getElementsByTagName("li");
    var class_item = document.querySelectorAll(".class-item");
    var class_item_a = document.querySelector(".class-item-a");
    var class_i_active = document.querySelector(".class-i-active");
    for (var i = 0; i < accelerate_li.length; i++) {
        accelerate_li[i].index = i;
        accelerate_li[i].onclick = function () {
            for (var j = 0; j < accelerate_li.length; j++) {

                accelerate_li[j].className = " ";
                class_item[j].className = "class-item ";
            }
            document.querySelector(".CDN_up").style.height="100%";
            this.className = "class-active";
            class_item[this.index].className = "class-item class-i-active";
            class_item_a.style.display = "none";
        }
    }
}

