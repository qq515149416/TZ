import React from "react";
import PropTypes from 'prop-types';
import DialogComponent from "./dialogComponent.jsx";
import Button from '@material-ui/core/Button';
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';
import MoreHorizIcon from '@material-ui/icons/MoreHoriz';
class ExpansionComponent extends React.Component {
    render() {
        const {type} = this.props;
        if(type=="show") {
            return [
                <Tooltip title="查看">
                    <IconButton onClick={() => {this.dialogComponent && this.dialogComponent.handleClickOpen();}} aria-label="Show">
                        <MoreHorizIcon />
                    </IconButton>
                </Tooltip>,
                <DialogComponent 
                    type="show"
                    getRef={ref => this.dialogComponent = ref}
                    data={this.props.data}
                />
            ];
        }
    }
}
ExpansionComponent.propTypes = {
    type: PropTypes.string.isRequired
};
export default ExpansionComponent;