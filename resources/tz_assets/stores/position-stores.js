import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');

class PositionStores {
    constructor(data) {
        extendObservable(this,data);
    }
}
class DepartmentStores {
    constructor(data) {
        extendObservable(this,data);
    }
}
class PositionsStores extends ActionBoundStores {
    @observable positions = [

    ];
    @observable departments = [

    ];
    sign_state = {
        "1": "普通",
        "2": "部门主管",
        "3": "业务员",
        "4": "机房人员",
        "5": "财务人员"
    };
    changeData(param) {
        return new Promise((resolve,reject) => {
            post("hr/edit_jobs",param).then((res) => {
                if(res.data.code==1) {
                    // this.getData();
                    this.changeStoreData("positions",PositionStores,Object.assign(param,{
                        sign_name: this.sign_state[param.sign],
                        created_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        updated_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        depart: this.departments.find(item => item.id == param.depart_id).depart_name
                    }));
                    resolve(true);
                }else {
                    alert(res.data.msg);
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    delData(id) {
        return new Promise((resolve,reject) => {
            post("hr/delete_jobs",{
                delete_id: id
            }).then((res) => {
                if(res.data.code==1) {
                    this.delStoreData("positions",id);
                    resolve(true);
                } else {
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    addData(data) {
        return new Promise((resolve,reject) => {
            post("hr/insert_jobs",data).then((res) => {
                if(res.data.code==1) {
                    this.addStoreData("positions",PositionStores,Object.assign(data,{
                        id: res.data.data,
                        sign_name: this.sign_state[data.sign],
                        created_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        updated_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        depart: this.departments.find(item => item.id == data.depart_id).depart_name
                    }));
                    resolve(true);
                } else {
                    alert(res.data.msg);
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound 
    getDepartmentsData(param={}) {
        this.departments = [];
        get("hr/depart").then((res) => {
            if(res.data.code==1) {
                this.departments = res.data.data.map(item => new DepartmentStores(item));
            }
        });
    }
    @action.bound 
    getData(param={}) {
        this.positions = [];
        get("hr/show_jobs").then((res) => {
            if(res.data.code==1) {
                this.positions = res.data.data.map(item => new PositionStores(item));
            }
        });
    }
}
export default PositionsStores;