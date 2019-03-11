import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import {post} from "../tool/http.js";
import extendElementsComponent from "../tool/extendElementsComponent";
import ResetPassword from "../component/dialog/resetPassword.jsx";
import ManualRecharge from "../component/dialog/manualRecharge.jsx";
import RechargeRecord from "../component/icon/rechargeRecord.jsx";
import PersonnelTransfer from "../component/dialog/personnelTransfer.jsx";
import { routerConfig } from "../config/common/config.js";

const columnData = [
    // { id: 'name', numeric: true, disablePadding: false, label: '用户名' },
    { id: 'email', numeric: true, disablePadding: false, label: '邮箱地址' },
    { id: 'money', numeric: true, disablePadding: false, label: '余额' },
    { id: 'clerk_name', numeric: true, disablePadding: false, label: '业务员' },
    { id: 'status', numeric: true, disablePadding: false, label: '状态' },
    { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true,  extendConfirm: {
        last: true,
        title: "更改状态操作",
        content: "是否要更改此用户状态",
        select: true,
        selectOptions: [
            {
                text: "拉黑",
                value: 0
            },
            {
                text: "正常",
                value: 2,
                default: true
            },
            {
                text: "未验证",
                value: 1
            }
        ],
        ok: (data,param) => {
            return new Promise((resolve,reject) => {
                post("business/pull_black",{
                    status: param,
                    id: data.id
                }).then((res) => {
                    if(res.data.code==1) {
                        alert(res.data.msg);
                        resolve(res.data);
                    } else {
                        alert(res.data.msg);
                        resolve(res.data);
                    }
                }).catch(reject);
            });
        }
      } ,extendElement: (data) => {
        let Element = extendElementsComponent([
            ResetPassword,
            ManualRecharge,
            PersonnelTransfer
          ]);
        return <Element postUrl="business/recharge" nameParam="email" {...data} />;
    }, extendUrl: [
        {
            title: "添加业务",
            link: `${routerConfig.baseUrl}/business`,
            param: ["id","email","money","status","clerk_name"]
        },
        {
            title: "充值记录",
            link: `${routerConfig.baseUrl}/checkrecharge`,
            param: ["id"],
            icon: <RechargeRecord />
        }
    ], label: '操作' }
];
const inputType = [
    {
        field: "email",
        label: "用户邮箱",
        type: "text"
      }
];
@inject("clientelesStores")
@observer
class ClienteleList extends React.Component {
    componentDidMount() {
        this.props.clientelesStores.getData();
    }
    updata() {
        this.props.clientelesStores.getData();
    }
    addData = (param,callbrak) => {
        this.props.clientelesStores.bingSalesman(param).then((state) => {
          callbrak(state);
        });
    }
    render() {
        return (
          <ListTableComponent
            title="CRM管理"
            operattext="客户"
            headTitlesData={columnData}
            inputType={inputType}
            data={this.props.clientelesStores.clienteles}
            addData={this.addData.bind(this)}
            updata={this.updata.bind(this)}
          />
        );
      }
}
export default ClienteleList;
