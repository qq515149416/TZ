import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";

function getSorting(order, orderBy) {
  return order === 'desc'
    ? (a, b) => (b[orderBy] < a[orderBy] ? -1 : 1)
    : (a, b) => (a[orderBy] < b[orderBy] ? -1 : 1);
}

const columnData = [
  { id: 'name', numeric: true, disablePadding: true, label: '姓名' },
  { id: 'qq', numeric: true, disablePadding: false, label: 'qq' },
  { id: 'job_number', numeric: true, disablePadding: false, label: '工号' },
  { id: 'mobile', numeric: true, disablePadding: false, label: '手机' },
  { id: 'sex', numeric: true, disablePadding: false, label: '性别' },
  { id: 'branch', numeric: true, disablePadding: false, label: '部门' },
  { id: 'job', numeric: true, disablePadding: false, label: '岗位' },
  { id: 'mailbox', numeric: true, disablePadding: false, label: '邮箱' }
];

@inject("usersInfoStores")
@observer 
class usersList extends React.Component {
  componentDidMount() {
    this.props.usersInfoStores.getData();
  }
  render() {
    return (
      <ListTableComponent headTitlesData={columnData} data={this.props.usersInfoStores.user}  />
    );
  }
}
export default usersList;