import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import Paper from '@material-ui/core/Paper';
import Tabs from '@material-ui/core/Tabs';
import Tab from '@material-ui/core/Tab';
const qs = require('qs');
const styles = theme => ({
    listTableComponent: {
        marginTop: 0,
        borderRadius: "0 0 4px 4px",
        boxShadow: "0px 4px 5px 0px rgba(0, 0, 0, 0.1), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.12)"
    }
});
const columnData = [
    { id: 'order_sn', numeric: true, disablePadding: true, label: '订单号' },
    { id: 'customer_name', numeric: true, disablePadding: true, label: '客户' },
    { id: 'business_name', numeric: true, disablePadding: true, label: '业务员' },
    { id: 'resource_type', numeric: true, disablePadding: true, label: '资源类型' },
    { id: 'order_type', numeric: true, disablePadding: true, label: '订单类型' },
    { id: 'price', numeric: true, disablePadding: true, label: '单价' },
    { id: 'duration', numeric: true, disablePadding: true, label: '时长' },
    { id: 'payable_money', numeric: true, disablePadding: true, label: '应付金额' },
    { id: 'end_time', numeric: true, disablePadding: true, label: '到期时间' },
    { id: 'pay_type', numeric: true, disablePadding: true, label: '支付方式' },
    { id: 'pay_price', numeric: true, disablePadding: true, label: '实付金额' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendData: [
        {id: "business_sn", label: "业务号", type: "text"},
        {id: "before_money", label: "支付前余额", type: "text"},
        {id: "after_money", label: "支付后余额" ,type: "text"},
        {id: "resource", label: "资源" ,type: "text"},
        {id: "serial_number", label: "支付流水号" ,type: "text"},
        {id: "pay_time", label: "支付时间" ,type: "text"},
        {id: "order_status", label: "订单状态" ,type: "text"},
        {id: "order_note", label: "订单备注" ,type: "text"},
        {id: "created_at", label: "创建时间" ,type: "text"}
    ], label: '操作' }
];
const inputType = [

];
@inject("ordersStores")
@observer 
class OrderList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: "all"
        };
    }
    componentDidMount() {
        this.props.ordersStores.getData({
            business_sn: qs.parse(location.search.substr(1)).business_number
        });
    }
    handleChange = (event, value) => {
        if(value=="all") {
            this.props.ordersStores.getData({
                business_sn: qs.parse(location.search.substr(1)).business_number
            });
        } else {
            this.props.ordersStores.getData({
                business_sn: qs.parse(location.search.substr(1)).business_number,
                resource_type: value
            });
        }
        
        this.setState({ value });
    }
    render() {
        const {classes} = this.props;
        return [
            <Paper square>
                <Tabs
                value={this.state.value}
                indicatorColor="primary"
                textColor="primary"
                onChange={this.handleChange}
                >
                <Tab label="全部" value={"all"} />
                <Tab label="租用主机" value={1} />
                <Tab label="托管主机" value={2} />
                <Tab label="租用机柜" value={3} />
                <Tab label="IP" value={4} />
                <Tab label="CPU" value={5} />
                <Tab label="硬盘" value={6} />
                <Tab label="内存" value={7} />
                <Tab label="带宽" value={8} />
                <Tab label="防护" value={9} />
                </Tabs>
            </Paper>,
            <ListTableComponent 
            className={classes.listTableComponent}
            title="业务订单管理"
            operattext="业务订单操作"
            inputType={inputType} 
            headTitlesData={columnData} 
            data={this.props.ordersStores.orders}
          />
        ];
      }
}
OrderList.propTypes = {
    classes: PropTypes.object.isRequired,
};
const OrderListComponent = (props) => {
    return <OrderList {...props} />
}
export default withStyles(styles)(OrderListComponent);
