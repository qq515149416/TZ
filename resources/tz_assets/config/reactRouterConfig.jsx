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
    <Route path="/tz_admin/business" component={BusinesList} />,
    <Route path="/tz_admin/checkbusiness" component={CheckBusinessList} />
];