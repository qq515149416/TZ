import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
const columnData = [
    { id: 'client_name', numeric: true, disablePadding: true, label: '客户' },
    { id: 'slaes_name', numeric: true, disablePadding: true, label: '业务员' },
    { id: 'business_number', numeric: true, disablePadding: true, label: '业务号' },
    { id: 'business_type', numeric: true, disablePadding: true, label: '业务类型' },
    { id: 'machine_number', numeric: true, disablePadding: true, label: '机器/机柜编号' },
    { id: 'business_status', numeric: true, disablePadding: true, label: '业务状态' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendData: [
        {id: "order_number", label: "订单号", type: "text"},
        {id: "resource_detail", label: "资源详情", type: "text"},
        {id: "money", label: "单价" ,type: "text"},
        {id: "length", label: "时长" ,type: "text"},
        {id: "start_time", label: "业务开始时间" ,type: "text"},
        {id: "endding_time", label: "业务结束时间" ,type: "text"},
        {id: "business_note", label: "业务备注" ,type: "text"}
    ], label: '操作' }
];
const inputType = [];
@inject("businessStores")
@observer 
class BusinesList extends React.Component {
  componentDidMount() {
    if(location.search.indexOf("?id=")!=-1&&location.search.indexOf("&")==-1) {
        this.props.businessStores.getData(location.search.substr(1).split("=")[1]);
    }
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
export default BusinesList;