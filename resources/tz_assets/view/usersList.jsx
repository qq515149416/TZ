import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";

const columnData = [
  { id: 'fullname', numeric: true, disablePadding: true, label: '姓名' },
  { id: 'sex', numeric: true, disablePadding: false, label: '性别' },
  { id: 'age', numeric: true, disablePadding: false, label: '年龄' },
  { id: 'department_name', numeric: true, disablePadding: false, label: '部门' },
  { id: 'job_name', numeric: true, disablePadding: false, label: '岗位' },
  { id: 'work_number', numeric: true, disablePadding: false, label: '工号' },
  { id: 'wechat', numeric: true, disablePadding: false, label: '微信' },
  { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
  { id: 'updated_at', numeric: true, disablePadding: false, label: '更新时间' },
];
const inputType = [];
@inject("usersInfoStores")
@observer
class usersList extends React.Component {
  componentDidMount() {
    this.props.usersInfoStores.getData();
  }
  render() {
    return (
      <ListTableComponent
        title="通讯录"
        operattext="通讯录"
        inputType={inputType}
        headTitlesData={columnData}
        data={this.props.usersInfoStores.user}
      />
    );
  }
}
export default usersList;
