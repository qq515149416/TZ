import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
const qs = require('qs');

class RechargeStores {
    constructor(data) {
        extendObservable(this,data);
    }
}

class RechargesStores {
    @observable recharge = [

    ];
    @action.bound
    getData(param={}) {
        let BASE_URL = "business/showRecharge";
        if(location.search.indexOf("?type=all") > -1) {
            BASE_URL = "business/showAllRecharge";
        }
        get(BASE_URL,param).then((res) => {
            if(res.data.code==1) {
                this.recharge = res.data.data.map(item => new RechargeStores(item));
            }
        });
    }
}
export default RechargesStores;
