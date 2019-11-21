
if(document.querySelector("#server_hosting")){
    var s1 = document.querySelector("#select1");
    var s2 = document.querySelector("#select2");
    if(document.body.clientWidth<330){
        document.querySelector(".compouter-advantage").style.backgroundSize="320px 345px";
    }
    document.querySelector("#select1").onchange = function(){
        server_h_room();
    };
    document.querySelector("#select2").onchange = function(){
        server_h_room();
    };
    function server_h_room(){
    var rooma = document.querySelector(".server-rooma");
    var select1 = document.getElementById("select1");
    var select2 = document.getElementById("select2");
    // console.log(aa);
    if(select1.value=="湖南衡阳机房"){
        document.querySelector(".slideshow-a").style.display="none";
        document.querySelector(".one-t").style.display="none";
        document.querySelector(".slideshow").style.display="block";
        if(select2.value=="电信1U"){
            document.querySelector(".slideshow").style.display="block";
            document.querySelector(".nothing").style.display="none";
            for(var i=0; i<4;i++){
                document.querySelectorAll(".gga-a")[i].innerHTML="1U";
            }
            for(var i=0; i<4;i++){
                document.querySelectorAll(".ipa-a")[i].innerHTML="1个";
            }
            document.querySelector(".li_t_a").innerHTML="电信无防企业型";
            document.querySelector(".li_t_b").innerHTML="电信40G硬防型";
            document.querySelector(".li_t_c").innerHTML="电信80G硬防型";
            document.querySelector(".li_t_d").innerHTML="电信120G硬防型";
            document.querySelector(".fya-a").innerHTML="无";
            document.querySelector(".fya-b").innerHTML="40G";
            document.querySelector(".fya-c").innerHTML="80G";
            document.querySelector(".fya-d").innerHTML="120G";
            document.querySelector(".yfa-a").innerHTML="800"
            document.querySelector(".yfa-b").innerHTML="800";
            document.querySelector(".yfa-c").innerHTML="1300";
            document.querySelector(".yfa-d").innerHTML="2000";
            document.querySelector(".nfa-a").innerHTML="7200";
            document.querySelector(".nfa-b").innerHTML="7200";
            document.querySelector(".nfa-c").innerHTML="12000";
            document.querySelector(".nfa-d").innerHTML="20400";
            
        }
        if(select2.value=="电信2U"){
            document.querySelector(".slideshow").style.display="block";
            document.querySelector(".nothing").style.display="none";
            for(var i=0; i<4;i++){
                document.querySelectorAll(".gga-a")[i].innerHTML="2U";
            }
            for(var i=0; i<4;i++){
                document.querySelectorAll(".ipa-a")[i].innerHTML="1个";
            }
            document.querySelector(".li_t_a").innerHTML="电信无防企业型";
            document.querySelector(".li_t_b").innerHTML="电信40G硬防型";
            document.querySelector(".li_t_c").innerHTML="电信80G硬防型";
            document.querySelector(".li_t_d").innerHTML="电信120G硬防型";
           
            document.querySelector(".yfa-a").innerHTML="1000"
            document.querySelector(".yfa-b").innerHTML="1000";
            document.querySelector(".yfa-c").innerHTML="1500";
            document.querySelector(".yfa-d").innerHTML="2200";
            document.querySelector(".nfa-a").innerHTML="9600";
            document.querySelector(".nfa-b").innerHTML="9600";
            document.querySelector(".nfa-c").innerHTML="14400";
            document.querySelector(".nfa-d").innerHTML="22800";
        }
        if(select2.value=="联通1U"){
            document.querySelector(".slideshow").style.display="block";
            document.querySelector(".nothing").style.display="none";
            for(var i=0; i<4;i++){
                document.querySelectorAll(".gga-a")[i].innerHTML="1U";
            }
            for(var i=0; i<4;i++){
                document.querySelectorAll(".ipa-a")[i].innerHTML="1个";
            }
            document.querySelector(".li_t_a").innerHTML="联通无防企业型";
            document.querySelector(".li_t_b").innerHTML="联通40G硬防型";
            document.querySelector(".li_t_c").innerHTML="联通80G硬防型";
            document.querySelector(".li_t_d").innerHTML="联通120G硬防型";
            
            document.querySelector(".yfa-a").innerHTML="800"
            document.querySelector(".yfa-b").innerHTML="800";
            document.querySelector(".yfa-c").innerHTML="1300";
            document.querySelector(".yfa-d").innerHTML="2000";
            document.querySelector(".nfa-a").innerHTML="7200";
            document.querySelector(".nfa-b").innerHTML="7200";
            document.querySelector(".nfa-c").innerHTML="12000";
            document.querySelector(".nfa-d").innerHTML="20400";
        }
        if(select2.value=="联通2U"){
            document.querySelector(".slideshow").style.display="block";
            document.querySelector(".nothing").style.display="none";
            for(var i=0; i<4;i++){
                document.querySelectorAll(".gga-a")[i].innerHTML="2U";
            }
            for(var i=0; i<4;i++){
                document.querySelectorAll(".ipa-a")[i].innerHTML="1个";
            }
            
            document.querySelector(".li_t_a").innerHTML="联通无防企业型";
            document.querySelector(".li_t_b").innerHTML="联通40G硬防型";
            document.querySelector(".li_t_c").innerHTML="联通80G硬防型";
            document.querySelector(".li_t_d").innerHTML="联通120G硬防型";
            
            document.querySelector(".yfa-a").innerHTML="1000"
            document.querySelector(".yfa-b").innerHTML="1000";
            document.querySelector(".yfa-c").innerHTML="1500";
            document.querySelector(".yfa-d").innerHTML="2200";
            document.querySelector(".nfa-a").innerHTML="9600";
            document.querySelector(".nfa-b").innerHTML="9600";
            document.querySelector(".nfa-c").innerHTML="14400";
            document.querySelector(".nfa-d").innerHTML="22800";
        }
        if(select2.value=="双线1U"){
            document.querySelector(".slideshow").style.display="block";
            document.querySelector(".nothing").style.display="none";
            for(var i=0; i<4;i++){
                document.querySelectorAll(".gga-a")[i].innerHTML="1U";
            }
            for(var i=0; i<4;i++){
                document.querySelectorAll(".ipa-a")[i].innerHTML="2个";
            }
            document.querySelector(".li_t_a").innerHTML="双线无防企业型";
            document.querySelector(".li_t_b").innerHTML="双线40G硬防型";
            document.querySelector(".li_t_c").innerHTML="双线80G硬防型";
            document.querySelector(".li_t_d").innerHTML="双线120G硬防型";
            
            document.querySelector(".yfa-a").innerHTML="1000"
            document.querySelector(".yfa-b").innerHTML="1000";
            document.querySelector(".yfa-c").innerHTML="1500";
            document.querySelector(".yfa-d").innerHTML="2200";
            document.querySelector(".nfa-a").innerHTML="9600";
            document.querySelector(".nfa-b").innerHTML="9600";
            document.querySelector(".nfa-c").innerHTML="14400";
            document.querySelector(".nfa-d").innerHTML="22800";
        }
        if(select2.value=="双线2U"){
            document.querySelector(".slideshow").style.display="block";
            document.querySelector(".nothing").style.display="none";
            for(var i=0; i<4;i++){
                document.querySelectorAll(".gga-a")[i].innerHTML="2U";
            }
            for(var i=0; i<4;i++){
                document.querySelectorAll(".ipa-a")[i].innerHTML="2个";
            }
            document.querySelector(".li_t_a").innerHTML="双线无防企业型";
            document.querySelector(".li_t_b").innerHTML="双线40G硬防型";
            document.querySelector(".li_t_c").innerHTML="双线80G硬防型";
            document.querySelector(".li_t_d").innerHTML="双线120G硬防型";
            
            document.querySelector(".yfa-a").innerHTML="1200"
            document.querySelector(".yfa-b").innerHTML="1200";
            document.querySelector(".yfa-c").innerHTML="1700";
            document.querySelector(".yfa-d").innerHTML="2400";
            document.querySelector(".nfa-a").innerHTML="12000";
            document.querySelector(".nfa-b").innerHTML="12000";
            document.querySelector(".nfa-c").innerHTML="16800";
            document.querySelector(".nfa-d").innerHTML="25200";
        }
        if(select2.value=="三线1U"){
            document.querySelector(".slideshow").style.display="none";
            document.querySelector(".slideshow-a").style.display="none";
            document.querySelector(".nothing").style.display="block";
            document.querySelector(".not_gg").innerHTML="1U"
        }
        if(select2.value=="三线2U"){
            document.querySelector(".slideshow").style.display="none";
            document.querySelector(".slideshow-a").style.display="none";
            document.querySelector(".nothing").style.display="block";
            document.querySelector(".not_gg").innerHTML="2U";
        }
    }
    if(select1.value=="广东惠州机房"){
        document.querySelector(".slideshow-a").style.display="none";
        document.querySelector(".slideshow").style.display="none";
        document.querySelector(".one-t").style.display="block";
        var one_li = document.querySelectorAll(".one-t .slide-li");
        if(select2.value=="电信1U"){
            console.log("联通服务器租用");
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li clear";
            }
            document.querySelector("#one-a").className="slide-li active clear";
        }
        if(select2.value=="电信2U"){
            console.log("电信服务器租用");
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li clear";
            }
            document.querySelector("#one-e").className="slide-li active clear";
        }
        if(select2.value=="联通1U"){
            console.log("双线服务器租用");
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li clear";
            }
            document.querySelector("#one-b").className="slide-li active clear";
        }
        if(select2.value=="联通2U"){
            console.log("----------");
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li clear";
            }
            document.querySelector("#one-f").className="slide-li active clear";
            // document.querySelector(".one-t").style.display="none";
            // document.querySelector(".one-t").style.display="none";
            // document.querySelector(".nothing").style.display="block";
        }
        if(select2.value=="双线1U"){
            console.log("双线服务器租用");
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li clear";
            }
            document.querySelector("#one-c").className="slide-li active clear";
        }
        if(select2.value=="双线2U"){
            console.log("双线服务器租用");
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li clear";
            }
            document.querySelector("#one-g").className="slide-li active clear";
        }
        if(select2.value=="三线1U"){
            console.log("双线服务器租用");
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li clear";
            }
            document.querySelector("#one-d").className="slide-li active clear";
        }
        if(select2.value=="三线2U"){
            console.log("双线服务器租用");
            document.querySelector(".nothing").style.display="none";
            for(var i=0 ;i<one_li.length;i++){
                one_li[i].className="slide-li clear";
            }
            document.querySelector("#one-h").className="slide-li active clear";
        }
    }
    if(select1.value=="陕西西安机房"){
        document.querySelector(".slideshow-a").style.display="block";
        document.querySelector(".nothing").style.display="none";
        document.querySelector(".one-t").style.display="none";
        document.querySelector(".slideshow").style.display="none";
        document.querySelector(".fya-a").innerHTML="80G";
        document.querySelector(".fya-b").innerHTML="160G";
        document.querySelector(".fya-c").innerHTML="300G";
        document.querySelector(".dkb-a").innerHTML="50M";
        document.querySelector(".dkb-b").innerHTML="100G";
        document.querySelector(".dkb-c").innerHTML="200G";
        if(select2.value=="电信1U"){
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ggb-a")[i].innerHTML="1U";
            }
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ipb-a")[i].innerHTML="1个";
            }
            document.querySelector(".li_t_b_a").innerHTML="电信80G硬防型";
            document.querySelector(".li_t_b_b").innerHTML="电信160G硬防型";
            document.querySelector(".li_t_b_c").innerHTML="电信300G硬防型";
            
            document.querySelector(".yfb-a").innerHTML="900"
            document.querySelector(".yfb-b").innerHTML="8400";
            document.querySelector(".yfb-c").innerHTML="1700";
            document.querySelector(".nfb-a").innerHTML="16800";
            document.querySelector(".nfb-b").innerHTML="3400";
            document.querySelector(".nfb-a").innerHTML="34800";
        }
        if(select2.value=="电信2U"){
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ggb-a")[i].innerHTML="2U";
            }
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ipb-a")[i].innerHTML="1个";
            }
            document.querySelector(".li_t_b_a").innerHTML="电信80G硬防型";
            document.querySelector(".li_t_b_b").innerHTML="电信160G硬防型";
            document.querySelector(".li_t_b_c").innerHTML="电信300G硬防型";
            document.querySelector(".yfb-a").innerHTML="1100"
            document.querySelector(".yfb-b").innerHTML="10800";
            document.querySelector(".yfb-c").innerHTML="1900";
            document.querySelector(".nfb-a").innerHTML="19200";
            document.querySelector(".nfb-b").innerHTML="3600";
            document.querySelector(".nfb-a").innerHTML="37200";
        }
        if(select2.value=="联通1U"){
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ggb-a")[i].innerHTML="1U";
            }
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ipb-a")[i].innerHTML="1个";
            }
            document.querySelector(".li_t_b_a").innerHTML="联通80G硬防型";
            document.querySelector(".li_t_b_b").innerHTML="联通160G硬防型";
            document.querySelector(".li_t_b_c").innerHTML="联通300G硬防型";
            document.querySelector(".yfb-a").innerHTML="900"
            document.querySelector(".yfb-b").innerHTML="8400";
            document.querySelector(".yfb-c").innerHTML="1700";
            document.querySelector(".nfb-a").innerHTML="16800";
            document.querySelector(".nfb-b").innerHTML="3400";
            document.querySelector(".nfb-a").innerHTML="34800";
        }
        if(select2.value=="联通2U"){
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ggb-a")[i].innerHTML="2U";
            }
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ipb-a")[i].innerHTML="1个";
            }
            document.querySelector(".li_t_b_a").innerHTML="联通80G硬防型";
            document.querySelector(".li_t_b_b").innerHTML="联通160G硬防型";
            document.querySelector(".li_t_b_c").innerHTML="联通300G硬防型";
            document.querySelector(".yfb-a").innerHTML="1100"
            document.querySelector(".yfb-b").innerHTML="10800";
            document.querySelector(".yfb-c").innerHTML="1900";
            document.querySelector(".nfb-a").innerHTML="19200";
            document.querySelector(".nfb-b").innerHTML="3600";
            document.querySelector(".nfb-a").innerHTML="37200";
        }
        if(select2.value=="双线1U"){
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ggb-a")[i].innerHTML="1U";
            }
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ipb-a")[i].innerHTML="2个";
            }
            document.querySelector(".li_t_b_a").innerHTML="双线80G硬防型";
            document.querySelector(".li_t_b_b").innerHTML="双线160G硬防型";
            document.querySelector(".li_t_b_c").innerHTML="双线300G硬防型";
            document.querySelector(".yfb-a").innerHTML="1100"
            document.querySelector(".yfb-b").innerHTML="10800";
            document.querySelector(".yfb-c").innerHTML="1900";
            document.querySelector(".nfb-a").innerHTML="19200";
            document.querySelector(".nfb-b").innerHTML="3600";
            document.querySelector(".nfb-a").innerHTML="37200";
        }
        if(select2.value=="双线2U"){
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ggb-a")[i].innerHTML="2U";
            }
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ipb-a")[i].innerHTML="2个";
            }
            document.querySelector(".li_t_b_a").innerHTML="双线80G硬防型";
            document.querySelector(".li_t_b_b").innerHTML="双线160G硬防型";
            document.querySelector(".li_t_b_c").innerHTML="双线300G硬防型";
            document.querySelector(".yfb-a").innerHTML="1300"
            document.querySelector(".yfb-b").innerHTML="13200";
            document.querySelector(".yfb-c").innerHTML="2100";
            document.querySelector(".nfb-a").innerHTML="21600";
            document.querySelector(".nfb-b").innerHTML="3800";
            document.querySelector(".nfb-a").innerHTML="39600";
        }
        if(select2.value=="三线1U"){
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ggb-a")[i].innerHTML="1U";
            }
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ipb-a")[i].innerHTML="3个";
            }
            document.querySelector(".li_t_b_a").innerHTML="三线80G硬防型";
            document.querySelector(".li_t_b_b").innerHTML="三线160G硬防型";
            document.querySelector(".li_t_b_c").innerHTML="三线300G硬防型";
            document.querySelector(".yfb-a").innerHTML="1400"
            document.querySelector(".yfb-b").innerHTML="12000";
            document.querySelector(".yfb-c").innerHTML="2200";
            document.querySelector(".nfb-a").innerHTML="20400";
            document.querySelector(".nfb-b").innerHTML="3900";
            document.querySelector(".nfb-a").innerHTML="38400";
        }
        if(select2.value=="三线2U"){
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ggb-a")[i].innerHTML="2U";
            }
            for(var i=0; i<3;i++){
                document.querySelectorAll(".ipb-a")[i].innerHTML="3个";
            }
            document.querySelector(".li_t_b_a").innerHTML="三线80G硬防型";
            document.querySelector(".li_t_b_b").innerHTML="三线160G硬防型";
            document.querySelector(".li_t_b_c").innerHTML="三线300G硬防型";
            document.querySelector(".yfb-a").innerHTML="1600"
            document.querySelector(".yfb-b").innerHTML="14400";
            document.querySelector(".yfb-c").innerHTML="2400";
            document.querySelector(".nfb-a").innerHTML="22800";
            document.querySelector(".nfb-b").innerHTML="4100";
            document.querySelector(".nfb-a").innerHTML="40800";
        }
    }
    }
}