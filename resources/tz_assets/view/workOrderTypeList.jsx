import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import ListSubheader from '@material-ui/core/ListSubheader';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import Collapse from '@material-ui/core/Collapse';
import ExpandLess from '@material-ui/icons/ExpandLess';
import ExpandMore from '@material-ui/icons/ExpandMore';
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import MenuItem from '@material-ui/core/MenuItem';
import { inject,observer } from "mobx-react";

const styles = theme => ({
    root: {
      width: '100%',
      backgroundColor: theme.palette.background.paper,
    },
    nested: {
      paddingLeft: theme.spacing.unit * 4,
    },
    fl: {
        float: "left"
    },
    fr: {
        float: "right"
    },
    clearFix: {
        "&:before,&:after": {
            content:"",
            display: "table"
        },
        "&:after": {
            clear: "both"
        }
    },
    button: {
        marginTop: 5
    }
});

@inject("workOrderTypesStores")
@observer 
class WorkOrderTypeList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open: [true,false],
            dialogState: false,
            currency: 0
        };
    }
    componentDidMount() {
        this.props.workOrderTypesStores.getData();
    }
    handleClick = index => event => {
        this.setState(state => {
            state.open[index] = !state.open[index];
            return state;
        });
    }
    handleChange = name => event => {
        this.setState({
          [name]: event.target.value,
        });
    }
    closeDialogState = event => {
        this.setState(state => {
            state.dialogState = false;
            return state;
        });
    }
    openDialogState = event => {
        this.setState(state => {
            state.dialogState = true;
            return state;
        });
    }
    postAddType = event => {
        this.props.workOrderTypesStores.addData({
            type_name: this.typename.value,
            parent_id: this.state.currency
        }).then(state => {
            if(state) {
                this.closeDialogState();
            }
        });
    }
    render() {
        const { classes } = this.props;
        return (
            <div className={classes.root}>
                <List
                    component="nav"
                    subheader={<ListSubheader className={classes.clearFix} component="div">
                        <span className={classes.fl}>工单类型管理</span>
                        <Button variant="contained" onClick={this.openDialogState} className={`${classes.fr} ${classes.button}`} color="primary">
                            类型提交
                        </Button>
                    </ListSubheader>}
                >
                    <ListItem button onClick={this.handleClick(0)}>
                        <ListItemText primary="Inbox" />
                        {this.state.open[0] ? <ExpandLess /> : <ExpandMore />}
                    </ListItem>
                    <Collapse in={this.state.open[0]} timeout="auto" unmountOnExit>
                        <List component="div" disablePadding>
                            <ListItem button className={classes.nested}>
                                <ListItemText primary="Starred" />
                            </ListItem>
                        </List>
                    </Collapse>
                    <ListItem button onClick={this.handleClick(1)}>
                        <ListItemText primary="Test" />
                        {this.state.open[1] ? <ExpandLess /> : <ExpandMore />}
                    </ListItem>
                    <Collapse in={this.state.open[1]} timeout="auto" unmountOnExit>
                        <List component="div" disablePadding>
                        </List>
                    </Collapse>
                </List>
                <Dialog
                    open={this.state.dialogState}
                    onClose={this.closeDialogState}
                    aria-labelledby="form-dialog-title"
                    >
                    <DialogTitle id="form-dialog-title">工单类型添加</DialogTitle>
                    <DialogContent>
                        <TextField
                        id="parent_type_id"
                        select
                        label="父级"
                        fullWidth
                        value={this.state.currency}
                        onChange={this.handleChange('currency')}
                        margin="normal"
                        >
                            <MenuItem key={0} value={0}>
                                 <em>None</em>
                            </MenuItem>
                            {this.props.workOrderTypesStores.workOrderTypes.map(option => (
                               option.parent_id==0 ? (<MenuItem key={option.id} value={option.id}>
                                    {option.type_name}
                                </MenuItem>) : null
                            ))}
                        </TextField>
                        <TextField
                            margin="dense"
                            id="typename"
                            label="工单类型名称"
                            fullWidth
                            inputRef={ref => this.typename = ref}
                        />
                    </DialogContent>
                    <DialogActions>
                        <Button onClick={this.closeDialogState}>
                            取消
                        </Button>
                        <Button onClick={this.postAddType} color="primary">
                            确定
                        </Button>
                    </DialogActions>
                    </Dialog>
            </div>
        );
    }
}
WorkOrderTypeList.propTypes = {
    classes: PropTypes.object.isRequired,
};
export default withStyles(styles)(WorkOrderTypeList);