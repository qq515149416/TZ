import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';
import Tabs from '@material-ui/core/Tabs';
import Tab from '@material-ui/core/Tab';
import ListTableComponent from "../component/listTableComponent.jsx";
import ChangeStatus from "../component/dialog/changeStatus.jsx";
import Communication from "../component/dialog/communication.jsx";
import { inject,observer } from "mobx-react";
const qs = require('qs');

const styles = theme => ({
    listTableComponent: {
        marginTop: 0,
        borderRadius: "0 0 4px 4px",
        boxShadow: "0px 4px 5px 0px rgba(0, 0, 0, 0.1), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.12)"
    }
});
const columnData = [
    { id: 'work_order_number', numeric: true, disablePadding: true, label: '工单号' },
    { id: 'client_name', numeric: true, disablePadding: true, label: '客户' },
    { id: 'worktype', numeric: true, disablePadding: true, label: '工单类型' },
    { id: 'submitter_name', numeric: true, disablePadding: true, label: '提交人' },
    { id: 'submit', numeric: true, disablePadding: true, label: '提交方' },
    { id: 'workstatus', numeric: true, disablePadding: true, label: '状态' },
    { id: 'department', numeric: true, disablePadding: true, label: '处理部门' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendData: [
        {id: "business_num", label: "业务编号", type: "text"},
        {id: "sales_name", label: "业务员" ,type: "text"},
        {id: "work_order_content", label: "工单内容" ,type: "text"},
        {id: "complete_number", label: "完成人员工号" ,type: "text"},
        {id: "summary", label: "总结" ,type: "text"},
        {id: "complete_time", label: "完成时间" ,type: "text"},
        {id: "business_type", label: "业务类型" ,type: "text"},
        {id: "machine_number", label: "机器编号" ,type: "text"},
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
          ]}
    ],extendElement: (data) => {
        if(data.work_order_status==1) {
            return <Communication {...data} />;
        } else {
            return <ChangeStatus {...data} postUrl="workorder/edit" nameParam="work_order_number" />;
        }
    }, label: '操作' }
];
const inputType = [

];
@inject("workOrdersStores")
@observer 
class WorkOrderList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: 0
        };
    }
    componentDidMount() {
        this.props.workOrdersStores.getData();
    }
    delData = (selectedData,callbrak) => {
        const {workOrdersStores} = this.props;
        let delIng = selectedData.map(item => workOrdersStores.delData(item));
        callbrak(delIng);
    }
    handleChange = (event, value) => {
        this.props.workOrdersStores.type = value;
        this.setState({ value });
        this.props.workOrdersStores.getData();
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
                <Tab label="待处理" value={0} />
                <Tab label="处理中" value={1} />
                <Tab label="完成" value={2} />
                <Tab label="取消" value={3} />
                </Tabs>
                </Paper>,
          <ListTableComponent 
            className={classes.listTableComponent}
            title="工单列表"
            operattext="工单信息"
            inputType={inputType} 
            headTitlesData={columnData} 
            data={this.props.workOrdersStores.workOrders} 
            delData={this.delData.bind(this)}
          />
        ];
      }
}
WorkOrderList.propTypes = {
    classes: PropTypes.object.isRequired,
};
const WorkOrderListComponent = (props) => {
    return <WorkOrderList {...props} />
}
export default withStyles(styles)(WorkOrderListComponent);