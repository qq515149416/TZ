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
    }
});
class UsersLinkPost extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open: false,
            inputAttr: {
                contactname: {
                    error: false,
                    label: "姓名",
                    defaultValue: this.props.editData ? this.props.editData.contactname : ""
                },
                qq: {
                    error: false,
                    label: "QQ",
                    defaultValue: this.props.editData ? this.props.editData.qq : ""
                },
                mobile: {
                    error: false,
                    label: "手机",
                    defaultValue: this.props.editData ? this.props.editData.mobile : ""
                },
                email: {
                    error: false,
                    label: "邮箱",
                    defaultValue: this.props.editData ? this.props.editData.email : ""
                },
                rank: {
                    error: false,
                    label: "权重",
                    defaultValue: this.props.editData ? this.props.editData.rank : ""
                },
                site: {
                    currency: this.props.editData ? this.siteCode(this.props.editData.site) : 1,
                    label: "显示位置"
                }
            }
        };
    }
    siteCode = (data) => {
        switch(data) {
            case "左侧":
                return 1;
            case "联系人页面":
                return 2;
            case "两侧均显示":
                return 3;
        }
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
            this.props.addData({
                contactname: this.contactname.value,
                qq: this.qq.value,
                mobile: this.mobile.value,
                email: this.email.value,
                rank: this.rank.value,
                site: this.state.inputAttr.site.currency
            },(data) => {
                if(data) {
                    this.setState({ open: false });
                } else {
                    alert("添加失败");
                }
                
            });
        }
        if(this.props.postType == "edit") {
            this.props.changeData({
                id: this.props.editData.id,
                contactname: this.contactname.value,
                qq: this.qq.value,
                mobile: this.mobile.value,
                email: this.email.value,
                rank: this.rank.value,
                site: this.state.inputAttr.site.currency
            },(data) => {
                if(data) {
                    this.setState({ open: false });
                }
            });
        }
    }
    handleChange = name => event => {
        this.setState(state => state.inputAttr.site[name] = event.target.value);
    };
    render() {
        const {classes, postType} = this.props;
        const {inputAttr} = this.state;
        return [
            <span>
              {
                postType == "add" ? (
                <Button variant="contained" onClick={this.handleClickOpen} color="primary" className={classes.button}>
                    添加联系方式
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
            <DialogTitle id="form-dialog-title">{postType == "add" ? "添加" : "修改"}员工联系方式</DialogTitle>
            <DialogContent>
              <TextField
                error={inputAttr.contactname.error}
                margin="dense"
                id="contactname"
                label={inputAttr.contactname.label}
                type="text"
                fullWidth
                className={classes.textField}
                defaultValue={inputAttr.contactname.defaultValue}
                inputRef = {(ref) => this.contactname = ref}
              />
              <TextField
                error={inputAttr.qq.error}
                margin="dense"
                id="qq"
                label={inputAttr.qq.label}
                type="text"
                fullWidth
                className={classes.textField}
                defaultValue={inputAttr.qq.defaultValue}
                inputRef = {(ref) => this.qq = ref}
              />
              <TextField
                error={inputAttr.mobile.error}
                margin="dense"
                id="mobile"
                label={inputAttr.mobile.label}
                type="text"
                fullWidth
                className={classes.textField}
                defaultValue={inputAttr.mobile.defaultValue}
                inputRef = {(ref) => this.mobile = ref}
              />
              <TextField
                error={inputAttr.email.error}
                margin="dense"
                id="email"
                label={inputAttr.email.label}
                type="text"
                fullWidth
                className={classes.textField}
                defaultValue={inputAttr.email.defaultValue}
                inputRef = {(ref) => this.email = ref}
              />
              <TextField
                error={inputAttr.rank.error}
                margin="dense"
                id="rank"
                label={inputAttr.rank.label}
                type="text"
                fullWidth
                className={classes.textField}
                defaultValue={inputAttr.rank.defaultValue}
                inputRef = {(ref) => this.rank = ref}
              />
                <TextField
                    id="site"
                    select
                    label={inputAttr.site.label}
                    className={classes.textField}
                    value={inputAttr.site.currency}
                    onChange={this.handleChange('currency')}
                    SelectProps={{
                        MenuProps: {
                            className: classes.menu
                        },
                    }}
                    margin="normal"
                >
                    <MenuItem value={1}>
                        左侧
                    </MenuItem>
                    <MenuItem value={2}>
                        联系人页面
                    </MenuItem>
                    <MenuItem value={3}>
                        两侧均显示
                    </MenuItem>
                </TextField>
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