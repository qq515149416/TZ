import React from "react";
import {Route} from "react-router-dom";
import UsersList from "../view/usersList.jsx";
import UsersLinkList from "../view/usersLinkList.jsx";
import IpList from "../view/ipList.jsx";
import MachineRoomList from "../view/machineRoomList.jsx";
import NewList from "../view/newList.jsx";
import CpuList from "../view/cpuList.jsx";
import HarddiskList from "../view/harddiskList.jsx";
import MemoryList from "../view/memoryList.jsx";
import CabinetList from "../view/cabinetList.jsx";
import MachineLibraryList from "../view/machineLibraryList.jsx";
import EmployeeManagementList from "../view/employeeManagementList.jsx";
import ClienteleList from "../view/clienteleList.jsx";
import BusinesList from "../view/businesList.jsx";
import CheckBusinessList from "../view/checkBusinessList.jsx";
import OrderList from "../view/orderList.jsx";
import FinanceList from "../view/financeList.jsx";
import StatisticalPerformanceList from "../view/statisticalPerformanceList.jsx";
import WhitelistList from "../view/whitelistList.jsx";
import WorkOrderTypeList from "../view/workOrderTypeList.jsx";
import WorkOrderList from "../view/workOrderList.jsx";
import Home from "../view/home.jsx";
import DepartmentList from "../view/departmentList.jsx";
import PositionList from "../view/positionList.jsx";
import UserList from "../view/userList.jsx";
import RechargeList from "../view/rechargeList.jsx";
import ReviewRechargeList from "../view/reviewRechargeList.jsx";
import DefenseipList from "../view/defenseipList.jsx";
import DefensePackageList from "../view/defensePackageList.jsx";
import DefenseBusinesList from "../view/defenseBusinesList.jsx";
import DefenseipReviewList from "../view/defenseipReviewList.jsx";




export default () => [
    <Route path="/tz_admin/user_list" component={UsersList} />,
    <Route path="/tz_admin/user_link_list" component={UsersLinkList} />,
    <Route path="/tz_admin/resource/ip" component={IpList} />,
    <Route path="/tz_admin/resource/machine_room" component={MachineRoomList} />,
    <Route path="/tz_admin/article" component={NewList} />,
    <Route path="/tz_admin/resource/cpu" component={CpuList} />,
    <Route path="/tz_admin/resource/harddisk" component={HarddiskList} />,
    <Route path="/tz_admin/resource/memory" component={MemoryList} />,
    <Route path="/tz_admin/resource/cabinet" component={CabinetList} />,
    <Route path="/tz_admin/resource/machinelibrary" component={MachineLibraryList} />,
    <Route path="/tz_admin/hr/employeeManagement" component={EmployeeManagementList} />,
    <Route path="/tz_admin/crm/clientele" component={ClienteleList} />,
    <Route path="/tz_admin/business" exact component={BusinesList} />,
    <Route path="/tz_admin/checkbusiness" component={CheckBusinessList} />,
    <Route path="/tz_admin/business/order" component={OrderList} />,
    <Route path="/tz_admin/finance" component={FinanceList} />,
    <Route path="/tz_admin/statisticalPerformance" component={StatisticalPerformanceList} />,
    <Route path="/tz_admin/whitelist" component={WhitelistList} />,
    <Route path="/tz_admin/work_order_type" component={WorkOrderTypeList} />,
    <Route path="/tz_admin/work_order" component={WorkOrderList} />,
    <Route path="/tz_admin" component={Home} exact />,
    <Route path="/tz_admin/hr/departmentview" component={DepartmentList} />,
    <Route path="/tz_admin/hr/position" component={PositionList} />,
    <Route path="/tz_admin/hr/usermanagement" component={UserList} />,
    <Route path="/tz_admin/checkrecharge" component={RechargeList} />,
    <Route path="/tz_admin/reviewRecharge" component={ReviewRechargeList} />,
    <Route path="/tz_admin/defenseip" component={DefenseipList} />,
    <Route path="/tz_admin/defensePackage" component={DefensePackageList} />,
    <Route path="/tz_admin/defenseBusines" component={DefenseBusinesList} />,
    <Route path="/tz_admin/defenseipReview" component={DefenseipReviewList} />,
];
