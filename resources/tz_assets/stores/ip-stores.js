import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
const dateFormat = require('dateformat');
class IpStores {
    @observable id =  1;
    @observable ip =  "";
    @observable vlan ="";
    @observable ip_company = "";
    @observable ip_status = "";
    @observable ip_lock = "";
    @observable ip_note = "";
    @observable ip_comproom = "";
    @observable ip_comproomname = "";
    @observable created_at = "";
    @observable updated_at = "";
    constructor({id, ip, vlan, ip_company, ip_status, ip_lock, ip_note, ip_comproom,ip_comproomname,created_at,updated_at}) {
        Object.assign(this,{
            id,
            ip,
            vlan,
            ip_company,
            ip_status,
            ip_lock,
            ip_note,
            ip_comproom,
            ip_comproomname,
            created_at,
            updated_at
        });
    }
}
class ComproomStores {
    
}
class IpsStores {
    @observable ips = [

    ];
    @observable comprooms = [

    ];
    @action.bound 
    getData() {
        get("ips/index").then((res) => {
            if(res.data.code==1) {
                this.ips = res.data.data.map(item => new IpStores({
                    ...{
                        id: item.id,
                        ip: item.ip,
                        vlan: item.vlan,
                        ip_company: item.ip_company,
                        ip_status: item.ip_status,
                        ip_lock: item.ip_lock,
                        ip_note: item.ip_note,
                        ip_comproom: item.ip_comproom,
                        ip_comproomname: item.ip_comproomname,
                        created_at: item.created_at || dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        updated_at: item.updated_at || dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss")
                    }
                }));
            }
        });
    }
}
export default IpsStores;