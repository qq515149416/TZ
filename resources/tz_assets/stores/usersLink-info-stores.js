import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
const dateFormat = require('dateformat');
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
        if(!isNaN(site)) {
            let siteText = "";
            switch(site) {
                case 1:
                    siteText = "左侧";
                break;
                case 2:
                    siteText = "联系人页面";
                break;
                case 3:
                    siteText = "两侧均显示";
                break;
            }
            site = siteText;
        }
        
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
    createData(contactname, qq, mobile, email, rank, site, created_at = dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"), updated_at = dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss")) {
        return { id: (this.user.length ? this.user[this.user.length-1].id + 1 : 1), contactname, qq, mobile, email, rank, site, created_at, updated_at};
    }
    @action.bound 
    delData(id) {
        return new Promise((resolve,reject) => {
            post("contacts/remove",{
                delete_id: id
            }).then((res) => {
                if(res.data.code==1) {
                    this.user.splice(this.user.findIndex((item) => item.id==id),1);
                    resolve(true);
                } else {
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound 
    addData(data) {
        return new Promise((resolve,reject) => {
            post("contacts/insert",{
                contactname: data.contactname,
                qq: data.qq,
                mobile: data.mobile,
                email: data.email,
                rank: data.rank,
                site: data.site
            }).then((res) => {
                if(res.data.code==1) {
                    this.user.push(new UserLinkInfoStores(this.createData(data.contactname,data.qq,data.mobile,data.email,data.rank,data.site)));
                    resolve(true);
                } else {
                    resolve(false);
                }
            }).catch(reject);
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