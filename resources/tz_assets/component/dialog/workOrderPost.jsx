import React from "react";
// import PropTypes from 'prop-types';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
// import DialogContentText from '@material-ui/core/DialogContentText';
import Grid from '@material-ui/core/Grid';
import DialogTitle from '@material-ui/core/DialogTitle';
import TextField from '@material-ui/core/TextField';
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';
import MenuItem from '@material-ui/core/MenuItem';
import WorkOrderIcon from "../icon/workOrder.jsx";
import {get,post} from "../../tool/http";

class WorkOrderPost extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currency: "",
            currency2: "",
            workOrder: false,
            workOrderTypes: [],
            workOrderSubTypes: []
        };
    }
    componentDidMount() {
        get("workorder/work_types").then(res => {
            if(res.data.code==1) {
                this.setState({
                    workOrderTypes: res.data.data
                });
            }
        });
    }
    workOrderPost = () => {

    }
    open = () => {
        this.setState({
            workOrder: true
        });
    }
    close = () => {
        this.setState({
            workOrder: false
        });
    }
    handleChange = name => event => {
        get("workorder/work_types",{
            parent_id: event.target.value
        }).then(res => {
            if(res.data.code==1) {
                if(res.data.data.length) {
                    this.setState({
                        workOrderSubTypes: res.data.data
                    });
                }
            }
        });
        this.setState({
          [name]: event.target.value,
        });
    }
    render() {
        return [
            <Tooltip title="工单提交">
                <IconButton onClick={this.open} aria-label="renewalFee">
                    <WorkOrderIcon />
                </IconButton>
            </Tooltip>,
            <Dialog
            open={this.state.workOrder}
            onClose={this.close}
            aria-labelledby="form-dialog-title"
          >
            <DialogTitle id="form-dialog-title">工单提交</DialogTitle>
            <DialogContent>
                <Grid container spacing={5}>
                    <Grid item xs={6}>
                        <TextField
                        id="workOrderType1"
                        select
                        label="工单类型"
                        value={this.state.currency}
                        onChange={this.handleChange('currency')}
                        margin="normal"
                        >
                            {
                                this.state.workOrderTypes.map(item => (
                                    <MenuItem key={item.id} value={item.id}>
                                        {item.type_name}
                                    </MenuItem>
                                ))
                            }
                            
                        </TextField>
                    </Grid>
                    <Grid item xs={6}>
                        {
                            !!this.state.workOrderSubTypes.length && (
                                <TextField
                                id="workOrderType2"
                                select
                                label="工单类型"
                                value={this.state.currency2}
                                onChange={this.handleChange('currency2')}
                                margin="normal"
                                >
                                    {
                                        this.state.workOrderSubTypes.map(item => (
                                            <MenuItem key={item.id} value={item.id}>
                                                {item.type_name}
                                            </MenuItem>
                                        ))
                                    }
                                </TextField>
                            )
                        }
                    </Grid>
                    <Grid item xs={12}>
                        <TextField
                            margin="dense"
                            id="note"
                            label="备注"
                            fullWidth
                            inputRef = {ref => this.note = ref}
                        />
                    </Grid>
                </Grid>
            </DialogContent>
            <DialogActions>
              <Button onClick={this.close} color="primary">
                取消
              </Button>
              <Button onClick={this.workOrderPost} color="primary">
                确定
              </Button>
            </DialogActions>
          </Dialog>
        ];
    }
}
export default WorkOrderPost;