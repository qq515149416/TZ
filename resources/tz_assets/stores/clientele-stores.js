import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class ClienteleStores {
    constructor(data) {
        extendObservable(this,data);
    }
}
class ClientelesStores extends ActionBoundStores {
    @observable clienteles = [

    ];
    bingSalesman(data) {
        return new Promise((resolve,reject) => {
            post("business/insert_clerk",data).then(res => {
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
    getData() {
        this.clienteles = [];
        get("business/admin_customer").then((res) => {
            if(res.data.code==1) {
                this.clienteles = res.data.data.map(item => new ClienteleStores(item));
            }
        });
    }
}
export default ClientelesStores;
