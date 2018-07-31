import { observable, action, extendObservable} from "mobx";
class UserInfoStores {
    @observable name =  "";
    @observable qq ="";
    @observable job_number = "";
    @observable mobile = "";
    @observable sex = "";
    @observable branch = "";
    @observable job = "";
    @observable mailbox = "";
    constructor({name, qq, job_number, mobile, sex, branch, job, mailbox}) {
        Object.assign(this,{
            name,
            qq,
            job_number,
            mobile,
            sex,
            branch,
            job,
            mailbox
        });
        // extendObservable(this,{
        //     name,
        //     qq,
        //     job_number,
        //     mobile,
        //     sex,
        //     branch,
        //     job,
        //     mailbox
        // });
    }
}
class UsersInfoStores {
    counter = 0;
    @observable user = [

    ];
    createData(name, qq, job_number, mobile, sex, branch, job, mailbox) {
        this.counter += 1;
        return { id: this.counter, name, qq, job_number, mobile, sex, branch, job, mailbox};
    }
    // @action.bound 
    // getData() {
        
    // }
    constructor() {
        this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')));
        this.user.push(new UserInfoStores(this.createData('刘聪', '2851506991', 'A080', '18038990936', '男', '销售2部', '销售主管','2851506991@qq.com')));
        this.user.push(new UserInfoStores(this.createData('杨培安', '2851217783', 'A061', '18026487999', '男', '响应中心', '副总','ypa@tzidc.com')));
        this.user.push(new UserInfoStores(this.createData('尹锐轩', '123684025', 'A018', '13602608665', '男', '财务部', '财务人员','123684025@qq.com')));
        this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')));
        this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')));
        this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')))
        this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')));
        this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')));
        this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')));
        this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')));
        this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')));
        this.user.push(new UserInfoStores(this.createData('庞志伟', '328139413/83289000', 'A080', '18922986777', '男', '市场部', '市场部经理','328139413@qq.com')));
    }
}
export default UsersInfoStores;