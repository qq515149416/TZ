import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import {post} from "../tool/http.js";
import ResetPassword from "../component/dialog/resetPassword.jsx";

const columnData = [
    // { id: 'name', numeric: true, disablePadding: false, label: '用户名' },
    { id: 'email', numeric: true, disablePadding: false, label: '邮箱地址' },
    { id: 'money', numeric: true, disablePadding: false, label: '余额' },
    { id: 'clerk_name', numeric: true, disablePadding: false, label: '业务员' },
    { id: 'status', numeric: true, disablePadding: false, label: '状态' },
    { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
    { id: 'updated_at', numeric: true, disablePadding: false, label: '更新时间' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true,  extendConfirm: {
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
        return <ResetPassword {...data} />;
    }, extendUrl: {
        title: "添加业务",
        link: "/tz_admin/business",
        param: ["id","email","money","status"]
    }, label: '操作' }
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
    render() {
        return (
          <ListTableComponent 
            title="CRM管理"
            operattext="客户"
            headTitlesData={columnData} 
            data={this.props.clientelesStores.clienteles}  
            updata={this.updata.bind(this)}
          />
        );
      }
}
export default ClienteleList;