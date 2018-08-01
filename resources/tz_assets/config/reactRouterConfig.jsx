import React from "react";
import {Route} from "react-router-dom";
import UsersList from "../view/usersList.jsx";
import UsersLinkList from "../view/usersLinkList.jsx";

export default () => [
    <Route path="/tz_admin/user_list" component={UsersList} />,
    <Route path="/tz_admin/user_link_list" component={UsersLinkList} />
];