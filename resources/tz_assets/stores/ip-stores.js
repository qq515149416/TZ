import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
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
    @observable machine_room_id = "";
    @observable machine_room_name = "";
    @observable roomid = 1;
    constructor({machine_room_id,machine_room_name,roomid}) {
        Object.assign(this,{
            machine_room_id,
            machine_room_name,
            roomid
        });
    }
}
class IpsStores extends ActionBoundStores {
    @observable ips = [

    ];
    @observable comprooms = [

    ];
    stateText(state,codes) {
        return codes[state];
    }
    changeData(param) {
        return new Promise((resolve,reject) => {
            // delete param.ip;
            param.ip_start = param.ip;
            post("ips/alerting",param).then((res) => {
                if(res.data.code==1) {
                    this.changeStoreData("ips",IpStores,Object.assign(param,{
                        ip_company: this.stateText(String(param.ip_company),{
                            "0" : "电信公司",
                            "1": "移动公司",
                            "2": "联通公司"
                        }),
                        ip_status: this.stateText(String(param.ip_status),{
                            "0" : "未使用",
                            "1": "使用(子IP)",
                            "2": "使用(内部机器主IP)",
                            "3": "使用(托管主机的主IP)"
                        }),
                        ip_lock: this.stateText(String(param.ip_lock),{
                            "0" : "未锁定",
                            "1": "锁定"
                        }),
                        ip_comproomname: this.comprooms.find(item => item.roomid==param.ip_comproom).machine_room_name,
                        created_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        updated_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss")
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
            post("ips/remove",{
                delete_id: id
            }).then((res) => {
                if(res.data.code==1) {
                    this.delStoreData("ips",id);
                    resolve(true);
                } else {
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    addData(data) {
        return new Promise((resolve,reject) => {
            post("ips/insert",data).then((res) => {
                if(res.data.code==1) {
                    this.addStoreData("ips",IpStores,Object.assign(data,{
                        id: res.data.data,
                        ip_company: this.stateText(String(data.ip_company),{
                            "0" : "电信公司",
                            "1": "移动公司",
                            "2": "联通公司"
                        }),
                        ip_status: this.stateText(String(data.ip_status),{
                            "0" : "未使用",
                            "1": "使用(子IP)",
                            "2": "使用(内部机器主IP)",
                            "3": "使用(托管主机的主IP)"
                        }),
                        ip_lock: this.stateText(String(data.ip_lock),{
                            "0" : "未锁定",
                            "1": "锁定"
                        }),
                        ip_comproomname: this.comprooms.find(item => item.roomid==data.ip_comproom).machine_room_name,
                        created_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        updated_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss")
                    }));
                    resolve(true);
                }else if(res.data.code==2) {
                    this.getData();
                    resolve(true);
                } else {
                    alert(res.data.msg);
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound 
    getData() {
        get("ips/machineroom").then((res) => {
            if(res.data.code==1) {
                this.comprooms = res.data.data.map(item => new ComproomStores(item));
            }
        });
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