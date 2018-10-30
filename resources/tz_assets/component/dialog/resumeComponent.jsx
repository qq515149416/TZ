import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';
import Modal from '@material-ui/core/Modal';
import Button from '@material-ui/core/Button';
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';
import CloseIcon from '@material-ui/icons/Close';
import Grid from '@material-ui/core/Grid';

const styles = theme => ({
    paper: {
      position: 'absolute',
      left: '50%',
      transform: 'translateX(-50%)',
      width: window.innerWidth - 100,
      minHeight:  window.innerHeight,
      backgroundColor: theme.palette.background.paper,
      boxShadow: theme.shadows[5],
      padding: theme.spacing.unit * 4,
    },
    close: {
        position: 'absolute',
        right: 5,
        top: 5
    },
    oneLineTitle: {
        marginTop: 20,
        fontSize: 18,
        fontWeight: "bold"
    }
});
/**
 * 显示员工信息的组件
 * @param classes 类对象
 * @param buttonIcon 按钮图标组件对象
 */
class ResumeComponent extends React.Component {
    constructor() {
        super();
        this.state = {
            open: false
        };
    }
    handleClose = () => {
        this.setState({ open: false });
    }
    handleOpen = () => {
        this.setState({ open: true });
    }
    render() {
        const {classes} = this.props;
        return [
            <Tooltip title="更改状态">
                <IconButton onClick={this.handleOpen} aria-label="resume show">
                    {this.props.buttonIcon}
                </IconButton>
            </Tooltip>,
            <Modal
            aria-labelledby="resume"
            aria-describedby="Personal information management"
            open={this.state.open}
            onClose={this.handleClose}
            >
                <div className={classes.paper}>
                    <Tooltip title="关闭">
                        <IconButton className={classes.close} onClick={this.handleClose} aria-label="close">
                            <CloseIcon />
                        </IconButton>
                    </Tooltip>
                    <Typography classes={{
                        root: classes.oneLineTitle
                    }} variant="title" id="resume title">
                        基本信息
                    </Typography>
                    <Grid container spacing={8}>
                        <Grid item xs={4}>

                        </Grid>
                        <Grid item xs={4}>

                        </Grid>
                        <Grid item xs={4}>

                        </Grid>
                    </Grid>
                </div>
            </Modal>
        ];
    }
}
ResumeComponent.propTypes = {
    classes: PropTypes.object.isRequired,
    buttonIcon: PropTypes.oneOfType([
        PropTypes.element,
        PropTypes.arrayOf(PropTypes.element)
    ])
};

export default withStyles(styles)(ResumeComponent);
