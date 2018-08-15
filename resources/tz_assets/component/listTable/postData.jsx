import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';
import EditIcon from '@material-ui/icons/Edit';
// import DialogContentText from '@material-ui/core/DialogContentText';
import DialogComponent from "../dialogComponent.jsx";
const PostDataStyle = theme => ({
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
class PostData extends React.Component {
    constructor(props) {
        super(props);
    }
    decompressionParam = () => {
        let returnObj = {};
        this.props.inputType.forEach(item => {
            if(this.dialogComponent[item.field]) {
                returnObj[item.field] = this.dialogComponent[item.field].value;
            } else {
                console.warn(this.dialogComponent[item.field],item.field);
            }
            
        });
        return returnObj
    }
    post() {
        if(this.props.postType == "add") {
            this.props.addData(this.decompressionParam(),(data,result) => {
                if(data) {
                    this.dialogComponent.handleClose();
                }
                
            });
        }
        if(this.props.postType == "edit") {
            this.props.changeData(Object.assign(this.decompressionParam(),{
                id: this.props.editData.id
            }),(data,result) => {
                if(data) {
                    this.dialogComponent.handleClose();
                }
            });
        }
    }
    render() {
        const {classes, postType} = this.props;
        return [
            <span>
              {
                postType == "add" ? (
                <Button variant="contained" onClick={() => {console.log(this.dialogComponent);this.dialogComponent && this.dialogComponent.handleClickOpen();}} color="primary" className={classes.button}>
                    添加{this.props.operattext}
                </Button>
                ) : (
                    <Tooltip title="编辑">
                        <IconButton onClick={() => {this.dialogComponent && this.dialogComponent.handleClickOpen();}} aria-label="Edit">
                            <EditIcon />
                        </IconButton>
                    </Tooltip>
                )
              }
            </span>,
            <DialogComponent 
                operattext={postType == "add" ? "添加" : "修改"}
                title={postType == "add" ? "添加"+this.props.operattext : "修改"+this.props.operattext}
                post={this.post.bind(this)}
                inputType={this.props.inputType}
                getRef={ref => this.dialogComponent = ref}
                editData={postType == "add" ? null:this.props.editData}
                type="input"
            />
        ];
    }
}
PostData.propTypes = {
    classes: PropTypes.object.isRequired,
};
const PostDataRender = (props) => {
    return <PostData {...props} />
}
export default withStyles(PostDataStyle)(PostDataRender);