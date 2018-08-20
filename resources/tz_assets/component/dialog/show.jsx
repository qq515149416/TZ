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
        return (
            <Dialog
            open={this.state.open}
            onClose={this.handleClose}
            aria-labelledby="alert-dialog-title"
            aria-describedby="alert-dialog-description"
            >
            <DialogTitle id="alert-dialog-title">{this.props.title}</DialogTitle>
            <DialogContent>
                <DialogContentText id="alert-dialog-description">
                    {this.props.description}
                </DialogContentText>
                <DialogContentText id="alert-dialog-content" dangerouslySetInnerHTML = {{ __html:this.props.content }}>
                </DialogContentText>
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