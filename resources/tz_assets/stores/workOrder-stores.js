import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');

class WorkOrderStores {
    constructor(data) {
        extendObservable(this,data);
    }
}

class WorkOrdersStores extends ActionBoundStores {
    @observable workOrders = [

    ];
    type = 0;
    @action.bound 
    getData(param={}) {
        this.workOrders = [];
        get("workorder/show",Object.assign(param,{
            work_order_status: this.type
        })).then((res) => {
            if(res.data.code==1) {
                this.workOrders = res.data.data.map(item => new WorkOrderStores(item));
            }
        });
    }
}
export default WorkOrdersStores;