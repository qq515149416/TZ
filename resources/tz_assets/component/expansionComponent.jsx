import React from "react";
import PropTypes from 'prop-types';
import DialogComponent from "./dialogComponent.jsx";
import Button from '@material-ui/core/Button';
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';
import MoreHorizIcon from '@material-ui/icons/MoreHoriz';
// import BlackMesaIcon from '@material-ui/icons/BlackMesa';
import ImageFilterBlackWhite from "./icon/ImageFilterBlackWhite.jsx";
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import AddIcon from '@material-ui/icons/Add';
import TextField from '@material-ui/core/TextField';
class ExpansionComponent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            confirm: false
        };
    }
    confirm_run = () => {
        if(this.props.ok) {
            this.props.data.note = this.note.value;
            this.props.ok(this.props.data).then((data) => {
                if(data.code==1) {
                    this.props.updata && this.props.updata();
                    this.setState({
                        confirm: false
                    });
                }
            });
        }
    }
    confirm_hide = type => event => {
        if(type=="cancel" && this.props.cancel) {
            this.props.data.note = this.note.value;
            this.props.cancel(this.props.data).then((data) => {
                if(data.code==1) {
                    this.props.updata && this.props.updata();
                    this.setState({
                        confirm: false
                    });
                }
            });
        } else {
            this.setState({
                confirm: false
            });
        }
    }
    confirm_show = () => {
        this.setState({
            confirm: true
        });
    }
    toLink = url => event => {
        // console.log(url,event);
        location.href =  url;
    }
    render() {
        const {type} = this.props;
        if(type=="link") {
            return (
                <Tooltip title={this.props.title}>
                    <IconButton onClick={this.toLink(this.props.link)} aria-label="Link">
                        <AddIcon />
                    </IconButton>
                </Tooltip>
            );
        }
        if(type=="show") {
            return [
                <Tooltip title="查看">
                    <IconButton onClick={() => {this.dialogComponent && this.dialogComponent.handleClickOpen();}} aria-label="Show">
                        <MoreHorizIcon />
                    </IconButton>
                </Tooltip>,
                <DialogComponent 
                    type="show"
                    getRef={ref => this.dialogComponent = ref}
                    data={this.props.data}
                />
            ];
        }
        if(type=="confirm") {
            return [
                <Tooltip title={this.props.tip_title}>
                    <IconButton onClick={this.confirm_show} aria-label="startFunction">
                        <ImageFilterBlackWhite />
                    </IconButton>
                </Tooltip>,
                <Dialog
                open={this.state.confirm}
                onClose={this.confirm_hide("hide")}
                aria-labelledby="alert-dialog-title"
                aria-describedby="alert-dialog-description"
              >
                <DialogTitle id="alert-dialog-title">{this.props.tip_title}</DialogTitle>
                <DialogContent>
                  <DialogContentText id="alert-dialog-description">
                    {this.props.tip_content}
                  </DialogContentText>
                  {
                      this.props.input && (
                        <DialogContentText id="alert-dialog-input">
                            <TextField
                                id="note"
                                label="备注"
                                margin="normal"
                                inputRef={ref => this.note = ref}
                            />
                        </DialogContentText>
                      )
                  }
                </DialogContent>
                <DialogActions>
                  <Button onClick={this.confirm_hide("cancel")} color="primary" autoFocus>
                    取消
                  </Button>
                  <Button onClick={this.confirm_run} color="primary">
                    确定
                  </Button>
                </DialogActions>
              </Dialog>

            ];
        }
    }
}
ExpansionComponent.propTypes = {
    type: PropTypes.string.isRequired
};
export default ExpansionComponent;