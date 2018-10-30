import UsersInfoStores from "../../stores/users-info-stores.js";
import UsersLinkInfoStores from "../../stores/usersLink-info-stores.js";
import IpsStores from "../../stores/ip-stores";
import MachineRoomsStores from "../../stores/machineRoom-stores";
import NewsStores from "../../stores/new-stores";
import CpusStores from "../../stores/cpu-stores";
import HarddisksStores from "../../stores/harddisk-stores";
import MemorysStores from "../../stores/memory-stores";
import CabinetsStores from "../../stores/cabinet-stores";
import MachineLibrarysStores from "../../stores/machineLibrary-stores";
import EmployeeManagementsStores from "../../stores/employeeManagement-stores";
import ClientelesStores from "../../stores/clientele-stores";
import BusinessStores from "../../stores/business-stores";
import OrdersStores from "../../stores/order-stores";
import FinancesStores from "../../stores/finance-stores";
import StatisticalPerformancesStores from "../../stores/statisticalPerformance-stores";
import WhitelistsStores from "../../stores/whitelist-stores";
import WorkOrderTypesStores from "../../stores/workOrderType-stores";
import WorkOrdersStores from "../../stores/workOrder-stores";
import DepartmentsStores from "../../stores/department-stores";
import PositionsStores from "../../stores/position-stores";
import UsersStores from "../../stores/user-stores";

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
    cabinetsStores: new CabinetsStores(),
    machineLibrarysStores: new MachineLibrarysStores(),
    employeeManagementsStores: new EmployeeManagementsStores(),
    clientelesStores: new ClientelesStores(),
    businessStores: new BusinessStores(),
    ordersStores: new OrdersStores(),
    financesStores: new FinancesStores(),
    statisticalPerformancesStores: new StatisticalPerformancesStores(),
    whitelistsStores: new WhitelistsStores(),
    workOrderTypesStores: new WorkOrderTypesStores(),
    workOrdersStores: new WorkOrdersStores(),
    departmentsStores: new DepartmentsStores(),
    positionsStores: new PositionsStores(),
    usersStores: new UsersStores()
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
    "cabinet_list",
    "machine_library",
    "employeeManagement_list",
    "clientele",
    "business",
    "checkBusiness",
    "order",
    "finance",
    "statisticalPerformance",
    "whitelist",
    "workOrderType",
    "workOrder",
    "home",
    "department",
    "position",
    "user"
];
