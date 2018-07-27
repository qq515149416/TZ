import React from "react";
import {BrowserRouter} from "react-router-dom";
/**
 * @augments ReactDOM 用来渲染react对象
 * @augments renderComponents 渲染列表
 * @augments id 当前渲染名称
 */
export default (ReactDOM,renderComponents,id) => {
    renderComponents.forEach((item) => {
        if(item.id == id) {
            let {itemRoute: ItemRoute} = item;
            ReactDOM.render((
                <BrowserRouter basename="/tz_admin">
                    {ItemRoute}
                </BrowserRouter>
            ),item.routeDOM);
        }
    });
}