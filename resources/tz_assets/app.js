import React from "react";
import ReactDOM from "react-dom";
import route from "./config/route.js";
import route_config from "./config/route_config.js";
require('jquery');
$(function() {
    if(document.getElementById("user_list")) {
        route(ReactDOM,route_config,"user_list");
    }
});


