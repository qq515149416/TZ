import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class CabinetStores {
    @observable id =  1;
    @observable machineroom_id =  "";
    @observable cabinet_id ="";
    @observable use_state = "";
    @observable machine_count = "";
    @observable machine_room_name = "";
    @observable use_state_cn = "";
    @observable use_type_cn = "";
    @observable created_at = "";
    @observable updated_at = "";
    constructor({id, machineroom_id, cabinet_id, use_state, machine_count, machine_room_name, use_state_cn, use_type_cn,created_at,updated_at}) {
        Object.assign(this,{
            id,
            machineroom_id,
            cabinet_id,
            use_state,
            machine_count,
            machine_room_name,
            use_state_cn,
            use_type_cn,
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
class CabinetsStores extends ActionBoundStores {
    @observable cabinets = [

    ];
    @observable comprooms = [

    ];
    stateText(state,codes) {
        return codes[state];
    }
    addData(data) {
        return new Promise((resolve,reject) => {
            post("cabinet/storeByAjax",data).then((res) => {
                if(res.data.code==1) {
                    this.addStoreData("cabinets",CabinetStores,Object.assign(data,{
                        id: res.data.data,
                        use_type_cn: this.stateText(String(data.use_type),{
                            "0" : "内部机柜",
                            "1": "客户机"
                        }),
                        machine_count: 0,
                        use_state_cn: "未使用",
                        machine_room_name: this.comprooms.find(item => item.roomid==data.machineroom_id).machine_room_name,
                        created_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        updated_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss")
                    }));
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
        get("cabinet/showByAjax").then((res) => {
            if(res.data.code==1) {
                this.cabinets = res.data.data.map(item => new CabinetStores({
                    ...{
                        id: item.id,
                        machineroom_id: item.machineroom_id,
                        cabinet_id: item.cabinet_id,
                        use_state: item.use_state,
                        machine_count: item.machine_count,
                        machine_room_name: item.machine_room_name,
                        use_state_cn: item.use_state_cn,
                        use_type_cn: item.use_type_cn,
                        created_at: item.created_at || dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        updated_at: item.updated_at || dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss")
                    }
                }));
                console.log(this.cabinets);
            }
        });
    }
}
export default CabinetsStores;