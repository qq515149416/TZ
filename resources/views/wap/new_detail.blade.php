@extends('wap.layout')

@section('title', '专业IDC服务商,云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速')

@section('keywords', '云主机，高防服务器，高防IP，服务器租用,服务器托管，带宽租用,CDN加速,高防CDN,云服务器,机柜租用,云计算,IDC服务器商,腾正科技')

@section('description', '腾正科技专业IDC服务提供商，主营服务器租用、服务器托管、机柜大带宽租用、云主机、高防服务器、高防IP、CDN加速等数据存储、计算及安全综合应用解决方案服务。')

@section('content')
<div>
<!-- 企业文化 -->
<div id="company_introduction_news">
        <div class="main-body">
            <div class="tz-container clear">

                <!-- 内容 -->
                <div class="main-content">
                    <div class="posters">
                        <img src="{{ asset("/images/wap/企业文化海报.png") }}" alt="">
                        <a class="posters-btn">立即咨询</a>
                    </div>
                    <div class="drop-options">
                        <div class="drop-options">  
                            <p onclick="machineroom(this)">新闻公告</p>
                            <span class="arrow"></span>
                            <ul class="select-text clear">
                                <li class="option-i" value="0" selected><a href="/wap/company/company_introduction">公司简介</a></li>
                                <li class="option-i" value="1"><a href="/wap/company/news">新闻公告</a></li>
                                <li class="option-i" value="2"><a href="/wap/company/honor">荣誉资质</a></li>
                                <li class="option-i" value="3"><a href="/wap/company/culture">企业文化</a></li>
                                <li class="option-i" value="4"><a href="/wap/company/progress">发展历程</a></li>
                                <li class="option-i" value="5"><a href="/wap/company/contact">联系我们</a></li>
                                <li class="option-i" value="6"><a href="/wap/company/pay">支付中心</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- 新闻公告 内容页 -->
                    <div class="news-content ">
                        <div class="content">
                            <div class="content-title">
                                腾正科技关于2019年端午节放假通知
                            </div>
                            <div class="content-time">2019-06-06 12:03:39</div>
                            <div class="content-main">
                                您好!端午节将至，根据《国务院办公厅关于 2019 年部分节假日安排通知》，我司定于2019年6月7日至6月9日放假，共3天。
                            </div>
                            <div class="content-text clear">
                                <div>
                                    <p>尊敬的腾正用户：</p>
                                    <p> 　　您好!端午节将至，根据《国务院办公厅关于 2019
                                        年部分节假日安排通知》，我司定于2019年6月7日至6月9日放假，共3天。放假期间，我司安排工作人员24小时值班，为您提供不间断的业务咨询，技术方案，售后处理等服务。感谢您一直以来对腾正科技的支持和信任！在此提前祝您国庆节快乐！
                                    </p>

                                </div>
                                <div>
                                    <p>24小时技术专线：0769-22385558 15399941777</p>
                                    <p>售后服务企业QQ：800093515</p>
                                    <p>业务咨询电话：18922986777、18028237786</p>
                                    <p>企业QQ：2851506990、2853978334</p>
                                </div>
                                <div>
                                    <p>温馨提示：</p>
                                    <p>1.放假期间避免进行重大业务变更</p>
                                    <p>2.提前安排运维监控和合理备份</p>
                                    <p>3.请关注余额和资源到期时间，如有需要及时续费</p>
                                    <p>4.备案咨询业务正常，审核业务因通信管理局假期原因暂停，6月10日恢复正常</p>
                                </div>
                                <div>
                                    <p>腾正科技</p>
                                    <p>2019年6月6日</p>
                                </div>
                            </div>
                        </div>
                        <div class="news-more">
                            <p>上一篇：实现腾正科技共赢|腾正科技...</p>
                            <p>下一篇：没有了</p>
                            <img src="{{ asset("/images/wap/内容页按钮.png") }}" alt="">
                        </div>
                    </div>

                    <!-- 蓝条 -->
                    <!-- <div class="solutions-consulting">
                        <img src="{{ asset("/images/wap/企业文化蓝条.png") }}" alt="">
                        <a>
                            立即咨询
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
// 公司简介
machineroom();
function machineroom(){
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
    // var option_text = document.querySelectorAll(".option-text");
    // var option_i = document.querySelectorAll(".option-i");
    // var p_value = document.querySelector(".drop-options p");
    // for(var i=0;i<option_i.length;i++){
    //   option_i[i].index=i;
    //   option_i[i].addEventListener("click",function(){
    //     for(var j=0;j<option_text.length;j++){
    //       option_text[j].className="option-text";
    //     }
    //     document.querySelector(".news-content").style.display="none";
    //     option_text[this.index].className="option-text option-e-active";
    //     p_value.innerHTML=option_i[this.index].innerHTML;
  
    //   })
    // }
  
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
</script>

@endsection
