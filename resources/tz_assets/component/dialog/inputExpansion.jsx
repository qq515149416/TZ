import React from "react";
import Button from '@material-ui/core/Button';
import IinkageOption from "../modal/linkageOption.jsx";

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
            this.setState({
                machineText: param.machine_num
            });
        } else {
            this.setState({
                cabinetText: param.cabinet_id
            });
        }
    }
    render() {
        return (
            <div>
                <Button variant="contained" onClick={this.handleOpen("machine")} color="primary">
                    {this.state.machineText}
                </Button>
                <Button variant="contained" onClick={this.handleOpen("cabinet")} color="primary">
                    {this.state.cabinetText}
                </Button>
                <IinkageOption setCurrentData={this.setCurrentData} getRef={(ref) => this.iinkageOption = ref} />
            </div>
        );
    }
}
export default InputExpansion;