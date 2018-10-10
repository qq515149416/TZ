import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class OrderStores {
    @observable id =  1;
    @observable order_sn =  "";
    @observable customer_name ="";
    @observable customer_id ="";
    @observable business_sn = "";
    @observable business_name = "";
    @observable before_money = "";
    @observable after_money = "";
    @observable resource_type = "";
    @observable order_type = "";
    @observable resource = "";
    @observable price = "";
    @observable duration = "";
    @observable payable_money = "";
    @observable end_time = "";
    @observable pay_type = "";
    @observable pay_price = "";
    @observable serial_number = "";
    @observable pay_time = "";
    @observable order_status = "";
    @observable order_note = "";
    @observable machine_sn = "";
    @observable created_at = "";
    constructor({
        id, 
        order_sn,
        customer_name,
        customer_id,
        business_sn,
        business_name,
        before_money,
        after_money,
        resource_type,
        resourcetype,
        order_type,
        resource,
        price,
        duration,
        payable_money,
        end_time,
        pay_type,
        pay_price,
        serial_number,
        pay_time,
        order_status,
        order_note,
        machine_sn,
        created_at
    }) {
        Object.assign(this,{
            id,
            order_sn,
            customer_name,
            customer_id,
            business_sn,
            business_name,
            before_money,
            after_money,
            resource_type,
            resourcetype,
            order_type,
            resource,
            price,
            duration,
            payable_money,
            end_time,
            pay_type,
            pay_price,
            serial_number,
            pay_time,
            order_status,
            order_note,
            machine_sn,
            created_at
        });
    }
}
class ResourceStores {
    @observable label = "";
    @observable value = "";
    constructor({label,value}) {
        Object.assign(this,{
            label,
            value
        });
    }
}
class OrdersStores extends ActionBoundStores {
    @observable orders = [

    ];
    @observable resource =[

    ];
    type = null;
    addData(data) {
        return new Promise((resolve,reject) => {
            post("business/insertresource",data).then(res => {
                if(res.data.code==1) {
                    // this.addStoreData("business",BusinesStores,Object.assign(JSON.parse(data.resource_detail),{
                    //     id: res.data.data
                    // }));
                    if(this.type) {
                        this.getData({
                            business_sn: data.business_sn,
                            resource_type: this.type
                        });
                    } else {
                        this.getData({
                            business_sn: data.business_sn
                        });
                    }
                   
                    resolve(true);
                }else {
                    alert(res.data.msg);
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound 
    getResourceData(param) {
        post("business/resource",param).then((res) => {
            if(res.data.code==1) {
                this.resource = res.data.data.map(item => new ResourceStores(item));
            }
        });
    }
    @action.bound 
    getData(data) {
        post("business/clerk",data).then(res => {
            this.orders = [];
            if(res.data.code==1) {
                this.orders = res.data.data.map(item => new OrderStores(item));
            }
        });
    }
}
export default OrdersStores;