import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import IinkageOption from "../modal/linkageOption.jsx";

const styles = theme => ({
    decoration: {
        margin: "0 5px"
    },
});

class InputExpansion extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            machineText: "请选择机器",
            cabinetText: "请选择机柜"
        };
    }
    handleOpen = type => event => {
        console.log(type);
        this.iinkageOption.handleOpen(type);
    }
    setCurrentData = (param,type) => {
        if(type=="machine") {
            param.id = param.machine_num;
            this.props.setComponentParam(param);
            this.setState({
                machineText: param.machine_num
            });
        } else {
            param.id = param.cabinet_id;
            this.props.setComponentParam(param);
            this.setState({
                cabinetText: param.cabinet_id
            });
        }
    }
    render() {
        const {classes} = this.props;
        return (
            <div>
                {
                    this.props.type=="machine" ? (
                        <Button variant="contained" onClick={this.handleOpen("machine")} color="primary">
                            {this.state.machineText}
                        </Button>
                    ) : (
                        <Button variant="contained" onClick={this.handleOpen("cabinet")} color="primary">
                            {this.state.cabinetText}
                        </Button>
                    )
                }
                {/* <span className={ classes.decoration }>/</span> */}
                <IinkageOption setCurrentData={this.setCurrentData} getRef={(ref) => this.iinkageOption = ref} />
            </div>
        );
    }
}

InputExpansion.propTypes = {
    classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(InputExpansion);