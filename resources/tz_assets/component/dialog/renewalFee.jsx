import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import TextField from '@material-ui/core/TextField';
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';
import RenewalFeeIcon from "../icon/renewalFee.jsx";
import MenuItem from '@material-ui/core/MenuItem';
import ExpansionPanel from '@material-ui/core/ExpansionPanel';
import ExpansionPanelSummary from '@material-ui/core/ExpansionPanelSummary';
import ExpansionPanelDetails from '@material-ui/core/ExpansionPanelDetails';
import Typography from '@material-ui/core/Typography';
import ExpandMoreIcon from '@material-ui/icons/ExpandMore';
import Grid from '@material-ui/core/Grid';
import Paper from '@material-ui/core/Paper';
import { post, get } from "../../tool/http";

const classNames = require('classnames');

const styles = theme => ({
    root: {
        width: 900,
    },
    heading: {
      fontSize: theme.typography.pxToRem(15),
      fontWeight: theme.typography.fontWeightRegular,
    },
    gridRoot: {
        flexGrow: 1
    },
    paper: {
        ...theme.mixins.gutters(),
        paddingTop: theme.spacing.unit,
        paddingBottom: theme.spacing.unit,
        cursor: "pointer",
    },
    paperActive: {
        backgroundColor: theme.palette.secondary[500],
        color: theme.palette.common.white,
    },
    iconButton: {
        ...theme.tableIconButton
    }
});
class RenewalFee extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currency: 1,
            renewalFee: false,
            resources: {
                IP: [],
                bandwidth: [],
                cdn: [],
                cpu: [],
                harddisk: [],
                memory: [],
                protected: [],
            },
            resource: {}
        }
        this.renewalFeeDates = [
            {
                label: "?????????",
                value: 1
            },
            {
                label: "??????",
                value: 6
            },
            {
                label: "??????",
                value: 12
            }
        ];
    }
    show = () => {
        if(!this.props.order_sn) {
            get("business/all_renew",{
                business_sn: this.props.business_number
            }).then(res => {
                if(res.data.code==1) {
                    this.setState({
                        resources: {
                            ...res.data.data
                        }
                    });
                }
            })
        }
    }
    open = () => {
        this.setState({
            renewalFee: true
        });
    }
    close = () => {
        this.setState({
            renewalFee: false
        });
    }
    renewalFeeOperat = () => {
        const { resource } = this.state;
        var confirm_next = confirm("????????????"+this.props[this.props.nameParam]+this.props.type+"?????????"+this.renewalFeeDates.find(item => {
            return item.value == this.state.currency;
        }).label+"?");
        if(confirm_next) {
            this.props.length = this.state.currency;
            this.props.order_note = this.note.value;
            post(this.props.postUrl,{
            //    ...this.props,
                orders: Object.keys(resource).filter(item => resource[item]),
               business_number: this.props.business_sn?this.props.business_sn:this.props.business_number,
               order_sn: this.props.order_sn ? this.props.order_sn : undefined,
               price: this.props.money,
               length: this.props.length,
               order_note: this.props.order_note,
               client_id: this.props.customer_id?this.props.customer_id:this.props.client_id,
               resource_type: this.props.resource_type?this.props.resource_type:this.props.business_type
            }).then((data)=>{
                if(data.data.code==1) {
                    alert("????????????");
                    this.close();
                } else {
                    alert(data.data.msg);
                }
            });
        }
    }
    handleChange = name => event => {
        this.setState({
          [name]: event.target.value,
        });
    }

    handleClick = id => event => {
        this.setState(state => {
            state.resource[id] = !state.resource[id];
            return state;
        });
    }

    render() {
        const { classes } = this.props;
        const { resources, resource } = this.state;
        const resource_types = {
            IP: "IP",
            bandwidth: "??????",
            cdn: "CDN",
            cpu: "CPU",
            harddisk: "??????",
            memory: "??????",
            protected: "??????"
        };
        return [
            <Tooltip title="??????">
                    <IconButton className={classes.iconButton} onClick={this.open} aria-label="renewalFee">
                        <RenewalFeeIcon />
                    </IconButton>
                </Tooltip>,
            <Dialog
          open={this.state.renewalFee}
          onClose={this.close}
          aria-labelledby="form-dialog-title"
          maxWidth="lg"
          onEntered={this.show}
        >
          <DialogTitle id="form-dialog-title">??????</DialogTitle>
          <DialogContent>
            <DialogContentText>
                {
                    this.props.order_sn ? this.props.resource + this.props.resourcetype+"???????????????" : [
                        <p>???????????????{this.props.business_number}</p>,
                        <p>???????????????{this.props.machine_number}</p>,
                        <p>IP???{this.props.resource_detail_json.ip}</p>,
                        <p>?????????{this.props.money}</p>
                    ]
                }
            </DialogContentText>
            <div className={classes.root}>
                {this.props.order_sn ? null : [
                    Object.keys(resource_types).map(byKeyVal => (
                        <ExpansionPanel>
                        <ExpansionPanelSummary expandIcon={<ExpandMoreIcon />}>
                            <Typography className={classes.heading}>{resource_types[byKeyVal]}</Typography>
                        </ExpansionPanelSummary>
                        <ExpansionPanelDetails>
                            <Grid container className={classes.gridRoot} spacing={16}>
                                {
                                    resources[byKeyVal].filter(item => item.order_status!=0).map(item => (
                                        <Grid key={item.id} xs={4} item>
                                            <Paper className={classNames({
                                                [classes.paper]: true,
                                                [classes.paperActive]: resource[item.order_sn]
                                            })} onClick={this.handleClick(item.order_sn)} elevation={1}>
                                                <p>???????????????{item.machine_sn}</p>
                                                <p>?????????{item.price}</p>
                                                <p>?????????{item.resource}</p>
                                            </Paper>
                                        </Grid>
                                    ))
                                }
                            </Grid>
                    </ExpansionPanelDetails>
                    </ExpansionPanel>
                    ))

                ]}


            </div>
            <TextField
            id="renewalFee_duration"
            fullWidth
            select
            label="??????"
            value={this.state.currency}
            onChange={this.handleChange('currency')}
            margin="normal"
            >
                {
                    this.renewalFeeDates.map(item => (
                        <MenuItem key={item.value} value={item.value}>
                            {item.label}
                        </MenuItem>
                    ))
                }

            </TextField>
            <TextField
              margin="dense"
              id="note"
              label="??????"
              fullWidth
              inputRef = {ref => this.note = ref}
            />
          </DialogContent>
          <DialogActions>
            <Button onClick={this.close} color="primary">
              ??????
            </Button>
            <Button onClick={this.renewalFeeOperat} color="primary">
              ??????
            </Button>
          </DialogActions>
        </Dialog>
        ];
    }
}
RenewalFee.propTypes = {
    classes: PropTypes.object.isRequired,
}
export default withStyles(styles)(RenewalFee);
