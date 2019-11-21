if(document.querySelector("#server_hire")){
var s1 = document.querySelector("#selecta");
var s2 = document.querySelector("#selectb");
document.querySelector("#selectb").onchange = function(){
    server_room();
};
document.querySelector("#selecta").onchange = function(){
    server_room();
};
function server_room() {
    var rooma = document.querySelector(".server-rooma");
    var selecta = document.getElementById("selecta");
    var selectb = document.getElementById("selectb");
    if(selecta.value=="湖南衡阳机房"){
        document.querySelector(".slideshow-a").style.display="none";
        document.querySelector(".one-t").style.display="none";
        document.querySelector(".slideshow").style.display="block";
            document.querySelector(".nc-a").innerHTML="16G";
            document.querySelector(".nc-b").innerHTML="16G";
            document.querySelector(".nc-c").innerHTML="16G";
            document.querySelector(".nc-d").innerHTML="16G";
            document.querySelector(".dk-a").innerHTML="G口 20M";
            document.querySelector(".dk-b").innerHTML="G口 20M";
            document.querySelector(".dk-c").innerHTML="G口 20M";
            document.querySelector(".dk-d").innerHTML="G口 20M";
            document.querySelector(".fy-b").innerHTML="40G";
            document.querySelector(".fy-c").innerHTML="80G";
            document.querySelector(".fy-d").innerHTML="120G";
        if(selectb.value=="联通服务器租用"){
            document.querySelector(".slideshow").style.display="block";
            document.querySelector(".nothing").style.display="none";
            document.querySelector(".s-t-a").innerHTML="衡阳联通A型";
            document.querySelector(".s-t-b").innerHTML="衡阳联通B型";
            document.querySelector(".s-t-c").innerHTML="衡阳联通C型";
            document.querySelector(".s-t-d").innerHTML="衡阳联通D型";
            document.querySelector(".n-ip-a").innerHTML="1个";
            document.querySelector(".n-ip-b").innerHTML="1个";
            document.querySelector(".n-ip-c").innerHTML="1个";
            document.querySelector(".n-ip-d").innerHTML="1个";
            document.querySelector(".span-a-a").innerHTML="900"
            document.querySelector(".span-a-b").innerHTML="8400";
            document.querySelector(".span-b-a").innerHTML="900";
            document.querySelector(".span-b-b").innerHTML="8400";
            document.querySelector(".span-c-a").innerHTML="1400";
            document.querySelector(".span-c-b").innerHTML="13200";
            document.querySelector(".span-d-a").innerHTML="2100";
            document.querySelector(".span-d-b").innerHTML="21600";
            
        }
        if(selectb.value=="电信服务器租用"){
            document.querySelector(".slideshow").style.display="block";
            document.querySelector(".nothing").style.display="none";
            document.querySelector(".s-t-a").innerHTML="衡阳电信A型";
            document.querySelector(".s-t-b").innerHTML="衡阳电信B型";
            document.querySelector(".s-t-c").innerHTML="衡阳电信C型";
            document.querySelector(".s-t-d").innerHTML="衡阳电信D型";
            document.querySelector(".n-ip-a").innerHTML="1个";
            document.querySelector(".n-ip-b").innerHTML="1个";
            document.querySelector(".n-ip-c").innerHTML="1个";
            document.querySelector(".n-ip-d").innerHTML="1个";
            document.querySelector(".span-a-a").innerHTML="900"
            document.querySelector(".span-a-b").innerHTML="8400";
            document.querySelector(".span-b-a").innerHTML="900";
            document.querySelector(".span-b-b").innerHTML="8400";
            document.querySelector(".span-c-a").innerHTML="1400";
            document.querySelector(".span-c-b").innerHTML="13200";
            document.querySelector(".span-d-a").innerHTML="2100";
            document.querySelector(".span-d-b").innerHTML="21600";
        }
        if(selectb.value=="双线服务器租用"){
            document.querySelector(".slideshow").style.display="block";
            document.querySelector(".nothing").style.display="none";
            document.querySelector(".s-t-a").innerHTML="衡阳双线A型";
            document.querySelector(".s-t-b").innerHTML="衡阳双线B型";
            document.querySelector(".s-t-c").innerHTML="衡阳双线C型";
            document.querySelector(".s-t-d").innerHTML="衡阳双线D型";
            document.querySelector(".n-ip-a").innerHTML="2个";
            document.querySelector(".n-ip-b").innerHTML="2个";
            document.querySelector(".n-ip-c").innerHTML="2个";
            document.querySelector(".n-ip-d").innerHTML="2个";
            document.querySelector(".span-a-a").innerHTML="1100"
            document.querySelector(".span-a-b").innerHTML="10800";
            document.querySelector(".span-b-a").innerHTML="1100";
            document.querySelector(".span-b-b").innerHTML="10800";
            document.querySelector(".span-c-a").innerHTML="1600";
            document.querySelector(".span-c-b").innerHTML="15600";
            document.querySelector(".span-d-a").innerHTML="2300";
            document.querySelector(".span-d-b").innerHTML="24000";
        }
        if(selectb.value=="三线服务器租用"){
            document.querySelector(".s-t-a").innerHTML="衡阳三线";
            document.querySelector(".slideshow").style.display="none";
            document.querySelector(".nothing").style.display="block";
        }
    }
    if(selecta.value=="广东惠州机房"){
        document.querySelector(".slideshow-a").style.display="none";
        document.querySelector(".slideshow").style.display="none";
        document.querySelector(".one-t").style.display="block";
        var one_li = document.querySelectorAll(".one-t .slide-li");
        if(selectb.value=="联通服务器租用"){
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li";
            }
            document.querySelector("#one-b").className="slide-li active";
        }
        if(selectb.value=="电信服务器租用"){
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li";
            }
            document.querySelector("#one-a").className="slide-li active";
        }
        if(selectb.value=="双线服务器租用"){
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li";
            }
            document.querySelector("#one-c").className="slide-li active";
        }
        if(selectb.value=="三线服务器租用"){
            document.querySelector(".one-t").style.display="none";
            document.querySelector(".one-t").style.display="none";
            document.querySelector(".nothing").style.display="block";
        }
    }
    if(selecta.value=="陕西西安机房"){
        document.querySelector(".slideshow-a").style.display="block";
        document.querySelector(".slideshow").style.display="none";
        document.querySelector(".nothing").style.display="none";
        document.querySelector(".one-t").style.display="none";
        document.querySelector(".nc-a-a").innerHTML="16G";
        document.querySelector(".fy-b-a").innerHTML="80G";
        document.querySelector(".fy-c-a").innerHTML="160G";
        document.querySelector(".fy-d-a").innerHTML="300G";
        document.querySelector(".nc-b-a").innerHTML="16G";
        document.querySelector(".nc-c-a").innerHTML="32G";
        document.querySelector(".nc-d-a").innerHTML="32G";
        document.querySelector(".dk-a-a").innerHTML="G口 20M";
        document.querySelector(".dk-b-a").innerHTML="G口 20M";
        document.querySelector(".dk-c-a").innerHTML="G口 20M";
        document.querySelector(".dk-d-a").innerHTML="G口 20M";
        if(selectb.value=="联通服务器租用"){
            document.querySelector(".s-t-a-a").innerHTML="西安联通A型";
            document.querySelector(".s-t-b-a").innerHTML="西安联通B型";
            document.querySelector(".s-t-c-a").innerHTML="西安联通C型";
            document.querySelector(".s-t-d-a").innerHTML="西安联通D型";
            document.querySelector(".s-t-e").innerHTML="西安联通";
            document.querySelector(".n-ip-a-a").innerHTML="1个";
            document.querySelector(".n-ip-b-a").innerHTML="1个";
            document.querySelector(".n-ip-c-a").innerHTML="1个";
            document.querySelector(".n-ip-d-a").innerHTML="1个";
            document.querySelector(".dk-a-a").innerHTML="G口 20M";
            document.querySelector(".dk-b-a").innerHTML="G口 20M";
            document.querySelector(".dk-c-a").innerHTML="G口 100M";
            document.querySelector(".dk-d-a").innerHTML="G口 200M";
            document.querySelector(".span-a-a-a").innerHTML="1000"
            document.querySelector(".span-a-b-a").innerHTML="9600";
            document.querySelector(".span-b-a-a").innerHTML="1000";
            document.querySelector(".span-b-b-a").innerHTML="9600";
            document.querySelector(".span-c-a-a").innerHTML="1800";
            document.querySelector(".span-c-b-a").innerHTML="18000";
            document.querySelector(".span-d-a-a").innerHTML="3500";
            document.querySelector(".span-d-b-a").innerHTML="36000";
        }
        if(selectb.value=="电信服务器租用"){
            document.querySelector(".s-t-a-a").innerHTML="西安电信A型";
            document.querySelector(".s-t-b-a").innerHTML="西安电信B型";
            document.querySelector(".s-t-c-a").innerHTML="西安电信C型";
            document.querySelector(".s-t-d-a").innerHTML="西安电信D型";
            document.querySelector(".s-t-e").innerHTML="西安电信";
            document.querySelector(".n-ip-a-a").innerHTML="1个";
            document.querySelector(".n-ip-b-a").innerHTML="1个";
            document.querySelector(".n-ip-c-a").innerHTML="1个";
            document.querySelector(".n-ip-d-a").innerHTML="1个";
            document.querySelector(".dk-a-a").innerHTML="G口 20M";
            document.querySelector(".dk-b-a").innerHTML="G口 50M";
            document.querySelector(".dk-c-a").innerHTML="G口 100M";
            document.querySelector(".dk-d-a").innerHTML="G口 200M";
            document.querySelector(".span-a-a-a").innerHTML="1000"
            document.querySelector(".span-a-b-a").innerHTML="9600";
            document.querySelector(".span-b-a-a").innerHTML="1000";
            document.querySelector(".span-b-b-a").innerHTML="9600";
            document.querySelector(".span-c-a-a").innerHTML="1800";
            document.querySelector(".span-c-b-a").innerHTML="18000";
            document.querySelector(".span-d-a-a").innerHTML="3500";
            document.querySelector(".span-d-b-a").innerHTML="36000";
        }
        if(selectb.value=="双线服务器租用"){
            document.querySelector(".s-t-a-a").innerHTML="西安双线A型";
            document.querySelector(".s-t-b-a").innerHTML="西安双线B型";
            document.querySelector(".s-t-c-a").innerHTML="西安双线C型";
            document.querySelector(".s-t-d-a").innerHTML="西安双线D型";
            document.querySelector(".s-t-e").innerHTML="西安双线";
            document.querySelector(".n-ip-a-a").innerHTML="2个";
            document.querySelector(".n-ip-b-a").innerHTML="2个";
            document.querySelector(".n-ip-c-a").innerHTML="2个";
            document.querySelector(".n-ip-d-a").innerHTML="2个";
            document.querySelector(".dk-a-a").innerHTML="G口 20M";
            document.querySelector(".dk-b-a").innerHTML="G口 20M";
            document.querySelector(".dk-c-a").innerHTML="G口 100M";
            document.querySelector(".dk-d-a").innerHTML="G口 200M";
            document.querySelector(".span-a-a-a").innerHTML="1200"
            document.querySelector(".span-a-b-a").innerHTML="14400";
            document.querySelector(".span-b-a-a").innerHTML="1200";
            document.querySelector(".span-b-b-a").innerHTML="14400";
            document.querySelector(".span-c-a-a").innerHTML="2000";
            document.querySelector(".span-c-b-a").innerHTML="24000";
            document.querySelector(".span-d-a-a").innerHTML="3700";
            document.querySelector(".span-d-b-a").innerHTML="44400";
        }
        if(selectb.value=="三线服务器租用"){
            document.querySelector(".s-t-a-a").innerHTML="西安三线A型";
            document.querySelector(".s-t-b-a").innerHTML="西安三线B型";
            document.querySelector(".s-t-c-a").innerHTML="西安三线C型";
            document.querySelector(".s-t-d-a").innerHTML="西安三线D型";
            document.querySelector(".s-t-e").innerHTML="西安三线";
            document.querySelector(".n-ip-a-a").innerHTML="3个";
            document.querySelector(".n-ip-b-a").innerHTML="3个";
            document.querySelector(".n-ip-c-a").innerHTML="3个";
            document.querySelector(".n-ip-d-a").innerHTML="3个";
            document.querySelector(".dk-a-a").innerHTML="G口 20M";
            document.querySelector(".dk-b-a").innerHTML="G口 20M";
            document.querySelector(".dk-c-a").innerHTML="G口 100M";
            document.querySelector(".dk-d-a").innerHTML="G口 200M";
            document.querySelector(".span-a-a-a").innerHTML="1500"
            document.querySelector(".span-a-b-a").innerHTML="18000";
            document.querySelector(".span-b-a-a").innerHTML="1500";
            document.querySelector(".span-b-b-a").innerHTML="18000";
            document.querySelector(".span-c-a-a").innerHTML="2300";
            document.querySelector(".span-c-b-a").innerHTML="27600";
            document.querySelector(".span-d-a-a").innerHTML="4000";
            document.querySelector(".span-d-b-a").innerHTML="48000";
        }
    }
}
}
