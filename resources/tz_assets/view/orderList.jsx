import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import Paper from '@material-ui/core/Paper';
import Tabs from '@material-ui/core/Tabs';
import Tab from '@material-ui/core/Tab';
import SelectExpansion from "../component/dialog/selectExpansion.jsx";
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
    {
        field: "resource_type",
        label: "资源类型",
        type: "switch",
        radioData: [
            {
                checked: true,
                value: 4,
                label: "IP"
            },
            {
                checked: false,
                value: 5,
                label: "CPU"
            },
            {
                checked: false,
                value: 6,
                label: "硬盘"
            },
            {
                checked: false,
                value: 7,
                label: "内存"
            },
            {
                checked: false,
                value: 8,
                label: "带宽"
            },
            {
                checked: false,
                value: 9,
                label: "防御"
            }
        ]
    },
    {
        field: "resource",
        label: "资源",
        type: "component",
        defaultData: [],
        Component: SelectExpansion,
        param: {
            buttonName: "选择资源"
        },
        rule: {
            term: "resource_type",
            execute: [
              {
                index: 4,
                value: "ip_resource",
                default: true
              },
              {
                index: 5,
                value: "cpu_resource"
              },
              {
                index: 6,
                value: "hardDisk_resource"
              },
              {
                index: 7,
                value: "ram_resource"
              },
              {
                index: 8,
                value: "bandwidth"
              },
              {
                index: 9,
                value: "defense"
              }
            ],
            type: "component"
          }
    }
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
        this.getResourceData({
            resource_type: {
                value: 4
            }
        },"init");
        inputType[inputType.findIndex(item => item.field=="resource_type")].model = {
            getSubordinateData: this.getResourceData.bind(this)
        };
        inputType[inputType.findIndex(item => item.field=="resource")].model = {
            getSubordinateData: this.getResourceData.bind(this)
        };
    }
    addData = (param,callbrak) => {
        console.log(param);
        param.business_sn = qs.parse(location.search.substr(1)).business_number;
        param.customer_id = qs.parse(location.search.substr(1)).client_id;
        param.customer_name = qs.parse(location.search.substr(1)).client_name;
        // this.props.ordersStores.addData(param).then((state) => {
        //     callbrak(state);
        // });
      }
    getResourceData(param,type) {
        if(param.resource_type && param.resource_type.value > 4) {
            this.props.ordersStores.getResourceData({
                resource_type: param.resource_type.value,
                machineroom: qs.parse(location.search.substr(1)).machineroom_id
            });
        } else if(param.resource_type && param.company!=undefined) {
            this.props.ordersStores.getResourceData({
                resource_type: param.resource_type.value,
                company: param.company,
                machineroom: qs.parse(location.search.substr(1)).machineroom_id
            });
        } else {
            console.error("参数：",param,"有问题");
        }
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
        this.props.ordersStores.type = value;
        this.setState({ value });
    }
    render() {
        const {classes} = this.props;
        inputType[inputType.findIndex(item => item.field=="resource")].defaultData = this.props.ordersStores.resource.map(item => {
            return {
              value: item,
              text: item.label
            }
        });
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
            addData={this.addData.bind(this)} 
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
