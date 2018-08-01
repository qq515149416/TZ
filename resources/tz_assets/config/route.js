import React from "react";
import {BrowserRouter} from "react-router-dom";
import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';
import { Provider } from "mobx-react";
import UsersInfoStores from "../stores/users-info-stores.js";
import UsersLinkInfoStores from "../stores/usersLink-info-stores.js";

const theme = createMuiTheme({
    palette: {
        primary: {
            light: "#FFF59D",
            main: "#FFEB3B",
            dark: "#FBC02D",
            contrastText: "#fff"
        },
        secondary: {
            light: '#FFE082',
            main: '#FFC107',
            dark: '#FFA000',
            contrastText: '#333'
        }
    }
});
/**
 * @augments ReactDOM 用来渲染react对象
 * @augments renderComponents 渲染列表
 * @augments id 当前渲染名称
 */
let stores = {
    usersInfoStores: new UsersInfoStores(),
    usersLinkInfoStores: new UsersLinkInfoStores()
}
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