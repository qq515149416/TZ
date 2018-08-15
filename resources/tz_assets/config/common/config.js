import UsersInfoStores from "../../stores/users-info-stores.js";
import UsersLinkInfoStores from "../../stores/usersLink-info-stores.js";
import IpsStores from "../../stores/ip-stores";
import MachineRoomsStores from "../../stores/machineRoom-stores";
import NewsStores from "../../stores/new-stores";



// 前端Models操作
export const stores = {
    usersInfoStores: new UsersInfoStores(),//用户通信录
    usersLinkInfoStores: new UsersLinkInfoStores(),//用户联系人信息
    ipsStores: new IpsStores(),//ip资源库
    MachineRoomsStores: new MachineRoomsStores(),//机房管理
    newsStores: new NewsStores()
}
export const domIds = [
    "user_list",
    "link_user",
    "ip_list",
    "machine_room",
    "new"
];