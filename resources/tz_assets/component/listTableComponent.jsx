import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TablePagination from '@material-ui/core/TablePagination';
import TableRow from '@material-ui/core/TableRow';
import Checkbox from '@material-ui/core/Checkbox';
import { observer } from "mobx-react";
import PostData from "./listTable/postData.jsx";
import EnhancedTableHead from "./listTable/enhancedTableHead.jsx";
import EnhancedTableToolbar from "./listTable/enhancedTableToolbar.jsx";
import ExpansionComponent from "./expansionComponent.jsx";
import FilterTableToolbar from "./listTable/filterTableToolbar.jsx";

function getSorting(order, orderBy) {
    return order === 'desc'
      ? (a, b) => (b[orderBy] < a[orderBy] ? -1 : 1)
      : (a, b) => (a[orderBy] < b[orderBy] ? -1 : 1);
}
//计算字符串长度包含中文
function getByteLen(val) {
  var len = 0;
  for (var i = 0; i < val.length; i++) {
       var a = val.charAt(i);
       if (a.match(/[^\x00-\xff]/ig) != null) 
      {
          len += 2;
      }
      else
      {
          len += 1;
      }
  }
  return len;
}
const styles = theme => ({
    root: {
      width: '100%',
      marginTop: theme.spacing.unit,
    },
    table: {
      minWidth: 1020,
    },
    tableWrapper: {
      overflowX: 'auto',
    },
    paper: {
      ...theme.mixins.gutters(),
      paddingTop: theme.spacing.unit * 2,
      paddingBottom: theme.spacing.unit * 2
    },
    td: {
      paddingLeft: 0,
      paddingRight: 0,
      textAlign: "center"
    },
    tdLast: {
      textAlign: "center"
    },
    tdFirst: {
      textAlign: "center"
    }
  });
  @observer
  class EnhancedTable extends React.Component {
    constructor(props) {
      super(props);
  
      this.state = {
        order: 'asc',
        orderBy: 'calories',
        selected: [],
        page: 0,
        rowsPerPage: 5
      };
    }
    componentDidMount() {
        // this.props.usersLinkInfoStores.getData();
    }
    getData() {
        return this.props.data;
    }
    handleRequestSort = (event, property) => {
      const orderBy = property;
      let order = 'desc';
  
      if (this.state.orderBy === property && this.state.order === 'desc') {
        order = 'asc';
      }
  
      this.setState({ order, orderBy });
    };
    handleSelectAllEmptyClick = () => {
      this.setState({ selected: [] });
    }
    handleSelectAllClick = (event, checked) => {
      if (checked) {
        this.setState({ selected: this.props.data.map(n => n.id) });
        return;
      }
      this.setState({ selected: [] });
    };
  
    handleClick = (event, id) => {
      const { selected } = this.state;
      const selectedIndex = selected.indexOf(id);
      let newSelected = [];
  
      if (selectedIndex === -1) {
        newSelected = newSelected.concat(selected, id);
      } else if (selectedIndex === 0) {
        newSelected = newSelected.concat(selected.slice(1));
      } else if (selectedIndex === selected.length - 1) {
        newSelected = newSelected.concat(selected.slice(0, -1));
      } else if (selectedIndex > 0) {
        newSelected = newSelected.concat(
          selected.slice(0, selectedIndex),
          selected.slice(selectedIndex + 1),
        );
      }
  
      this.setState({ selected: newSelected });
    };
  
    handleChangePage = (event, page) => {
      this.setState({ page });
    };
  
    handleChangeRowsPerPage = event => {
      this.setState({ rowsPerPage: event.target.value });
    };
  
    isSelected = id => this.state.selected.indexOf(id) !== -1;
  
    render() {
      const { classes } = this.props;
      const {  order, orderBy, selected, rowsPerPage, page } = this.state;
      const emptyRows = rowsPerPage - Math.min(rowsPerPage, this.props.data.length - page * rowsPerPage);
      // console.log(this.props.data);
     
      return [
          <div>
             {
              this.props.filterType && (
                <Paper className={classes.paper} elevation={1}>
                      <FilterTableToolbar filterData={this.props.filterData} types={this.props.headTitlesData} filterType={this.props.filterType} />
                </Paper>
              )
            }
          </div>,
        <Paper className={classes.root}>
          <EnhancedTableToolbar 
            title={(this.props.title || "未定义")} 
            inputType={this.props.inputType} 
            operattext={this.props.operattext} 
            addData={this.props.addData} 
            numSelected={selected.length} 
            getParentData={this.getData.bind(this)} 
            handleSelectAllEmptyClick={this.handleSelectAllEmptyClick} 
            delData={this.props.delData} 
            selectedData={selected} 
          />
          <div className={classes.tableWrapper}>
            <Table className={classes.table} aria-labelledby="tableTitle">
              <EnhancedTableHead
                numSelected={selected.length}
                order={order}
                orderBy={orderBy}
                onSelectAllClick={this.handleSelectAllClick}
                onRequestSort={this.handleRequestSort}
                rowCount={this.props.data.length}
                headTitlesData = {this.props.headTitlesData}
              />
              <TableBody>
                {this.props.data
                  .sort(getSorting(order, orderBy))
                  .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
                  .map(n => {
                    const isSelected = this.isSelected(n.id);
                    return (
                      <TableRow
                        hover
                        onClick={event => this.handleClick(event, n.id)}
                        role="checkbox"
                        aria-checked={isSelected}
                        tabIndex={-1}
                        key={n.id}
                        selected={isSelected}
                      >
                        <TableCell className={classes.tdFirst} padding="checkbox">
                          <Checkbox checked={isSelected} />
                        </TableCell>
                        {
                          this.props.headTitlesData.map((item,index,original) => {
                            if(item.id=="operat") {
                              return null;
                            }
                            // if(index==0&&getByteLen(this.props.data[index][item.id]) > 13) {
                            //   return (
                            //     <TableCell component="th" scope="row" padding="none">
                            //       {item.id.indexOf(".") > -1 ? n[item.id.split(".")[0]][item.id.split(".")[1]] : n[item.id]}
                            //     </TableCell>
                            //   )
                            // } else {
                              return (
                                <TableCell className={classes.td} numeric>{item.id.indexOf(".") > -1 ? n[item.id.split(".")[0]][item.id.split(".")[1]] : n[item.id]}</TableCell>
                              )
                            // }
                          })
                        }
                        {
                          this.props.headTitlesData.find(item => item.id=="operat") ? (
                            <TableCell className={classes.tdLast} numeric>
                              {this.props.changeData && (
                                <PostData operattext={this.props.operattext || this.props.title} inputType={this.props.inputType} postType="edit" editData={n} changeData={this.props.changeData} />
                              )}
                              {
                                (this.props.headTitlesData.find(item => item.id=="operat").extend && this.props.headTitlesData.find(item => item.id=="operat").extendData ) && (
                                  <ExpansionComponent 
                                      type="show"
                                      data={this.props.headTitlesData.find(item => item.id=="operat").extendData.map(item => {
                                        item.content = n[item.id];
                                        return item;
                                      })}
                                    />
                                )
                              }
                            </TableCell>
                          ):null
                        }
                      </TableRow>
                    );
                  })}
                {emptyRows > 0 && (
                  <TableRow style={{ height: 49 * emptyRows }}>
                    <TableCell colSpan={this.props.headTitlesData.length+1} />
                  </TableRow>
                )}
              </TableBody>
            </Table>
          </div>
          <TablePagination
            component="div"
            count={this.props.data.length}
            rowsPerPage={rowsPerPage}
            page={page}
            backIconButtonProps={{
              'aria-label': 'Previous Page',
            }}
            nextIconButtonProps={{
              'aria-label': 'Next Page',
            }}
            onChangePage={this.handleChangePage}
            onChangeRowsPerPage={this.handleChangeRowsPerPage}
            labelRowsPerPage="每页行数："
            labelDisplayedRows={({ from, to, count }) => `${from}到${to}条，一共： ${count}条` }
          />
        </Paper>
      ];
    }
  }
  EnhancedTable.propTypes = {
    classes: PropTypes.object.isRequired,
  };
  const ListTableComponent = (props) => {
    return <EnhancedTable {...props} />
  }
  export default withStyles(styles)(ListTableComponent);