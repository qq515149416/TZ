import React from "react";
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import TextField from '@material-ui/core/TextField';
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';
import ChangeStatusIcon from "../icon/changeStatus.jsx";
import MenuItem from '@material-ui/core/MenuItem';
import {post} from "../../tool/http";
import { inject } from "mobx-react";

@inject("workOrdersStores")
class ChangeStatus extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currency: "",
            changeStatus: false
        };
        this.status = [
            {
                label: "待处理",
                value: 0
            },
            {
                label: "处理中",
                value: 1  
            },
            {
                label: "完成",
                value: 2
            },
            {
                label: "取消",
                value: 3
            }
        ];
    }
    open = () => {
        this.setState({
            changeStatus: true
        });
    }
    close = () => {
        this.setState({
            changeStatus: false
        });
    }
    changeStatusOperat = () => {
        var confirm_next = confirm("是否要更改"+this.props[this.props.nameParam]+"，状态为："+this.status.find(item => item.value == this.state.currency).label+"?");
        if(confirm_next) {
            post(this.props.postUrl,{
                id: this.props.id,
                work_order_status: this.state.currency,
                process_department: 3,
                summary: this.summary?this.summary.value:""
            }).then((data)=>{
                if(data.data.code==1) {
                    alert(data.data.msg);
                    this.props.workOrdersStores.getData();
                    this.close();
                } else {
                    alert(data.data.msg);
                }
            });
        }
    }
    handleChange = name => event => {
        this.setState({
          [name]: event.target.value,
        });
    }
    render() {
        return [
            (this.props.buttonElement ? this.props.buttonElement :(<Tooltip title="更改状态">
            <IconButton onClick={this.open} aria-label="renewalFee">
                <ChangeStatusIcon />
            </IconButton>
        </Tooltip>)),
            <Dialog
          open={this.state.changeStatus}
          onClose={this.close}
          aria-labelledby="form-dialog-title"
        >
          <DialogTitle id="form-dialog-title">更改状态和所属部门</DialogTitle>
          <DialogContent>
            <TextField
                id="status"
                select
                label="工单状态"
                value={this.state.currency}
                fullWidth
                onChange={this.handleChange('currency')}
                margin="normal"
                >
                {
                    this.status.map(item => (
                        <MenuItem key={item.value} value={item.value}>
                            {item.label}
                        </MenuItem>
                    ))
                }
                
            </TextField>
            {
                this.state.currency==2 && (
                    <TextField
                    margin="dense"
                    id="summary"
                    label="总结"
                    fullWidth
                    inputRef = {ref => this.summary = ref}
                    />
                )
            }
          </DialogContent>
          <DialogActions>
            <Button onClick={this.close} color="primary">
              取消
            </Button>
            <Button onClick={this.changeStatusOperat} color="primary">
              确定
            </Button>
          </DialogActions>
        </Dialog>
        ];
    }
}
export default ChangeStatus;