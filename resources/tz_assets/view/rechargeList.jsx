import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
const qs = require('qs');

const columnData = [
    { id: 'customer_name', numeric: true, disablePadding: false, label: '客户名称' },
    { id: 'money_before', numeric: true, disablePadding: false, label: '充值前余额' },
    { id: 'money_after', numeric: true, disablePadding: false, label: '充值后余额' },
    { id: 'recharge_amount', numeric: true, disablePadding: false, label: '充值金额' },
    { id: 'recharge_way', numeric: true, disablePadding: false, label: '充值方式' },
    { id: 'timestamp', numeric: true, disablePadding: false, label: '充值时间' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendData: [
        {id: "customer_name", label: "客户名称", type: "text"},
        {id: "money_before", label: "充值前余额" ,type: "text"},
        {id: "money_after", label: "充值后余额" ,type: "text"},
        {id: "recharge_amount", label: "充值金额" ,type: "text"},
        {id: "recharge_way", label: "充值方式" ,type: "text"},
        {id: "salesman_name", label: "充值人" ,type: "text"},
        {id: "trade_no", label: "充值单号" ,type: "text"},
        {id: "timestamp", label: "充值时间" ,type: "text"},
        {id: "voucher", label: "凭据" ,type: "text"}
    ], label: '操作' }
];
const inputType = [
];
@inject("rechargesStores")
@observer
class RechargeList extends React.Component {
    componentDidMount() {
        if(location.search.indexOf("?id") > -1) {
            this.props.rechargesStores.getData({
                customer_id: qs.parse(location.search.substr(1)).id
            });
        } else {
            this.props.rechargesStores.getData();
        }
    }
    render() {
        return (
            <ListTableComponent
            title="充值记录"
            operattext="充值"
            inputType={inputType}
            headTitlesData={columnData}
            data={this.props.rechargesStores.recharge}
          />
        );
      }
}
export default RechargeList;
