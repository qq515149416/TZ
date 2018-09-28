import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class BusinesStores {
    @observable id =  1;
    @observable client_id = 1;
    @observable client_name = "";
    @observable sales_id = 1;
    @observable sales_name = "";
    @observable order_number = "";
    @observable business_number = "";
    @observable business_type = "";
    @observable type = "";
    @observable machine_number = "";
    @observable resource_detail = "";
    @observable business_status = "";
    @observable money = 0;
    @observable length = 0;
    @observable start_time = "";
    @observable endding_time = "";
    @observable business_note = "";
    @observable status = "";
    constructor({
        id, 
        client_id, 
        client_name, 
        sales_id, 
        sales_name, 
        order_number, 
        business_number, 
        business_type,
        machine_number,
        resource_detail,
        business_status,
        money,
        length,
        start_time,
        endding_time,
        business_note,
        type,
        status
    }) {
        Object.assign(this,{
            id,
            client_id,
            client_name,
            sales_id,
            sales_name,
            order_number,
            business_number,
            business_type,
            machine_number,
            resource_detail,
            business_status,
            money,
            length,
            start_time,
            endding_time,
            business_note,
            type,
            status
        });
    }
}
class BusinessStores extends ActionBoundStores {
    @observable business = [

    ];
    addData(data) {
        return new Promise((resolve,reject) => {
            post("business/insert",data).then(res => {
                if(res.data.code==1) {
                    // this.addStoreData("business",BusinesStores,Object.assign(JSON.parse(data.resource_detail),{
                    //     id: res.data.data
                    // }));
                    this.getData(data.client_id);
                    resolve(true);
                }else {
                    alert(res.data.msg);
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound 
    getAllData() {
        get("business/security").then(res => {
            if(res.data.code==1) {
                this.business = res.data.data.map(item => new BusinesStores(item));
            }
        });
    }
    @action.bound 
    getData(id) {
        get("business/showbusiness",{
            client_id: id
        }).then(res => {
            if(res.data.code==1) {
                this.business = res.data.data.map(item => new BusinesStores(item));
            }
        });
    }
}
export default BusinessStores;
