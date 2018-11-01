import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
class UserInfoStores {
    constructor(data) {
        extendObservable(this,data);
    }
}
class UsersInfoStores {
    @observable user = [

    ];
    @action.bound
    getData() {
        get("staff/staff_list").then((res) => {
            if(res.data.code==1) {
                console.log(res.data);
                this.user = res.data.data.map(item => new UserInfoStores({
                    ...item
                }));
            }
        });
    }
}
export default UsersInfoStores;
