import UsersInfoStores from "../../stores/users-info-stores.js";
import UsersLinkInfoStores from "../../stores/usersLink-info-stores.js";
import IpsStores from "../../stores/ip-stores";
import MachineRoomsStores from "../../stores/machineRoom-stores";
import NewsStores from "../../stores/new-stores";
import CpusStores from "../../stores/cpu-stores";
import HarddisksStores from "../../stores/harddisk-stores";
import MemorysStores from "../../stores/memory-stores";
import CabinetsStores from "../../stores/cabinet-stores";




// 前端Models操作
export const stores = {
    usersInfoStores: new UsersInfoStores(),//用户通信录
    usersLinkInfoStores: new UsersLinkInfoStores(),//用户联系人信息
    ipsStores: new IpsStores(),//ip资源库
    MachineRoomsStores: new MachineRoomsStores(),//机房管理
    newsStores: new NewsStores(),
    cpusStores: new CpusStores(),
    harddisksStores: new HarddisksStores(),
    memorysStores: new MemorysStores(),
    cabinetsStores: new CabinetsStores()
}
export const domIds = [
    "user_list",
    "link_user",
    "ip_list",
    "machine_room",
    "new",
    "cpu_list",
    "harddisk_list",
    "memory_list",
    "cabinet_list"
];