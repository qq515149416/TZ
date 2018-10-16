import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class WorkOrderTypeStores {
    constructor(data) {
        extendObservable(this,data);
    }
}
class WorkOrderTypesStores extends ActionBoundStores {
    @observable workOrderTypes = [

    ];
    addData(data) {
        return new Promise((resolve,reject) => {
            post("worktype/insert",data).then(res => {
                if(res.data.code==1) {
                    this.getData();
                    resolve(true);
                }else {
                    alert(res.data.msg);
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound 
    getData(param={}) {
        this.workOrderTypes = [];
        get("worktype/show",param).then((res) => {
            if(res.data.code==1) {
                this.workOrderTypes = res.data.data.map(item => new WorkOrderTypeStores(item));
            }
        });
    }
}
export default WorkOrderTypesStores;