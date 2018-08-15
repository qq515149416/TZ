import React from "react";
import {Route} from "react-router-dom";
import UsersList from "../view/usersList.jsx";
import UsersLinkList from "../view/usersLinkList.jsx";
import IpList from "../view/ipList.jsx";
import MachineRoomList from "../view/machineRoomList.jsx";
import NewList from "../view/newList.jsx";
export default () => [
    <Route path="/tz_admin/user_list" component={UsersList} />,
    <Route path="/tz_admin/user_link_list" component={UsersLinkList} />,
    <Route path="/tz_admin/resource/ip" component={IpList} />,
    <Route path="/tz_admin/resource/machine_room" component={MachineRoomList} />,
    <Route path="/tz_admin/article" component={NewList} />,
];