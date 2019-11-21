// 机房介绍
computer_introduce();
function computer_introduce() {
    if(!document.getElementsByClassName("region").length) {
        return ;
    }
    var computer_Room = document.getElementsByClassName("region")[0];
    var computerRoom = computer_Room.getElementsByTagName("p");
    var computer_Content = document.getElementsByClassName("computer-content")[0];
    var computerContent =computer_Content.getElementsByTagName("table");
    for(var i=0;i<computerRoom.length;i++){
    computerRoom[i].index=i;
    computerRoom[i].onclick=function(){
        for(var k=0;k<computerRoom.length;k++){
        computerRoom[k].className=" ";
        computerContent[k].className=" ";
        }
        this.className="active-room";
        computerContent[this.index].className="active-tab";
    }
    }
}
//机房选择
// machineroomtext();
// function machineroomtext(){
    if(document.querySelector("#cabinet_to_rent") || document.querySelector("#bandwidth_to_ent")){
    document.querySelector("#select-room-a").onchange = function(){
  var option_text_a = document.querySelectorAll(".option-text-a");
  var select_room_a = document.querySelector("#select-room-a");
  for(var i=0;i<option_text_a.length;i++){
    option_text_a[i].index=i;
    if(select_room_a.value==i){
      console.log(i);
      for(var j=0;j<option_text_a.length;j++){
      option_text_a[j].className="option-text-a";
    }
    option_text_a[i].className="option-text-a option-e-active";
  }
  }
}
}
