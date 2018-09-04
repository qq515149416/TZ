import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import MenuItem from '@material-ui/core/MenuItem';
import InputLabel from '@material-ui/core/InputLabel';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';
import TextField from '@material-ui/core/TextField';
import InputAdornment from '@material-ui/core/InputAdornment';
import Input from '@material-ui/core/Input';

const styles = theme => ({
  root: {
    display: "flex",
    flexWrap: 'wrap'
  },
  formControl: {
    margin: theme.spacing.unit,
    minWidth: 120,
  },
  dateFormControl: {
    flexDirection: "row"
  },
  decoration: {
    margin: "0 12px",
    marginTop: 14
  },
  search: {
    flexDirection: "row"
  },
  select: {
      "&:before": {
          display: "none"
      }
  }
});

class FilterTableToolbar extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            search: "all"
        };
        const {filterType} = this.props;
        for (let index of filterType) {
            if(index.type=="select") {
                this.state[index.field] = `all_${index.field}`;
            }
        }
        
    }
    handleChange = event => {
        this.setState({ [event.target.name]: event.target.value });
    }
    render() {
        const {classes,filterType} = this.props;
        return (
            <form className={classes.root} autoComplete="off">
                {
                    filterType.map(item => {
                        if(item.type=="select") {
                            return (
                                <FormControl className={classes.formControl}>
                                    <InputLabel htmlFor={item.field}>{item.label}</InputLabel>
                                    <Select
                                        value={this.state[item.field]}
                                        onChange={this.handleChange}
                                        inputProps={{
                                        name: `${item.field}`,
                                        id: `${item.field}`,
                                        }}
                                    >
                                        <MenuItem value={"all_"+item.field}>
                                        <em>全部内容</em>
                                        </MenuItem>
                                        {
                                            item.options.map(e => (
                                                <MenuItem value={e.view}>{e.view}</MenuItem>
                                            ))
                                        }
                                    </Select>
                                </FormControl>
                            );
                        }
                        if(item.type=="date") {
                            return (
                                <FormControl className={`${classes.formControl} ${classes.dateFormControl}`}>
                                    <TextField
                                        id="datetime-local"
                                        label="开始时间"
                                        type="datetime-local"
                                        defaultValue="2018-08-24T17:17"
                                        InputLabelProps={{
                                        shrink: true,
                                        }}
                                    /> <span className={classes.decoration}> 至 </span> <TextField
                                        id="datetime-local"
                                        label="结束时间"
                                        type="datetime-local"
                                        InputLabelProps={{
                                        shrink: true,
                                        }}
                                    /> 
                                </FormControl>
                            );
                        }
                    })
                }
                <FormControl className={`${classes.formControl} ${classes.search}`}>
                    <InputLabel htmlFor="input-with-icon-adornment">搜索</InputLabel>
                    <Input
                    id="search"
                    startAdornment={
                        <InputAdornment position="start">
                            <Select
                                value={this.state.search}
                                onChange={this.handleChange}
                                inputProps={{
                                name: "search",
                                id: "search",
                                }}
                                className={classes.select}
                            >
                                <MenuItem value="all">
                                    <em>全部</em>
                                </MenuItem>
                                <MenuItem value="ex">
                                    特别
                                </MenuItem>
                            </Select>
                        </InputAdornment>
                    }
                    />
                </FormControl>
            </form>
        );
    }
}
FilterTableToolbar.propTypes = {
    classes: PropTypes.object.isRequired,
};
const FilterTableToolbarRender = (props) => {
    return <FilterTableToolbar {...props} />
}
export default withStyles(styles)(FilterTableToolbarRender);