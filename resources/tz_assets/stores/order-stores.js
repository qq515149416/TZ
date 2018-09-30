import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class OrderStores {
    @observable id =  1;
    @observable order_sn =  "";
    @observable customer_name ="";
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
    @observable created_at = "";
    constructor({
        id, 
        order_sn,
        customer_name,
        business_sn,
        business_name,
        before_money,
        after_money,
        resource_type,
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
        created_at
    }) {
        Object.assign(this,{
            id,
            order_sn,
            customer_name,
            business_sn,
            business_name,
            before_money,
            after_money,
            resource_type,
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
            created_at
        });
    }
}
class OrdersStores extends ActionBoundStores {
    @observable orders = [

    ];
    @action.bound 
    getData(data) {
        post("business/clerk",data).then(res => {
            if(res.data.code==1) {
                this.orders = res.data.data.map(item => new OrderStores(item));
            }
        });
    }
}
export default OrdersStores;