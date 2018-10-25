import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class ClienteleStores {
    @observable id = 1;
    @observable name = "";
    @observable email = "";
    @observable money = "";
    @observable clerk_name = "";
    @observable status = "";
    @observable created_at = "";
    @observable updated_at = "";
    constructor({id, name, email, money, clerk_name, status, created_at = dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"), updated_at = dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss")}) {
        Object.assign(this,{
            id,
            name,
            email,
            money,
            clerk_name,
            status,
            created_at,
            updated_at
        });
    }
}
class ClientelesStores extends ActionBoundStores {
    @observable clienteles = [

    ];
    @action.bound 
    getData() {
        get("business/admin_customer").then((res) => {
            if(res.data.code==1) {
                this.clienteles = res.data.data.map(item => new ClienteleStores(item));
            }
        });
    }
}
export default ClientelesStores;