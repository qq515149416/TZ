import React from "react";
// import PropTypes from 'prop-types';
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
class RenewalFee extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currency: "",
            renewalFee: false
        }
        this.renewalFeeDates = [
            {
                label: "一个月",
                value: 1
            },
            {
                label: "半年",
                value: 6  
            },
            {
                label: "一年",
                value: 12
            }
        ];
    }
    open = () => {
        this.setState({
            renewalFee: true
        });
    }
    close = () => {
        this.setState({
            renewalFee: false
        });
    }
    renewalFeeOperat = () => {
        var confirm_next = confirm("是否要将"+this.props[this.props.nameParam]+this.props.type+"，续费"+this.renewalFeeDates.find(item => {
            return item.value == this.state.currency;
        }).label+"?");
        if(confirm_next) {
            this.props.length = this.state.currency;
            this.props.order_note = this.note.value;
            post(this.props.postUrl,{
            //    ...this.props,
               business_number: this.props.business_sn?this.props.business_sn:this.props.business_number,
               order_sn: this.props.order_sn ? this.props.order_sn : undefined,
               price: this.props.money,
               length: this.props.length,
               order_note: this.props.order_note,
               client_id: this.props.customer_id?this.props.customer_id:this.props.client_id,
               resource_type: this.props.resource_type?this.props.resource_type:this.props.business_type
            }).then((data)=>{
                if(data.data.code==1) {
                    alert("续费成功");
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
            <Tooltip title="续费">
                    <IconButton onClick={this.open} aria-label="renewalFee">
                        <RenewalFeeIcon />
                    </IconButton>
                </Tooltip>,
            <Dialog
          open={this.state.renewalFee}
          onClose={this.close}
          aria-labelledby="form-dialog-title"
        >
          <DialogTitle id="form-dialog-title">续费</DialogTitle>
          <DialogContent>
            <DialogContentText>
              续费业务和资源的订单
            </DialogContentText>
            <TextField
            id="renewalFee_duration"
            select
            label="时长"
            value={this.state.currency}
            onChange={this.handleChange('currency')}
            margin="normal"
            >
                {
                    this.renewalFeeDates.map(item => (
                        <MenuItem key={item.value} value={item.value}>
                            {item.label}
                        </MenuItem>
                    ))
                }
                
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
            <Button onClick={this.renewalFeeOperat} color="primary">
              确定
            </Button>
          </DialogActions>
        </Dialog>
        ];
    }
}
export default RenewalFee;