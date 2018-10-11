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
    @observable binding_machine = "";
    @observable customer_id = "";
    @observable customer_name = "";
    type = 0;
    @action.bound 
    handleChange(param) {
        if(param.binding_machine) {
            this.binding_machine = param.binding_machine;
        }
        if(param.customer_name) {
            this.customer_name = param.customer_name;
        }
        if(param.customer_id) {
            this.customer_id = param.customer_id;
        }
    }
    @action.bound 
    getIpParam(ip) {
        get("whitelist/checkIP",{
            ip,
            method: "checkIP"
        }).then((res) => {
            if(res.data.code==1) {
                this.handleChange(res.data.data);
            }
        });
    }
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