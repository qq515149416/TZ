import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class MachineLibraryStores {
    @observable id =  1;
    @observable machine_num =  "";
    @observable cpu =  "";
    @observable memory = "";
    @observable harddisk = "";
    @observable machineroom = 1;
    @observable machineroom_name = "";
    @observable cabinet = 1;
    @observable cabinets = "";
    @observable ip_id = 1;
    @observable ip = "";
    @observable ip_company = "";
    @observable bandwidth = "";
    @observable protect = "";
    @observable loginname = "";
    @observable loginpass = "";
    @observable machine_type = "";
    @observable used_status = 1;
    @observable used = "";
    @observable machine_status = 1;
    @observable status = "";
    @observable own_business = "";
    @observable business_end = "";
    @observable business_type = 1;
    @observable business = "";
    @observable machine_note = "";
    @observable created_at = "";
    @observable updated_at = "";
    constructor({
        id,
        machine_num,
        cpu,
        memory,
        harddisk,
        machineroom,
        machineroom_name,
        cabinet,
        cabinets,
        ip_id,
        ip,
        ip_company,
        bandwidth,
        protect,
        loginname,
        loginpass,
        machine_type,
        used_status,
        used,
        machine_status,
        status,
        own_business,
        business_end,
        business_type,
        business,
        machine_note,
        created_at,
        updated_at
    }) {
        Object.assign(this,{
            id,
            machine_num,
            cpu,
            memory,
            harddisk,
            machineroom,
            machineroom_name,
            cabinet,
            cabinets,
            ip_id,
            ip,
            ip_company,
            bandwidth,
            protect,
            loginname,
            loginpass,
            machine_type,
            used_status,
            used,
            machine_status,
            status,
            own_business,
            business_end,
            business_type,
            business,
            machine_note,
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
class IpsStores {
    @observable ipid = 1;
    @observable ip = "";
    constructor({ipid,ip}) {
        Object.assign(this,{
            ipid,
            ip
        });
    }
}
class CabinetStores {
    @observable cabinetid = 1;
    @observable cabinet_id = "";
    constructor({cabinetid,cabinet_id}) {
        Object.assign(this,{
            cabinetid,
            cabinet_id
        });
    }
}
class MachineLibrarysStores extends ActionBoundStores {
    @observable machineLibrarys = [

    ];
    @observable comprooms = [

    ];
    @observable cabinets = [

    ];
    @observable ips = [

    ];
    changeData(param) {
        return new Promise((resolve,reject) => {
            post("machine/editmachine",param).then((res) => {
                if(res.data.code==1) {
                    this.getData(param.business_type);
                    resolve(true);
                }else {
                    alert(res.data.msg);
                    resolve(false);
                }
            });
        });
    }
    addData(data) {
        return new Promise((resolve,reject) => {
            post("machine/insertmachine",data).then((res) => {
                if(res.data.code==1) {
                    this.getData(data.business_type);
                    resolve(true);
                } else {
                    alert(res.data.msg);
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    delData(id) {
        return new Promise((resolve,reject) => {
            post("machine/deletemachine",{
                delete_id: id
            }).then((res) => {
                if(res.data.code==1) {
                    this.delStoreData("machineLibrarys",id);
                    resolve(true);
                } else {
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound 
    getIpsData(param) {
        get("machine/ips",param).then((res) => {
            if(res.data.code==1) {
                this.ips = res.data.data.map(item => new IpsStores(item));
            }
        });
    }
    @action.bound 
    getCabinetsData(param) {
        get("machine/cabinets",param).then((res) => {
            if(res.data.code==1) {
                this.cabinets = res.data.data.map(item => new CabinetStores(item));
            }
        });
    }
    @action.bound 
    getData(type) {
        get("machine/machineroom").then((res) => {
            if(res.data.code==1) {
                this.comprooms = res.data.data.map(item => new ComproomStores(item));
            }
        });
        get("machine/showmachine",{
            business_type: type
        }).then(res => {
            if(res.data.code==1) {
                this.machineLibrarys = res.data.data.map(item => new MachineLibraryStores(item));
            }
        });
    }
}
export default MachineLibrarysStores;