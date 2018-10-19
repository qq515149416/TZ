import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import ListItemText from '@material-ui/core/ListItemText';
import ListItem from '@material-ui/core/ListItem';
import List from '@material-ui/core/List';
import Divider from '@material-ui/core/Divider';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import IconButton from '@material-ui/core/IconButton';
import Typography from '@material-ui/core/Typography';
import CommunicationIcon from "../icon/communication.jsx";
import CloseIcon from '@material-ui/icons/Close';
import Slide from '@material-ui/core/Slide';
import Tooltip from '@material-ui/core/Tooltip';
import ChangeStatus from "./changeStatus.jsx";

const styles = {
    appBar: {
      position: 'relative',
    },
    flex: {
      flex: 1,
    },
  };
  
  function Transition(props) {
    return <Slide direction="up" {...props} />;
  }
  
  class Communication extends React.Component {
    state = {
      open: false,
    };
  
    handleClickOpen = () => {
      this.setState({ open: true });
    };
  
    handleClose = () => {
      this.setState({ open: false });
    };
  
    render() {
      const { classes } = this.props;
      return [
        <Tooltip title="问题沟通">
            <IconButton onClick={this.handleClickOpen} aria-label="communication">
                <CommunicationIcon />
            </IconButton>
        </Tooltip>,
        <Dialog
          fullScreen
          open={this.state.open}
          onClose={this.handleClose}
          TransitionComponent={Transition}
        >
          <AppBar className={classes.appBar}>
            <Toolbar>
              <IconButton color="inherit" onClick={this.handleClose} aria-label="Close">
                <CloseIcon />
              </IconButton>
              <Typography variant="h6" color="inherit" className={classes.flex}>
            由{this.props.submitter_name}发起{this.props.machine_number}主机的{this.props.worktype}问题
              </Typography>
              <ChangeStatus {...this.props} postUrl="workorder/edit" nameParam="work_order_number" />
            </Toolbar>
          </AppBar>
          <List>
            <ListItem button>
              <ListItemText primary="Phone ringtone" secondary="Titania" />
            </ListItem>
            <Divider />
            <ListItem button>
              <ListItemText primary="Default notification ringtone" secondary="Tethys" />
            </ListItem>
          </List>
        </Dialog>
      ];
    }
  }
  
  Communication.propTypes = {
    classes: PropTypes.object.isRequired,
  };
  
  export default withStyles(styles)(Communication);