import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
const columnData = [
    { id: 'client_name', numeric: true, disablePadding: true, label: '客户' },
    { id: 'sales_name', numeric: true, disablePadding: true, label: '业务员' },
    { id: 'business_number', numeric: true, disablePadding: true, label: '业务号' },
    { id: 'type', numeric: true, disablePadding: true, label: '业务类型' },
    { id: 'machine_number', numeric: true, disablePadding: true, label: '机器/机柜编号' },
    { id: 'status', numeric: true, disablePadding: true, label: '业务状态' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendData: [
        {id: "order_number", label: "订单号", type: "text"},
        {id: "resource_detail", label: "资源详情", type: "subordinate", subordinate: [
          {id: "machine_num", label: "机器编号", type: "text"},
          {id: "cpu", label: "CPU", type: "text"},
          {id: "memory", label: "内存", type: "text"},
          {id: "harddisk", label: "硬盘", type: "text"},
          {id: "bandwidth", label: "带宽", type: "text"},
          {id: "protect", label: "防御", type: "text"},
          {id: "loginname", label: "账号", type: "text"},
          {id: "loginpass", label: "密码", type: "text"},
          {id: "machine_type", label: "机器型号", type: "text"},
          {id: "machine_note", label: "机器备注", type: "text"},
          {id: "cabinet_id", label: "机柜编号", type: "text"}
        ]},
        {id: "money", label: "单价" ,type: "text"},
        {id: "length", label: "时长" ,type: "text"},
        {id: "start_time", label: "业务开始时间" ,type: "text"},
        {id: "endding_time", label: "业务结束时间" ,type: "text"},
        {id: "business_note", label: "业务备注" ,type: "text"}
    ], label: '操作' }
];
const inputType = [
];
@inject("businessStores")
@observer 
class CheckBusinessList extends React.Component {
  componentDidMount() {
    this.props.businessStores.getAllData();
  }
  render() {
    return (
      <ListTableComponent 
        title="业务管理"
        operattext="业务信息"
        inputType={inputType} 
        headTitlesData={columnData} 
        data={this.props.businessStores.business}  
      />
    );
  }
}
export default CheckBusinessList;