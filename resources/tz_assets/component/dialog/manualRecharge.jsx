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
import RenewalFeeIcon from "../icon/renewalFee.jsx";
import MenuItem from '@material-ui/core/MenuItem';
import {post} from "../../tool/http";
class ManualRecharge extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currency: 1,
            manualRecharge: false
        }
    }
    open = () => {
        this.setState({
            manualRecharge: true
        });
    }
    close = () => {
        this.setState({
            manualRecharge: false
        });
    }
    manualRechargeOperat = () => {
        var confirm_next = confirm("是否要为"+this.props[this.props.nameParam]+"，充值"+this.recharge_amount.value+"元?");
        if(confirm_next) {
            post(this.props.postUrl,{
                user_id: this.props.id,
                recharge_amount: this.recharge_amount.value,
                recharge_way: this.state.currency,
                remarks: this.note.value
            }).then((data)=>{
                if(data.data.code==1) {
                    alert("充值成功");
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
            <Tooltip title="手动充值">
                    <IconButton onClick={this.open} aria-label="renewalFee">
                        <RenewalFeeIcon />
                    </IconButton>
                </Tooltip>,
            <Dialog
          open={this.state.manualRecharge}
          onClose={this.close}
          aria-labelledby="form-dialog-title"
        >
          <DialogTitle id="form-dialog-title">手动充值</DialogTitle>
          <DialogContent>
          <TextField
              margin="dense"
              id="note"
              label="充值金额"
              fullWidth
              inputRef = {ref => this.recharge_amount = ref}
            />
            {/* <TextField
              margin="dense"
              id="note"
              label="充值方式"
              helperText="如'微信'/'支付宝'/'农业银行'/'工商银行'"
              fullWidth
              inputRef = {ref => this.recharge_method = ref}
            /> */}
            <TextField
            id="recharge_way"
            select
            label="付款方式"
            fullWidth
            value={this.state.currency}
            onChange={this.handleChange('currency')}
            margin="normal"
            >
                <MenuItem value={1}>
                   银行
                </MenuItem>
                <MenuItem value={2}>
                   第三方平台
                </MenuItem>
            </TextField>
            <TextField
              margin="dense"
              id="note"
              label="备注"
              fullWidth
              inputRef = {ref => this.note = ref}
            />
          </DialogContent>
          <DialogActions>
            <Button onClick={this.close} color="primary">
              取消
            </Button>
            <Button onClick={this.manualRechargeOperat} color="primary">
              确定
            </Button>
          </DialogActions>
        </Dialog>
        ];
    }
}
export default ManualRecharge;
