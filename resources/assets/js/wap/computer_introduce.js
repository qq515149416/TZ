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
