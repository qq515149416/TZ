import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class BusinesStores {
    @observable id =  1;
    @observable client_id = 1;
    @observable client_name = "";
    @observable sales_id = 1;
    @observable slaes_name = "";
    @observable order_number = "";
    @observable business_number = "";
    @observable business_type = "";
    @observable machine_number = "";
    @observable resource_detail = "";
    @observable business_status = "";
    @observable money = 0;
    @observable length = 0;
    @observable start_time = "";
    @observable endding_time = "";
    @observable business_note = "";
    constructor({
        id, 
        client_id, 
        client_name, 
        sales_id, 
        slaes_name, 
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
        business_note
    }) {
        Object.assign(this,{
            id,
            client_id,
            client_name,
            sales_id,
            slaes_name,
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
            business_note
        });
    }
}
class BusinessStores extends ActionBoundStores {
    @observable business = [

    ];
    addData(data) {
        
    }
    @action.bound 
    getData(id) {
        get("business/showbusiness",{
            client_id: id
        }).then(res => {
            if(res.data.code==1) {
                this.business = res.data.data.map(item => new BusinesStores(item));
            }
        })
    }
}
export default BusinessStores;
