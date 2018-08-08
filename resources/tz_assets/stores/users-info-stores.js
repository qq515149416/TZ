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
    createData(name, qq, job_number, mobile, sex, branch, job, mailbox) {
        return { id: (this.user.length ? this.user[this.user.length-1].id + 1 : 1), name, qq, job_number, mobile, sex, branch, job, mailbox};
    }
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
    constructor() {
        // this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')));
        // this.user.push(new UserInfoStores(this.createData('刘聪', '2851506991', 'A080', '18038990936', '男', '销售2部', '销售主管','2851506991@qq.com')));
        // this.user.push(new UserInfoStores(this.createData('杨培安', '2851217783', 'A061', '18026487999', '男', '响应中心', '副总','ypa@tzidc.com')));
        // this.user.push(new UserInfoStores(this.createData('尹锐轩', '123684025', 'A018', '13602608665', '男', '财务部', '财务人员','123684025@qq.com')));
    }
}
export default UsersInfoStores;