import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import TextField from '@material-ui/core/TextField';
import Button from '@material-ui/core/Button';

const styles = theme => ({
    button: {
      margin: `0 ${theme.spacing.unit}px`
    }
  });

class CustomizeTableToolbar extends React.Component {
    search = date => event => {
        this.props.getData({
            month: date.value.split("-")[0]+date.value.split("-")[1]
        });
    } 
    reset = event => {
        this.props.getData();
    }
    render() {
        const {classes} = this.props;
        return [
            <TextField
                id="date"
                label="时间"
                type="date"
                defaultValue="2018-10-10"
                InputLabelProps={{
                    shrink: true,
                }}
                inputRef={ref => this.dateTime = ref}
            />,
            <Button className={classes.button} variant="contained" onClick={this.search(this.dateTime)} color="primary">
                搜索
            </Button>,
            <Button className={classes.button} variant="contained" onClick={this.reset} color="primary">
                重置
            </Button>
        ];
    }
}
CustomizeTableToolbar.propTypes = {
    classes: PropTypes.object.isRequired,
};
export default withStyles(styles)(CustomizeTableToolbar);