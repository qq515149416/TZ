import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
const columnData = [
    { id: 'name', numeric: true, disablePadding: false, label: '用户名' },
    { id: 'email', numeric: true, disablePadding: false, label: '邮箱地址' },
    { id: 'money', numeric: true, disablePadding: false, label: '余额' },
    { id: 'clerk_name', numeric: true, disablePadding: false, label: '业务员' },
    { id: 'status', numeric: true, disablePadding: false, label: '状态' },
    { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
    { id: 'updated_at', numeric: true, disablePadding: false, label: '更新时间' },
    { id: 'operat', numeric: true, disablePadding: false,  label: '操作' }
];
@inject("clientelesStores")
@observer 
class ClienteleList extends React.Component {
    componentDidMount() {
        this.props.clientelesStores.getData();
    }
    render() {
        return (
          <ListTableComponent 
            title="CRM管理"
            operattext="客户"
            headTitlesData={columnData} 
            data={this.props.clientelesStores.clienteles}  
          />
        );
      }
}
export default ClienteleList;