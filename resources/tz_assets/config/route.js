import React from "react";
import {BrowserRouter} from "react-router-dom";
import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';
import { Provider, onError } from "mobx-react";
import blue from '@material-ui/core/colors/blue';
import deepOrange from '@material-ui/core/colors/deepOrange';
import {stores} from "./common/config.js";

const theme = createMuiTheme({
    palette: {
        primary: blue,
        secondary: deepOrange
    }
});
// mobx错误捕获
onError(error => {
    console.log(error);
});
/**
 * @augments ReactDOM 用来渲染react对象
 * @augments renderComponents 渲染列表
 * @augments id 当前渲染名称
 */
const Main = (Render) => {
    return (
        <BrowserRouter>
            <Provider {...stores}>
                <MuiThemeProvider theme={theme}>
                    <Render />
                </MuiThemeProvider>
            </Provider>
        </BrowserRouter>
    );
};
export default (ReactDOM,renderComponents,id) => {
    renderComponents.forEach((item) => {
        if(item.id == id) {
            let {itemRoute: ItemRoute} = item;
            ReactDOM.render(Main(ItemRoute),item.routeDOM);
        }
    });
}