import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class MachineRoomStores {
    @observable id =  1;
    @observable machine_room_id =  "";
    @observable machine_room_name ="";
    @observable list_order ="";
    @observable created_at = "";
    @observable updated_at = "";
    constructor({id, machine_room_id, machine_room_name,list_order,created_at,updated_at}) {
        Object.assign(this,{
            id,
            machine_room_id,
            machine_room_name,
            list_order,
            created_at,
            updated_at
        });
    }
}
class MachineRoomsStores extends ActionBoundStores {
    @observable machineRooms = [

    ];
    addData(data) {
        return new Promise((resolve,reject) => {
            post("machine_room/storeByAjax",data).then((res) => {
                if(res.data.code==1) {
                    this.addStoreData("machineRooms",MachineRoomStores,{
                        machine_room_id: data.room_id,
                        machine_room_name: data.room_name,
                        list_order: data.list_order
                    });
                    resolve(true);
                } else {
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound 
    getData() {
        get("machine_room/showByAjax").then((res) => {
            if(res.data.code==1) {
                this.machineRooms = res.data.data.map(item => new MachineRoomStores({
                    ...{
                        id: item.id,
                        machine_room_id: item.machine_room_id,
                        machine_room_name: item.machine_room_name,
                        list_order: item.list_order,
                        created_at: item.created_at || dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        updated_at: item.updated_at || dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss")
                    }
                }));
            }
        });
    }
}
export default MachineRoomsStores;