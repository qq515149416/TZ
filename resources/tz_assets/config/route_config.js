import React from "react";
// import UsersList from "../view/usersList.jsx";
import ReactRouterConfig from "./reactRouterConfig.js";
export default [
    {
        id: "user_list",
        routeDOM: document.getElementById("user_list"),
        itemRoute: ReactRouterConfig
    },
    {
        id: "link_user",
        routeDOM: document.getElementById("link_user"),
        itemRoute: null
    }
];