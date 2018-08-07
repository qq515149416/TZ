import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
const columnData = [
  { id: 'contactname', numeric: false, disablePadding: true, label: '姓名' },
  { id: 'qq', numeric: true, disablePadding: false, label: 'QQ' },
  { id: 'mobile', numeric: true, disablePadding: false, label: '手机' },
  { id: 'email', numeric: true, disablePadding: false, label: '邮箱' },
  { id: 'rank', numeric: true, disablePadding: false, label: '权重' },
  { id: 'site', numeric: true, disablePadding: false, label: '显示位置' },
  { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
  { id: 'updated_at', numeric: true, disablePadding: false, label: '更新时间' },
  { id: 'operat', numeric: true, disablePadding: false, label: '操作' }
];
@inject("usersLinkInfoStores")
@observer 
class UsersLinkList extends React.Component {
  componentDidMount() {
    this.props.usersLinkInfoStores.getData();
  }
  addData = (param,callbrak) => {
    this.props.usersLinkInfoStores.addData(param).then((state) => {
          callbrak(state);
    });
  }
  delData = (selectedData,callbrak) => {
    const {usersLinkInfoStores} = this.props;
    let delIng = selectedData.map(item => usersLinkInfoStores.delData(item));
    callbrak(delIng);
  }
  changeData = (param,callbrak) => {
    const {usersLinkInfoStores} = this.props;
    usersLinkInfoStores.changeData(param).then((state) => {
      callbrak(state);
    });
  }
  render() {
    return (
      <ListTableComponent headTitlesData={columnData} data={this.props.usersLinkInfoStores.user} changeData={this.changeData.bind(this)} addData={this.addData.bind(this)} delData={this.delData.bind(this)}  />
    );
  }
}
export default UsersLinkList;