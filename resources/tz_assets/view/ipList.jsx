import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";

const columnData = [
    { id: 'ip', numeric: true, disablePadding: true, label: 'IP地址' },
    { id: 'vlan', numeric: true, disablePadding: false, label: 'vlan' },
    { id: 'ip_company', numeric: true, disablePadding: false, label: '所属运营商' },
    { id: 'ip_status', numeric: true, disablePadding: false, label: '使用状态' },
    { id: 'ip_lock', numeric: true, disablePadding: false, label: '锁定状态' },
    { id: 'ip_note', numeric: true, disablePadding: false, label: '备注信息' },
    { id: 'ip_comproom', numeric: true, disablePadding: false, label: '机房编号' },
    { id: 'ip_comproomname', numeric: true, disablePadding: false, label: '所属机房' },
    { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
    { id: 'updated_at', numeric: true, disablePadding: false, label: '更新时间' }
];
@inject("ipsStores")
@observer 
class IpList extends React.Component {
  componentDidMount() {
    this.props.ipsStores.getData();
  }
  render() {
    return (
      <ListTableComponent headTitlesData={columnData} data={this.props.ipsStores.ips}  />
    );
  }
}
export default IpList;