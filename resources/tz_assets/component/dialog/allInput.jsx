import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
// import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import MenuItem from '@material-ui/core/MenuItem';
import Radio from '@material-ui/core/Radio';
import FormLabel from '@material-ui/core/FormLabel';
const AllInputStyle = theme => ({
    button: {
        margin: theme.spacing.unit
    },
    textField: {
        width: theme.breakpoints.values.sm
    },
    menu: {
        width: theme.breakpoints.values.sm / 2,
    },
    dialog: {
        maxWidth: theme.breakpoints.values.sm + 50
    },
    formControl: {
        margin: theme.spacing.unit * 3,
    }
});
class AllInput extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open: false,
            inputAttr: this.inputAttr()
        };
    }
    componentDidMount() {
        this.setState({
            inputAttr: this.inputAttr()
        });
        this.dialogOpen = true;
        this.props.getRef(this);
    }
    inputAttr = () => {
        let inputAttr = {};
        if(this.props.inputType) {
            this.props.inputType.forEach(item => {
                if(item.type=="select") {
                    let defaultValue = (item.defaultData.length>0?item.defaultData[0].value:"");
                    this[item.field] = {
                        value : this.props.editData ? ((item.model&&item.model.selectCode) ? item.model.selectCode(this.props.editData[item.field]): this.props.editData[item.field]) : defaultValue
                    };
                    Object.assign(inputAttr,{
                        [item.field]: {
                            label: item.label,
                            currency: this.props.editData ? ((item.model&&item.model.selectCode) ? item.model.selectCode(this.props.editData[item.field]): this.props.editData[item.field]) : defaultValue
                        }
                    });
                }else if(item.type=="switch") {
                    if(this.props.editData) {
                        const currCode = ((item.model&&item.model.selectCode) ? item.model.selectCode(this.props.editData[item.field]):this.props.editData[item.field]);
                        item.radioData.forEach(e => {
                            if(e.value==currCode) {
                                e.checked = true;
                            } else {
                                e.checked = false;
                            }
                        });
                    }
                    this[item.field] = {
                        value : item.radioData.find(e => e.checked).value
                    };
                    Object.assign(inputAttr,{
                        [item.field]: {
                            radioData: item.radioData
                        }
                    });
                    
                } else {
                    // this[item.field] = {
                    //     value : this.props.editData ? this.props.editData[item.field] : ""
                    // };
                    Object.assign(inputAttr,{
                        [item.field]: {
                            error: false,
                            label: item.label,
                            defaultValue: this.props.editData ? this.props.editData[item.field] : ""
                        }
                    });
                }
            });
        }
        return inputAttr;
    }
    handleChange = name => event => {
        this[name.split(".")[0]] = {
            value: event.target.value
        };
        this.setState(state => state.inputAttr[name.split(".")[0]][name.split(".")[1]] = event.target.value);
    };
    handleChecke = name => event => {
        this[name.split(".")[0]] = {
            value: event.target.value
        };
        const checkedIndex = this.state.inputAttr[name.split(".")[0]][name.split(".")[1]].findIndex(item=>item.value==event.target.value);
        this.setState(state => {
            state.inputAttr[name.split(".")[0]][name.split(".")[1]].forEach(item => {
                item.checked = false;
            });
            state.inputAttr[name.split(".")[0]][name.split(".")[1]][checkedIndex].checked = true;
            return state;
        });
    }
    handleClickOpen = () => {
        this.setState({ open: true });
    } 
    handleClose = () => {
        this.setState({ open: false });
    };
    returnInput = inputTypeData => {
        const {classes} = this.props;
        const {inputAttr} = this.state;
        switch(inputTypeData.type) {
            case "text":
                return (
                    <TextField
                        error={inputAttr[inputTypeData.field].error}
                        margin="dense"
                        id={inputTypeData.field}
                        label={inputAttr[inputTypeData.field].label}
                        type="text"
                        fullWidth
                        className={classes.textField}
                        defaultValue={inputAttr[inputTypeData.field].defaultValue}
                        inputRef = {(ref) => this[inputTypeData.field] = ref}
                    />
                )
            case "select":
                return (
                    <TextField
                        id="site"
                        select
                        label={inputAttr[inputTypeData.field].label}
                        className={classes.textField}
                        value={inputAttr[inputTypeData.field].currency}
                        onChange={this.handleChange(inputTypeData.field+'.currency')}
                        SelectProps={{
                            MenuProps: {
                                className: classes.menu
                            },
                        }}
                        margin="normal"
                    >
                        {
                            inputTypeData.defaultData.map(item => (
                                <MenuItem value={item.value}>
                                    {item.text}
                                </MenuItem>
                            ))
                        }
                       
                        
                    </TextField>
                )
            case "switch":
                return (
                    <div>
                        {
                            inputAttr[inputTypeData.field].radioData.map(e => (
                                <FormLabel>
                                    <Radio checked={e.checked} onChange={this.handleChecke(inputTypeData.field+".radioData")} value={e.value} name={e.label} aria-label={e.label} />
                                    {e.label}
                                </FormLabel>
                            ))
                        }
                        
                    </div>
                );
        }
    }
    showDialog = () => {
        if(this.dialogOpen) {
            this.setState({
                inputAttr: this.inputAttr()
            });
            this.dialogOpen = false;
        }
    }
    render() {
        const {classes, title, inputType, operattext} = this.props;
        return (
            <Dialog
            open={this.state.open}
            onClose={this.handleClose}
            aria-labelledby="form-dialog-title"
            maxWidth="sm"
            onEntered={this.showDialog}
            PaperProps={{
                className: classes.dialog
            }}
          >
            <DialogTitle id="form-dialog-title">{title}</DialogTitle>
            <DialogContent>
                {
                    inputType.map(item => this.returnInput(item))
                }              
            </DialogContent>
            <DialogActions>
              <Button onClick={this.handleClose} color="primary">
                取消
              </Button>
              <Button onClick={this.props.post} color="primary">
                {operattext}
              </Button>
            </DialogActions>
          </Dialog>
        );
    }
}
AllInput.propTypes = {
    classes: PropTypes.object.isRequired,
};
const AllInputRender = (props) => {
    return <AllInput {...props} />
}
export default withStyles(AllInputStyle)(AllInputRender);