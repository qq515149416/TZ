import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
// import ListItemText from '@material-ui/core/ListItemText';
// import ListItem from '@material-ui/core/ListItem';
// import List from '@material-ui/core/List';
// import Divider from '@material-ui/core/Divider';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import IconButton from '@material-ui/core/IconButton';
import Typography from '@material-ui/core/Typography';
import CommunicationIcon from "../icon/communication.jsx";
import CloseIcon from '@material-ui/icons/Close';
import Slide from '@material-ui/core/Slide';
import Tooltip from '@material-ui/core/Tooltip';
import ChangeStatus from "./changeStatus.jsx";
import TextField from '@material-ui/core/TextField';
import { get,post } from '../../tool/http';
import io from 'socket.io-client';
const classNames = require('classnames');
const socket = io("http://"+location.hostname+":8120");

const styles = {
    appBar: {
      position: 'relative',
    },
    flex: {
      flex: 1,
    },
    content_container: {
        height: 550,
        overflow: "auto"
    },
    textField: {
        margin: 0,
        padding: 5,
        paddingBottom: 0
    },
    send: {
        textAlign: "right"
    },
    sendButton: {
        marginTop: 5
    },
    conversation_content_item: {
        margin: "5px 0"
    },
    block: {
        display: "block"
    },
    content: {
        marginLeft: 20
    },
    self: {
        color: "blue"
    },
    allochromatic: {
        color: "green"
    },
    date: {
        marginLeft: 10
    }
  };

  function Transition(props) {
    return <Slide direction="up" {...props} />;
  }

  class Communication extends React.Component {
    state = {
      open: false,
      contents: []
    };
    componentDidMount() {
        get("work_answer/show",{
            work_number: this.props.work_order_number
        }).then(res => {
            if(res.data.code == 1) {
                this.setState({
                    contents: res.data.data.content
                });
                // socket.on("connect",() => {

                // });
                let {business} = res.data.data;
                socket.on(`work_num:${business.work_order_number}`,content=>{
                    this.setState(state=>{
                        state.contents.push(content);
                        return state;
                    });
                });
            }
        })
    }

    sendContent = event => {
        post("work_answer/insert",{
            work_number: this.props.work_order_number,
            answer_content: this.send_content.value
        }).then(res => {
            if(res.data.code==1) {
                this.send_content.value = "";
                // socket.emit(`to_id:${this.props.customer_id}work_num:${this.props.work_order_number}`,res.data.data);
                socket.emit("admin_to_client",Object.assign(res.data.data,{
                    to_id: this.props.customer_id
                }));
                this.setState(state => {
                    state.contents.push(res.data.data);
                    return state;
                });
            }
        })
    }

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
          <div className={classes.content_container}>
            {
                this.state.contents.map(item => (
                    <div className={`${classes.conversation_content_item}`}>
                        <span className={`${classes.block} ${classNames({
                            [classes.self]: item.answer_role==2,
                            [classes.allochromatic]: item.answer_role==1
                        })} ${classes.date}`}>{item.created_at}</span>
                        <span className={`${classes.block} ${classes.content}`}>{item.answer_content}</span>
                    </div>
                ))
            }

          </div>
          <TextField
                id="content"
            // label="Multiline"
                multiline
                rows="4"
                className={classes.textField}
                margin="normal"
                fullWidth
                placeholder="请填写要回复的内容"
                inputRef={ref => this.send_content = ref}
            />
            <div className={classes.send}>
                <Button variant="contained" onClick={this.sendContent} className={classes.sendButton} color="primary">
                    回复
                </Button>
            </div>
        </Dialog>
      ];
    }
  }

  Communication.propTypes = {
    classes: PropTypes.object.isRequired,
  };

  export default withStyles(styles)(Communication);