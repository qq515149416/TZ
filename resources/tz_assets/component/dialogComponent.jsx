import React from "react";
import PropTypes from 'prop-types';
import AllInput from "./dialog/allInput.jsx";
class DialogComponent extends React.Component {
    render() {
        const {type,state,title,operattext,post,inputType,getRef} = this.props;
        if(type=="input") {
            return (
                <AllInput 
                    title={title}
                    operattext={operattext}
                    open={state}
                    post={post}
                    inputType={inputType}
                    getRef={ref => getRef(ref)}
                    editData={this.props.editData || null}
                />
            );
        }
    }
}
DialogComponent.propTypes = {
    type: PropTypes.string.isRequired,
    state: PropTypes.bool.isRequired
};
export default DialogComponent;