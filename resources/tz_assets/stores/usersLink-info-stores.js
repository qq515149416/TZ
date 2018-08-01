import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
class UserLinkInfoStores {
    @observable id = 1;
    @observable contactname =  "";
    @observable qq ="";
    @observable mobile = "";
    @observable email = "";
    @observable rank = "";
    @observable site = "";
    @observable created_at = "";
    @observable updated_at = "";
    constructor({id,contactname, qq, mobile, email, rank, site, created_at, updated_at}) {
        Object.assign(this,{
            id,
            contactname,
            qq,
            mobile,
            email,
            rank,
            site,
            created_at,
            updated_at
        });
    }
}
class UsersLinkInfoStores {
    @observable user = [

    ];
    createData(contactname, qq, mobile, email, rank, site, created_at, updated_at) {
        return { id: (this.user.length ? this.user[this.user.length-1].id + 1 : 1), contactname, qq, mobile, email, rank, site, created_at, updated_at};
    }
    @action.bound 
    addData(data) {
        post("contacts/insert",{
            contactname: data.contactname,
            qq: data.qq,
            mobile: data.mobile,
            email: data.email,
            rank: data.rank,
            site: data.site
        }).then((res) => {
            if(res.data.code==1) {
                this.user.push(new UserLinkInfoStores(this.createData({...data})));
            }
        });
    }
    @action.bound 
    getData() {
        get("contacts/list").then((res) => {
            if(res.data.code==1) {
                this.user = res.data.data.map(item => new UserLinkInfoStores({
                    ...item
                }));
            }
        });
    }
    constructor() {
        this.user.push(new UserLinkInfoStores(this.createData('唐康', '2885650826', '13712756033', '2885650826@qq.com', '1', '3', '2018-08-01 11:25:48', '2018-08-01 11:25:48')));
    }

}
export default UsersLinkInfoStores;