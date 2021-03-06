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
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import FormLabel from '@material-ui/core/FormLabel';
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
    },
    list: {
        overflow: 'auto',
        maxHeight: 400,
    }
});

@observer 
class SelectModal extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open: false,
            type: "",
            itemChecked: 0,
            lineChecked: 0
        };
        this.type = "";
    }
    componentDidMount() {
        this.props.getRef && this.props.getRef(this);
    }
    handleOpen = (type) => {
        if(this.selectedMachineValue(type)==4) {
            this.props.getData({
                resource_type: {
                    value: 4
                },
                company: 0
            });
        }
        this.type = type;
        this.setState({ open: true });
    }
    handleClose = () => {
        this.setState({ open: false });
    }
    handleChange = event => {
        if(this.selectedMachineValue(this.type)==4) {
            this.props.getData({
                resource_type: {
                    value: 4
                },
                company: event.target.value
            });
        }
        this.setState({ lineChecked: event.target.value });
    }
    setCheckBoxValue = (name,value) => {
        this.selectedData = this.props.data.find(item => item.text==value);
        this.setState({
            [name]: value,
        });
    }
    selectedMachineValue = (type) => {
        switch(type) {
            case "ip_resource":
                return 4
            case "cpu_resource":
                return 5
            case "hardDisk_resource":
                return 6
            case "ram_resource":
                return 7
            case "bandwidth":
                return 8
            default:
                return 9
        }
    }
    selectedValue = () => {
        this.props.setCurrentData(this.selectedData,this.selectedMachineValue(this.type));
        this.handleClose();
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
                    {
                        this.selectedMachineValue(this.type) == 4 ? [
                            <FormLabel>
                                <Radio
                                    checked={this.state.lineChecked==0}
                                    value={0}
                                    name="ip_resource"
                                    aria-label={"ip_resource0"}
                                    onChange={this.handleChange}
                                /> ??????
                            </FormLabel>,
                            <FormLabel>
                                <Radio
                                    checked={this.state.lineChecked==1}
                                    value={1}
                                    name="ip_resource"
                                    aria-label={"ip_resource1"}
                                    onChange={this.handleChange}
                                /> ??????
                            </FormLabel>,
                            <FormLabel>
                                <Radio
                                    checked={this.state.lineChecked==2}
                                    value={2}
                                    name="ip_resource"
                                    aria-label={"ip_resource2"}
                                    onChange={this.handleChange}
                                /> ??????
                            </FormLabel>
                        ]:null
                    }
                    <List className={classes.list}>
                        {
                            this.props.data.map(item => (
                                <ListItem onClick={() => this.setCheckBoxValue("itemChecked",item.text)} divider button>
                                    <Radio
                                        checked={this.state.itemChecked==item.text}
                                        value={item.text}
                                        name="itemChecked"
                                        aria-label={"item_id_"+item.text}
                                    />
                                    <ListItemText primary={item.text} />
                                </ListItem>
                            ))
                        }
                        
                    </List>
              
                    <div className={classes.bottom}>
                        <Button variant="contained" onClick={this.selectedValue} color="primary">
                            ??????
                        </Button>
                    </div>
                </div>
            </Modal>
        );
    }
}
SelectModal.propTypes = {
    classes: PropTypes.object.isRequired,
};
const SelectModalWrapped = (props) => <SelectModal {...props} />;

export default withStyles(styles)(SelectModalWrapped);