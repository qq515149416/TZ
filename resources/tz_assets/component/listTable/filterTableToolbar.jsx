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
  },
  button: {
    margin: `0 ${theme.spacing.unit}px`,
    height: 30,
    position: "relative",
    top: theme.spacing.unit * 2
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
                this.state[index.field] = "all";
            }
        }

    }
    handleChange = event => {
        this.setState({ [event.target.name]: event.target.value });
    }
    findData = event => {
        let searchRule = {};
        let startTime = new Date(this.startTime.value);
        let endTime = new Date(this.endTime.value);
        const {filterType} = this.props;
        for (let index of filterType) {
            if(index.type=="select") {
                searchRule[index.field] = this.state[index.field];
            } else if(index.type=="date") {
                searchRule["timeAttrName"] = index.field;
            }
        }
        if(this.search.value) {
            searchRule["searchType"] = this.state.search;
            searchRule["searchContent"] = this.search.value;
        }
        searchRule["startTime"] = Math.round(startTime.getTime()/1000);
        searchRule["endTime"] = Math.round(endTime.getTime()/1000);
        // console.log(searchRule);
        this.props.filterData(searchRule);
    }
    render() {
        const {classes,filterType,types} = this.props;
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
                                        <MenuItem value={"all"}>
                                        <b>????????????</b>
                                        </MenuItem>
                                        {
                                            item.options.map(e => {
                                                if(e.id) {
                                                    return (
                                                        <MenuItem value={e.id}>{e.view}</MenuItem>
                                                    );
                                                } else {
                                                    return (
                                                        <MenuItem value={e.view}>{e.view}</MenuItem>
                                                    );
                                                }
                                            })
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
                                        label="????????????"
                                        type="datetime-local"
                                        defaultValue="2018-08-24T17:17"
                                        InputLabelProps={{
                                        shrink: true,
                                        }}
                                        inputRef={(ref) => this.startTime = ref}
                                    /> <span className={classes.decoration}> ??? </span> <TextField
                                        id="datetime-local"
                                        label="????????????"
                                        type="datetime-local"
                                        inputRef={(ref) => this.endTime = ref}
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
                    <InputLabel htmlFor="input-with-icon-adornment">??????</InputLabel>
                    <Input
                    id="search"
                    inputRef={(ref) => this.search = ref}
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
                                    <em>??????</em>
                                </MenuItem>
                                {
                                    types.map(item => {
                                        if(item.id!="operat") {
                                            return (
                                                <MenuItem value={item.id}>
                                                    {item.label}
                                                </MenuItem>
                                            );
                                        }
                                    })
                                }

                            </Select>
                        </InputAdornment>
                    }
                    />
                </FormControl>
                <Button variant="contained" onClick={this.findData} color="primary" className={classes.button}>
                    ??????
                </Button>
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
