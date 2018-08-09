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
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';
import EditIcon from '@material-ui/icons/Edit';
import Radio from '@material-ui/core/Radio';
import FormLabel from '@material-ui/core/FormLabel';
const UsersLinkPostStyle = theme => ({
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
class UsersLinkPost extends React.Component {
    constructor(props) {
        super(props);
        let inputAttr = {};
        if(this.props.inputType) {
            this.props.inputType.forEach(item => {
                if(item.type=="select") {
                    let defaultValue = (item.defaultData.length>0?item.defaultData[0].value:"");
                    Object.assign(inputAttr,{
                        [item.field]: {
                            label: item.label,
                            currency: this.props.editData ? ((item.model&&item.model.selectCode) ? item.model.selectCode(this.props.editData[item.field]): this.props.editData[item.field]) : defaultValue
                        }
                    });
                }else if(item.type=="switch") {
                    if(this.props.editData) {
                        item.radioData.forEach(e => {
                            e.checked = false;
                        });
                        item.radioData.find(e => e.value==this.props.editData[item.field]).checked = true;
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
                    this[item.field] = {
                        value : this.props.editData ? this.props.editData[item.field] : ""
                    };
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
        this.state = {
            open: false,
            inputAttr
        };
    }
    handleClickOpen = event => {
        this.setState({ open: true });
        event.stopPropagation();
    };
    
    handleClose = () => {
        this.setState({ open: false });
    };
    postUserLink = () => {
        // console.log(this.contactname.value);
        let {inputAttr} = this.state;
        if(this.props.postType == "add") {
            this.props.addData(this.decompressionParam(),(data) => {
                if(data) {
                    this.setState({ open: false });
                } else {
                    alert("添加失败");
                }
                
            });
        }
        if(this.props.postType == "edit") {
            this.props.changeData(Object.assign(this.decompressionParam(),{
                id: this.props.editData.id
            }),(data) => {
                if(data) {
                    this.setState({ open: false });
                }
            });
        }
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
    decompressionParam = () => {
        let returnObj = {};
        this.props.inputType.forEach(item => {
            if(this[item.field]) {
                returnObj[item.field] = this[item.field].value;
            } else {
                console.warn(this[item.field],item.field);
            }
            
        });
        return returnObj
    }
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
    render() {
        const {classes, postType} = this.props;
        
        return [
            <span>
              {
                postType == "add" ? (
                <Button variant="contained" onClick={this.handleClickOpen} color="primary" className={classes.button}>
                    添加{this.props.operattext}
                </Button>
                ) : (
                    <Tooltip title="编辑">
                        <IconButton onClick={this.handleClickOpen} aria-label="Edit">
                            <EditIcon />
                        </IconButton>
                    </Tooltip>
                )
              }
            </span>,
            <Dialog
            open={this.state.open}
            onClose={this.handleClose}
            aria-labelledby="form-dialog-title"
            maxWidth="sm"
            PaperProps={{
                className: classes.dialog
            }}
          >
            <DialogTitle id="form-dialog-title">{postType == "add" ? "添加" : "修改"}{this.props.operattext}</DialogTitle>
            <DialogContent>
                {
                    this.props.inputType.map(item => this.returnInput(item))
                }              
            </DialogContent>
            <DialogActions>
              <Button onClick={this.handleClose} color="primary">
                取消
              </Button>
              <Button onClick={this.postUserLink} color="primary">
              {postType == "add" ? "添加" : "修改"}
              </Button>
            </DialogActions>
          </Dialog>
        ];
    }
}
UsersLinkPost.propTypes = {
    classes: PropTypes.object.isRequired,
};
const UsersLinkPostRender = (props) => {
    return <UsersLinkPost {...props} />
}
export default withStyles(UsersLinkPostStyle)(UsersLinkPostRender);