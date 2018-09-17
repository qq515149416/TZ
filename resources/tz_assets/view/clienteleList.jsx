import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import {post} from "../tool/http.js";
const columnData = [
    // { id: 'name', numeric: true, disablePadding: false, label: '用户名' },
    { id: 'email', numeric: true, disablePadding: false, label: '邮箱地址' },
    { id: 'money', numeric: true, disablePadding: false, label: '余额' },
    { id: 'clerk_name', numeric: true, disablePadding: false, label: '业务员' },
    { id: 'status', numeric: true, disablePadding: false, label: '状态' },
    { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
    { id: 'updated_at', numeric: true, disablePadding: false, label: '更新时间' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendFn: (data) => {
        return new Promise((resolve,reject) => {
            post("business/pull_black",{
                status: 0,
                id: data.id
            }).then((res) => {
                if(res.data.code==1) {
                    alert("拉黑成功");
                    resolve(res.data);
                } else {
                    alert("拉黑失败");
                    resolve(res.data);
                }
            }).catch(reject);
        });
    },tipData: {
        title: "拉黑操作",
        content: "是否要执行拉黑操作"
    } , label: '操作' }
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