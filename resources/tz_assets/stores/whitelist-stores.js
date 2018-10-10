import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class WhitelistStores {
    constructor(data) {
        extendObservable(this,data);
    }
}
class WhitelistsStores extends ActionBoundStores {
    @observable whitelists = [

    ];
    type = 0;
    @action.bound 
    getData(param={}) {
        this.whitelists = [];
        get("whitelist/show",Object.assign(param,{
            method: "showWhiteList"
        })).then((res) => {
            if(res.data.code==1) {
                this.whitelists = res.data.data.map(item => new WhitelistStores(item));
            }
        });
    }
}
export default WhitelistsStores;