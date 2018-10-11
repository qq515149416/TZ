import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import Paper from '@material-ui/core/Paper';
import Tabs from '@material-ui/core/Tabs';
import Tab from '@material-ui/core/Tab';
import InputExpansionComponent from "../component/inputExpansionComponent.jsx";

const styles = theme => ({
    listTableComponent: {
        marginTop: 0,
        borderRadius: "0 0 4px 4px",
        boxShadow: "0px 4px 5px 0px rgba(0, 0, 0, 0.1), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.12)"
    }
});
const columnData = [
    { id: 'binding_machine', numeric: true, disablePadding: false, label: '机器编号' },
    { id: 'customer_name', numeric: true, disablePadding: false, label: '客户名字' },
    { id: 'domain_name', numeric: true, disablePadding: false, label: '绑定域名' },
    { id: 'record_number', numeric: true, disablePadding: false, label: '备案编号' },
    { id: 'status', numeric: true, disablePadding: false, label: '审核状态' },
    { id: 'submit_name', numeric: true, disablePadding: false, label: '提交人' },
    { id: 'submittran', numeric: true, disablePadding: false, label: '提交方式' },
    { id: 'white_number', numeric: true, disablePadding: false, label: '业务编号' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendData: [
        {id: "check_number", label: "审核人员工号", type: "text"},
        {id: "check_time", label: "审核时间" ,type: "text"},
        {id: "check_note", label: "审核备注" ,type: "text"},
        {id: "submit_note", label: "提交备注" ,type: "text"}
    ],label: '操作'
    }
];
const inputType = [
    {
        field: "white_ip",
        label: "IP",
        type: "text"
    },
    {
        field: "domain_name",
        label: "域名",
        type: "text"
    },
    {
        field: "record_number",
        label: "备案编号",
        type: "text"
    },
    {
        field: "submit_note",
        label: "备注",
        type: "text"
    },
    {
        field: "extentParam",
        label: "",
        type: "component",
        Component: InputExpansionComponent
    }
];
@inject("whitelistsStores")
@observer 
class WhitelistList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: 0
        };
    }
    componentDidMount() {
        this.props.whitelistsStores.getData({
            white_status: this.state.value
        });
        inputType[inputType.findIndex(item => item.field=="white_ip")].model = {
            getSubordinateData: this.getIpData.bind(this)
        };
    }
    getIpData = (value) => {
        this.props.whitelistsStores.getIpParam(value);
    }
    addData = (param,callbrak) => {
        // console.log(param);
        this.props.whitelistsStores.addData(param).then(state => {
            callbrak(state);
        });
    }
    handleChange = (event, value) => {
        this.props.whitelistsStores.getData({
            white_status: value
        });
        this.props.whitelistsStores.type = value;
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
                <Tab label="审核中" value={0} />
                <Tab label="审核通过" value={1} />
                <Tab label="审核不通过" value={2} />
                <Tab label="黑名单" value={3} />
                <Tab label="取消" value={4} />
                </Tabs>
            </Paper>,
            <ListTableComponent 
            className={classes.listTableComponent}
            title="白名单"
            operattext="白名单操作"
            inputType={inputType} 
            headTitlesData={columnData} 
            data={this.props.whitelistsStores.whitelists} 
            addData={this.addData.bind(this)} 
          />
        ];
      }
}
WhitelistList.propTypes = {
    classes: PropTypes.object.isRequired,
};
const WhitelistListComponent = (props) => {
    return <WhitelistList {...props} />
}
export default withStyles(styles)(WhitelistListComponent);