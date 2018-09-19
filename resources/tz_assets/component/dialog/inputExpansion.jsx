import React from "react";
import Button from '@material-ui/core/Button';
import IinkageOption from "../modal/linkageOption.jsx";

class InputExpansion extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            buttonText: "请选择"
        };
    }
    handleOpen = () => {
        this.iinkageOption.handleOpen();
    }
    render() {
        return (
            <div>
                <Button variant="contained" onClick={this.handleOpen} color="primary">
                    {this.state.buttonText}
                </Button>
                <IinkageOption getRef={(ref) => this.iinkageOption = ref} />
            </div>
        );
    }
}
export default InputExpansion;