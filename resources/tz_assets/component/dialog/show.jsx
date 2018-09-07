import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
const ShowStyle = theme => ({
    title_container: {
        overflow: "hidden",
        marginBottom: theme.spacing.unit
    },
    title_type: {
        fontWeight: "bold",
        float: "left"
    },
    title_content: {
        float: "left"
    }
});
class Show extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open: false
        };
    }
    componentDidMount() {
        this.props.getRef(this);
    }
    handleClickOpen = () => {
        this.setState({ open: true });
    };

    handleClose = () => {
        this.setState({ open: false });
    };
    render() {
        const {classes} = this.props;
        return (
            <Dialog
            open={this.state.open}
            onClose={this.handleClose}
            aria-labelledby="alert-dialog-title"
            aria-describedby="alert-dialog-description"
            >
            <DialogTitle id="alert-dialog-title">查看更多</DialogTitle>
            <DialogContent>
                {
                    this.props.data.map(item => {
                        if(item.type=="text") {
                            return (
                                <DialogContentText className={classes.title_container}>
                                    <span className={classes.title_type}>{item.label}：</span>
                                    <p className={classes.title_content}>
                                        {item.content}
                                    </p>
                                </DialogContentText>
                            );
                        }else if(item.type=="content") {
                            return (
                                <DialogContentText className={classes.title_container}>
                                    <span className={classes.title_type}>{item.label}：</span>
                                    <div className={classes.title_content} dangerouslySetInnerHTML = {{ __html: item.content}}>
                                    </div>
                                </DialogContentText>
                            );
                        }
                    })
                }
            </DialogContent>
            <DialogActions>
                <Button onClick={this.handleClose} color="primary">
                    确定
                </Button>
            </DialogActions>
            </Dialog>
        )
    }
}
Show.propTypes = {
    classes: PropTypes.object.isRequired,
};
const ShowRender = (props) => {
    return <Show {...props} />
}
export default withStyles(ShowStyle)(ShowRender);