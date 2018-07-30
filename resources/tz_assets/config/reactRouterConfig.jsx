import React from "react";
import {Route} from "react-router-dom";
import UsersList from "../view/usersList.jsx";
export default () => [
    <Route path="/" component={UsersList} />
];