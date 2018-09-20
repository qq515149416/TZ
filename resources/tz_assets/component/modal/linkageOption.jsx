import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Modal from '@material-ui/core/Modal';
import Button from '@material-ui/core/Button';
import MenuItem from '@material-ui/core/MenuItem';
import TextField from '@material-ui/core/TextField';
import Radio from '@material-ui/core/Radio';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import {get} from "../../tool/http.js";
import { inject,observer } from "mobx-react";

const styles = theme => ({
    paper: {
      position: 'absolute',
      width: theme.spacing.unit * 150,
      backgroundColor: theme.palette.background.paper,
      boxShadow: theme.shadows[5],
      padding: theme.spacing.unit * 4,
      left: "50%",
      top: "50%",
      transform: "translate(-50%,-50%)"
    },
    bottom: {
        textAlign: "right"
    }
});

@inject("MachineRoomsStores")
@observer 
class LinkageOption extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open: false,
            currency: "",
            selectedValue: "",
            machines: [],
            machineSelected: ""
        };
    }
    componentDidMount() {
        this.props.getRef && this.props.getRef(this);
        this.props.MachineRoomsStores.getData();
    }
    getMachineData = param => event => {
        get("business/selectmachine",param).then(res => {
            if(res.data.code==1) {
                this.setState({
                    machines: res.data.data
                });
            }
        });
    }
    handleOpen = () => {
        this.setState({ open: true });
    }
    handleClose = () => {
        this.setState({ open: false });
    }
    handleChange = name => event => {
        this.setState({
          [name]: event.target.value,
        });
    }
    render() {
        const { classes } = this.props;
        return (
            <Modal
                aria-labelledby="simple-modal-title"
                aria-describedby="simple-modal-description"
                open={this.state.open}
                onClose={this.handleClose}
            >
                <div className={classes.paper}>
                    <TextField
                        id="machineRoom-select-currency"
                        select
                        label="机房"
                        value={this.state.currency}
                        onChange={this.handleChange('currency')}
                        margin="normal"
                    >
                        {this.props.MachineRoomsStores.machineRooms.map(option => (
                            <MenuItem key={option.id} value={option.id}>
                                {option.machine_room_name}
                            </MenuItem>
                        ))}
                    </TextField>
                    <label>
                        <Radio
                            checked={this.state.selectedValue === '1'}
                            onChange={this.handleChange('selectedValue')}
                            value="1"
                            name="type"
                            aria-label="A"
                        />
                        租用主机
                    </label>
                    <label>
                        <Radio
                            checked={this.state.selectedValue === '2'}
                            onChange={this.handleChange("selectedValue")}
                            value="2"
                            name="type"
                            aria-label="B"
                        />
                        托管主机
                    </label>
                    <Button variant="contained" onClick={this.getMachineData({
                        machineroom: this.state.currency,
                        business_type: this.state.selectedValue
                    })} color="primary">
                        获取所属机房
                    </Button>
                    <div>
                    <Table>
                        <TableHead>
                        <TableRow>
                            <TableCell numeric>
                                *
                            </TableCell>
                            <TableCell numeric>机器编号</TableCell>
                            <TableCell numeric>CPU</TableCell>
                            <TableCell numeric>内存</TableCell>
                            <TableCell numeric>硬盘</TableCell>
                            <TableCell numeric>机柜编号</TableCell>
                            <TableCell numeric>IP</TableCell>
                            {/* <TableCell numeric>机房名</TableCell>
                            <TableCell numeric>带宽</TableCell>
                            <TableCell numeric>防护</TableCell>
                            <TableCell numeric>防护</TableCell>
                            <TableCell numeric>登录名</TableCell>
                            <TableCell numeric>登录密码</TableCell>
                            <TableCell numeric>机器型号</TableCell>
                            <TableCell numeric>使用状态</TableCell>
                            <TableCell numeric>机器状态</TableCell>
                            <TableCell numeric>业务类型</TableCell> */}
                        </TableRow>
                        </TableHead>
                        <TableBody>
                        {this.state.machines.map(row => {
                            return (
                            <TableRow key={row.id}>
                                <TableCell numeric>
                                    <Radio
                                        checked={this.state.machineSelected === row.id}
                                        onChange={this.handleChange("machineSelected")}
                                        value={row.id}
                                        name="machine"
                                        aria-label={row.id}
                                    />
                                </TableCell>
                                <TableCell numeric>
                                {row.machine_num}
                                </TableCell>
                                <TableCell numeric>{row.cpu}</TableCell>
                                <TableCell numeric>{row.memory}</TableCell>
                                <TableCell numeric>{row.harddisk}</TableCell>
                                <TableCell numeric>{row.cabinets}</TableCell>
                                <TableCell numeric>{row.ip_detail}</TableCell>
                                {/* <TableCell numeric>{row.machineroom_name}</TableCell>
                                <TableCell numeric>{row.bandwidth}</TableCell>
                                <TableCell numeric>{row.protect}</TableCell>
                                <TableCell numeric>{row.loginname}</TableCell>
                                <TableCell numeric>{row.loginpass}</TableCell>
                                <TableCell numeric>{row.machine_type}</TableCell>
                                <TableCell numeric>{row.used}</TableCell>
                                <TableCell numeric>{row.status}</TableCell>
                                <TableCell numeric>{row.business}</TableCell>
                                <TableCell numeric>{row.machine_note}</TableCell> */}
                            </TableRow>
                            );
                        })}
                        </TableBody>
                    </Table>
                    </div>
                    <div className={classes.bottom}>
                        <Button variant="contained" color="primary">
                            确定
                        </Button>
                    </div>
                </div>
            </Modal>
        );
    }
}
LinkageOption.propTypes = {
    classes: PropTypes.object.isRequired,
};
const LinkageOptionWrapped = (props) => <LinkageOption {...props} />;

export default withStyles(styles)(LinkageOptionWrapped);