import React from "react";
// import PropTypes from 'prop-types';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';
import Order from "../icon/order.jsx";
import {post} from "../../tool/http";
class OrderShow extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            order: false
        }
    }
    open = () => {
        post("business/clerk",{
            business_sn: this.props.business_sn
        }).then(res => {
            if(res.data.code==1) {
                this.setState({
                    order: true
                });
            }
        });
    }
    close = () => {
        this.setState({
            order: false
        });
    }
    render() {
        return [
            <Tooltip title="查看业务订单">
                    <IconButton onClick={this.open} aria-label="changePassword">
                        <Order />
                    </IconButton>
                </Tooltip>,
            <Dialog
          open={this.state.order}
          onClose={this.close}
          aria-labelledby="form-dialog-title"
        >
          <DialogTitle id="form-dialog-title">查看业务订单</DialogTitle>
          <DialogContent>
            <DialogContentText>
              此功能是后台替用户强制修改密码
            </DialogContentText>
          </DialogContent>
          <DialogActions>
            <Button onClick={this.close} color="primary">
              关闭
            </Button>
          </DialogActions>
        </Dialog>
        ];
    }
}
export default OrderShow;