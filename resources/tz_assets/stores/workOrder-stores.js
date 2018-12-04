import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');

class WorkOrderStores {
    constructor(data) {
        extendObservable(this,data);
    }
}
class DepartmentStores {
    constructor(data) {
        extendObservable(this,data);
    }
}

class WorkOrdersStores extends ActionBoundStores {
    @observable workOrders = [

    ];
    @observable department = [

    ];
    type = 0;
    delData(id) {
        return new Promise((resolve,reject) => {
            post("workorder/delete",{
                delete_id: id
            }).then((res) => {
                if(res.data.code==1) {
                    this.delStoreData("workOrders",id);
                    resolve(true);
                } else {
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound
    getDepartments() {
        if(!this.department.length) {
            get("hr/show_depart").then(res => {
                if(res.data.code==1) {
                    this.department = res.data.data.map(item => new DepartmentStores(item));
                }
            })
        }
    }
    @action.bound
    addData(data) {
        this.workOrders.unshift(new WorkOrderStores(Object.assign(data,{
            resource_detail_json: JSON.parse(data.resource_detail)
        })));
    }
    @action.bound
    getData(param={}) {
        this.workOrders = [];
        get("workorder/show",Object.assign(param,{
            work_order_status: this.type
        })).then((res) => {
            if(res.data.code==1) {
                this.getDepartments();
                this.workOrders = res.data.data.map(item => new WorkOrderStores(Object.assign(item,{
                    resource_detail_json: JSON.parse(item.resource_detail)
                })));
            }
        });
    }
}
export default WorkOrdersStores;
