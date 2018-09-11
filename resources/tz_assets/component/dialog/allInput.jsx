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
const E = require('wangeditor');
const AllInputStyle = theme => ({
    button: {
        margin: theme.spacing.unit
    },
    textField: {
        width: theme.breakpoints.values.sm + 100
    },
    menu: {
        width: theme.breakpoints.values.sm / 2,
    },
    dialog: {
        maxWidth: theme.breakpoints.values.sm + 150
    },
    formControl: {
        margin: theme.spacing.unit * 3,
    },
    richText: {
        width: theme.breakpoints.values.sm + 100
    },
    dialogContent: {
        height: 600
    }
});
class AllInput extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open: false,
            inputAttr: this.inputAttr()
        };
        this.editor = null;
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
                        const currCode = this.props.editData ? ((item.model&&item.model.selectCode) ? item.model.selectCode(this.props.editData[item.field]):this.props.editData[item.field]) : item.radioData.find(e => e.checked).value;
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
                            label: item.label,
                            radioData: item.radioData
                        }
                    });
                    
                } else if(item.type=="rich_text") {
                    // let editor = null;
                    // if(document.getElementById("editor")) {
                    //     editor = new E('#editor');
                    //     editor.customConfig.onchange = (html) => {
                    //         this[item.field] = {
                    //             value: html
                    //         }
                    //     }
                    //     editor.create();
                    // }
                    Object.assign(inputAttr,{
                        [item.field]: {
                            label: item.label
                        }
                    });
                } else {
                    // this[item.field] = {
                    //     value : this.props.editData ? this.props.editData[item.field] : ""
                    // };
                    let disabled = false;
                    if(item.rule) {
                        if(item.rule.term=="edit"&&item.rule.execute=="disabled"&&this.props.editData) {
                            disabled = true;
                        }
                    }
                    Object.assign(inputAttr,{
                        [item.field]: {
                            error: false,
                            label: item.label,
                            defaultValue: this.props.editData ? this.props.editData[item.field] : "",
                            disabled: disabled,
                            helperText: item.helperText
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
        let currentItem = this.props.inputType.find(item=>item.field==name.split(".")[0]);
        if(currentItem.model) {
            console.log(currentItem.model.getSubordinateData);
            currentItem.model.getSubordinateData && currentItem.model.getSubordinateData(this);
        }
        this.setState(state => state.inputAttr[name.split(".")[0]][name.split(".")[1]] = event.target.value);
    };
    handleChecke = name => event => {
        this[name.split(".")[0]] = {
            value: event.target.value
        };
        let currentItem = this.props.inputType.find(item=>item.field==name.split(".")[0]);
        if(currentItem.model) {
            currentItem.model.getSubordinateData && currentItem.model.getSubordinateData(this);
        }
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
        let status = true;
        if(inputTypeData.rule&&inputTypeData.rule.type&&inputTypeData.rule.type=="add") {
            if(this.props.editData) {
                status = false;
            }
        }
        if(inputTypeData.rule&&inputTypeData.rule.type&&inputTypeData.rule.type=="edit") {
            if(!this.props.editData) {
                status = false;
            }
        }
        switch(inputTypeData.type) {
            case "rich_text":
                if(status) {
                    return (
                        <div id="editor" className={classes.richText}>
                        </div>
                    );
                } else {
                    return null;
                }
            case "text":
            if(status) {
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
                        disabled={inputAttr[inputTypeData.field].disabled}
                        helperText={inputAttr[inputTypeData.field].helperText ? inputAttr[inputTypeData.field].helperText : null}
                    />
                );
            } else {
                return null;
            }
            case "select":
            if(status) {
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
                );
            } else {
                return null;
            }
                
            case "switch":
            if(status) {
                return (
                    <div>
                        <h5>{inputAttr[inputTypeData.field].label}</h5>
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
            } else {
                return null;
            }
                
        }
    }
    showDialog = () => {
        if(this.dialogOpen) {
            this.setState({
                inputAttr: this.inputAttr()
            });
            this.dialogOpen = false;
        }
        let editor = null;
        if(document.getElementById("editor")) {
            editor = new E('#editor');
            editor.customConfig.onchange = (html) => {
                this[this.props.inputType.find(item => item.type=="rich_text").field] = {
                    value: html
                }
            }
            editor.create();
            if(this.props.editData&&this.props.editData.content) {
                editor.txt.html(this.props.editData.content);
            } else {
                editor.txt.html("请输入内容....");
            }
        }
    }
    render() {
        const {classes, title, inputType, operattext} = this.props;
        return (
            <Dialog
            open={this.state.open}
            onClose={this.handleClose}
            aria-labelledby="form-dialog-title"
            maxWidth="md"
            onEntered={this.showDialog}
            PaperProps={{
                className: classes.dialog
            }}
          >
            <DialogTitle id="form-dialog-title">{title}</DialogTitle>
            <DialogContent className={classes.dialogContent}>
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