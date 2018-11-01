import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";

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
        get("business/showRecharge").then((res) => {
            if(res.data.code==1) {
                this.recharge = res.data.data.map(item => new RechargeStores(item));
            }
        });
    }
}
export default RechargesStores;
