import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Paper from '@material-ui/core/Paper';
import {get} from "../tool/http";
import TabComponent from "../component/tabComponent.jsx";


const styles = theme => ({
    root: {
      width: '100%',
    //   marginTop: theme.spacing.unit * 3,
      overflowX: 'auto',
    },
    table: {
      minWidth: 700,
    },
});

const types = {
    overdueCabinet: {
        url: "overdue/showOverdueCabinet",
        columnData: [
            { id: 'business_number', label: '业务编号' },
            { id: 'cabinet_number', label: '机柜编号' },
            { id: 'client_name', label: '客户名称' },
            { id: 'endding_time', label: '到期时间' },
            { id: 'machine_room_name', label: '所属机房' }
        ]
    },
    overdueMachine: {
        url: "overdue/showOverdueMachine",
        columnData: [
            { id: 'business_number', label: '业务编号' },
            { id: 'machine_number', label: '机器编号' },
            { id: 'client_name', label: '客户名称' },
            { id: 'endding_time', label: '到期时间' },
            { id: 'ip', label: 'IP地址' }
        ]
    },
    overdueRes: {
         url: "overdue/showOverdueRes",
         columnData: [
            { id: 'business_number', label: '业务编号' },
            { id: 'cabinet_num', label: '机柜编号' },
            { id: 'machine_num', label: '机器编号' },
            { id: 'customer_name', label: '客户名称' },
            { id: 'end_time', label: '到期时间' },
            { id: 'resource_type', label: '资源类型' },
            { id: 'self_number', label: '自身编号' }
        ]
    },
    unpaidMachine: {
        url: "overdue/showUnpaidMachine",
        columnData: [
            { id: 'business_number', label: '业务编号' },
            { id: 'machine_number', label: '机器编号' },
            { id: 'client_name', label: '客户名称' },
            { id: 'endding_time', label: '到期时间' },
            { id: 'ip', label: 'ip地址' },
            { id: 'start_time', label: '启用时间' }
        ]
    },
    xiaJiaMachine: {
        url: "overdue/showXiaJiaMachine",
        columnData: [
            { id: 'business_number', label: '业务编号' },
            { id: 'machine_number', label: '机器编号' },
            { id: 'client_name', label: '客户名称' },
            { id: 'endding_time', label: '到期时间' },
            { id: 'ip', label: 'ip地址' },
            { id: 'start_time', label: '启用时间' }
        ]
    },
    unpaidCabinet: {
        url: "overdue/showUnpaidCabinet",
        columnData: [
            { id: 'business_number', label: '业务编号' },
            { id: 'cabinet_number', label: '机柜编号' },
            { id: 'client_name', label: '客户名称' },
            { id: 'endding_time', label: '到期时间' },
            { id: 'machine_room_name', label: '所属机房' },
            { id: 'start_time', label: '启用时间' }
        ]
    },
    xiaJiaRes: {
        url: "overdue/showXiaJiaRes",
        columnData: [
            { id: 'business_number', label: '业务编号' },
            { id: 'cabinet_num', label: '机柜编号' },
            { id: 'machine_num', label: '机器编号' },
            { id: 'customer_name', label: '客户名称' },
            { id: 'end_time', label: '到期时间' },
            { id: 'resource_type', label: '资源类型' },
            { id: 'self_number', label: '自身编号' }
        ]
    }
};

class Home extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            type: "overdueCabinet",
            data: []
        };
    }
    componentDidMount() {
        const {type} = this.state;
        this.byTypeGetData(type);
    }
    byTypeGetData = (type) => {
        this.setState({
            data: []
        });
        get(types[type].url).then(res => {
            if(res.data.code==1) {
                this.setState({
                    data: res.data.data
                });
            } else {
                console.warn(res.data.msg);
            }
        });
    }
    handleChange = (value) => {
        this.byTypeGetData(value);
        this.setState({
            type: value
        });
    }
    render() {
        const { classes } = this.props;
        const {type,data} = this.state;
        return (
            <TabComponent types={[
                {label: "5天内到期机柜", value: "overdueCabinet"},
                {label: "5天内到期机器", value: "overdueMachine"},
                {label: "5天内到期资源", value: "overdueRes"},
                {label: "未支付使用的机器", value: "unpaidMachine"},
                {label: "最近下架机器", value: "xiaJiaMachine"},
                {label: "未支付使用的机柜", value: "unpaidCabinet"},
                {label: "下架资源", value: "xiaJiaRes"}
            ]} type={type} onChange={this.handleChange}>
                <Paper className={classes.root}>
                <Table className={classes.table}>
                    <TableHead>
                    <TableRow>
                        <TableCell>ID</TableCell>
                        {
                            types[type].columnData.map(item => (
                                <TableCell numeric>{item.label}</TableCell>
                            ))
                        }
                    </TableRow>
                    </TableHead>
                    <TableBody>
                    {data.map(row => {
                        return (
                        <TableRow key={row.id}>
                            <TableCell component="th" scope="row">
                                {row.id}
                            </TableCell>
                            {
                                types[type].columnData.map(item => (
                                    <TableCell numeric>{row[item.id]}</TableCell>
                                ))
                            }
                        </TableRow>
                        );
                    })}
                    </TableBody>
                </Table>
            </Paper>
            </TabComponent>
        );
    }
}
Home.propTypes = {
    classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(Home);