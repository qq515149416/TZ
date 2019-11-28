import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";



class DefensePackageStores {
    constructor(data) {
        extendObservable(this,data);
    }
}

class DefensePackagesStores extends ActionBoundStores {
    @observable defensePackages = [

    ];
    delData(id) {
        return new Promise((resolve,reject) => {
            get("defenseip/package/del",{
                del_id: id
            }).then((res) => {
                if(res.data.code==1) {
                    this.delStoreData("defensePackages",id);
                    resolve(true);
                } else {
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    changeData(param) {
        return new Promise((resolve,reject) => {
            post("defenseip/package/edit",Object.assign(param,{
                edit_id: param.id
            })).then((res) => {
                if(res.data.code==1) {
                    this.getData({
                        site: 1
                    });
                    resolve(true);
                }else {
                    alert(res.data.msg);
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    addData(data) {
        return new Promise((resolve,reject) => {
            post("defenseip/package/insert",data).then((res) => {
                if(res.data.code==1) {
                    this.getData({
                        site: 1
                    });
                    resolve(true);
                } else {
                    alert(res.data.msg);
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound
    getData(param={}) {
        this.defensePackages = [];
        get("defenseip/package/show",param).then((res) => {
            if(res.data.code==1) {
                this.defensePackages = res.data.data.map(item => new DefensePackageStores(item));
            }
        });
    }
}
export default DefensePackagesStores;
