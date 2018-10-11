import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import Paper from '@material-ui/core/Paper';
import Tabs from '@material-ui/core/Tabs';
import Tab from '@material-ui/core/Tab';

const styles = theme => ({
    listTableComponent: {
        marginTop: 0,
        borderRadius: "0 0 4px 4px",
        boxShadow: "0px 4px 5px 0px rgba(0, 0, 0, 0.1), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.12)"
    }
});
const columnData = [
    { id: 'customer_name', numeric: true, disablePadding: false, label: '客户' },
    { id: 'business_name', numeric: true, disablePadding: false, label: '业务员' },
    { id: 'resource_type', numeric: true, disablePadding: false, label: '资源类型' },
    { id: 'order_type', numeric: true, disablePadding: false, label: '订单类型' },
    { id: 'pay_type', numeric: true, disablePadding: false, label: '支付方式' },
    { id: 'pay_price', numeric: true, disablePadding: false, label: '实付金额' },
    { id: 'pay_time', numeric: true, disablePadding: false, label: '支付时间' },
    { id: 'order_status', numeric: true, disablePadding: false, label: '订单状态' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendData: [
        {id: "order_sn", label: "订单号", type: "text"},
        {id: "before_money", label: "支付前余额" ,type: "text"},
        {id: "after_money", label: "支付后余额" ,type: "text"},
        {id: "resource", label: "资源" ,type: "text"},
        {id: "price", label: "单价" ,type: "text"},
        {id: "duration", label: "时长" ,type: "text"},
        {id: "payable_money", label: "应付金额" ,type: "text"},
        {id: "end_time", label: "到期时间" ,type: "text"},
        {id: "serial_number", label: "支付流水号" ,type: "text"},
        {id: "order_note", label: "订单备注" ,type: "text"},
    ],label: '操作'
    }
];
const inputType = [
];
@inject("financesStores")
@observer 
class FinanceList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: "all"
        };
    }
    componentDidMount() {
        this.props.financesStores.getData();
    }
    handleChange = (event, value) => {
        if(value=="all") {
            this.props.financesStores.getData();
        } else {
            this.props.financesStores.getData({
                order_status: value
            });
        }
        this.props.financesStores.type = value;
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
                <Tab label="待支付" value={0} />
                <Tab label="已支付" value={1} />
                <Tab label="财务确认" value={2} />
                <Tab label="订单完成" value={3} />
                <Tab label="取消" value={4} />
                <Tab label="申请退款" value={5} />
                <Tab label="退款完成" value={6} />
                </Tabs>
            </Paper>,
            <ListTableComponent 
            className={classes.listTableComponent}
            title="财务统计"
            operattext="财务管理"
            inputType={inputType} 
            headTitlesData={columnData} 
            data={this.props.financesStores.finances} 
          />
        ];
      }
}
FinanceList.propTypes = {
    classes: PropTypes.object.isRequired,
};
const FinanceListComponent = (props) => {
    return <FinanceList {...props} />
}
export default withStyles(styles)(FinanceListComponent);