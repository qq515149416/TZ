import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
class UserInfoStores {
    @observable id = 1;
    @observable fullname =  "";
    @observable sex ="";
    @observable age = "";
    @observable department = "";
    @observable job = "";
    @observable work_number = "";
    @observable phone = "";
    @observable QQ = "";
    @observable wechat = "";
    @observable Email = "";
    @observable note = "";
    @observable created_at = "";
    @observable updated_at = "";

    constructor({id,fullname, sex, age, department, job, work_number, phone, QQ,wechat,Email,note,created_at,updated_at}) {
        Object.assign(this,{
            id,
            fullname,
            sex,
            age,
            department,
            job,
            work_number,
            phone,
            QQ,
            wechat,
            Email,
            note,
            created_at,
            updated_at
        });
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