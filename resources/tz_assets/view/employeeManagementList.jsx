import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
const columnData = [
    { id: 'name', numeric: true, disablePadding: false, label: '名字' },
    { id: 'role', numeric: true, disablePadding: false, label: '角色身份' },
    { id: 'username', numeric: true, disablePadding: false, label: '账号' },
    { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
    { id: 'updated_at', numeric: true, disablePadding: false, label: '更新时间' },
    { id: 'operat', numeric: true, disablePadding: false,  label: '操作' }
];
@inject("employeeManagementsStores")
@observer 
class EmployeeManagementList extends React.Component {
    componentDidMount() {
        this.props.employeeManagementsStores.getData();
    }
    render() {
        return (
          <ListTableComponent 
            title="员工管理"
            operattext="工作人员"
            headTitlesData={columnData} 
            data={this.props.employeeManagementsStores.employeeManagements}  
          />
        );
      }
}
export default EmployeeManagementList;