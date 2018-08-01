import React from "react";
import classNames from 'classnames';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TablePagination from '@material-ui/core/TablePagination';
import TableRow from '@material-ui/core/TableRow';
import TableSortLabel from '@material-ui/core/TableSortLabel';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import Paper from '@material-ui/core/Paper';
import Checkbox from '@material-ui/core/Checkbox';
import IconButton from '@material-ui/core/IconButton';
import Tooltip from '@material-ui/core/Tooltip';
import DeleteIcon from '@material-ui/icons/Delete';
import FilterListIcon from '@material-ui/icons/FilterList';
import { lighten } from '@material-ui/core/styles/colorManipulator';
import { inject,observer } from "mobx-react";
// 添加数据
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
// import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import MenuItem from '@material-ui/core/MenuItem';

function getSorting(order, orderBy) {
    return order === 'desc'
      ? (a, b) => (b[orderBy] < a[orderBy] ? -1 : 1)
      : (a, b) => (a[orderBy] < b[orderBy] ? -1 : 1);
  }
  
const columnData = [
    { id: 'contactname', numeric: false, disablePadding: true, label: '姓名' },
    { id: 'qq', numeric: true, disablePadding: false, label: 'QQ' },
    { id: 'mobile', numeric: true, disablePadding: false, label: '手机' },
    { id: 'email', numeric: true, disablePadding: false, label: '邮箱' },
    { id: 'rank', numeric: true, disablePadding: false, label: '权重' },
    { id: 'site', numeric: true, disablePadding: false, label: '显示位置' },
    { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
    { id: 'updated_at', numeric: true, disablePadding: false, label: '更新时间' }
];
class EnhancedTableHead extends React.Component {
    createSortHandler = property => event => {
      this.props.onRequestSort(event, property);
    };
  
    render() {
      const { onSelectAllClick, order, orderBy, numSelected, rowCount } = this.props;
  
      return (
        <TableHead>
          <TableRow>
            <TableCell padding="checkbox">
              <Checkbox
                indeterminate={numSelected > 0 && numSelected < rowCount}
                checked={numSelected === rowCount}
                onChange={onSelectAllClick}
              />
            </TableCell>
            {columnData.map(column => {
              return (
                <TableCell
                  key={column.id}
                  numeric={column.numeric}
                  padding={column.disablePadding ? 'none' : 'default'}
                  sortDirection={orderBy === column.id ? order : false}
                >
                  <Tooltip
                    title="Sort"
                    placement={column.numeric ? 'bottom-end' : 'bottom-start'}
                    enterDelay={300}
                  >
                    <TableSortLabel
                      active={orderBy === column.id}
                      direction={order}
                      onClick={this.createSortHandler(column.id)}
                    >
                      {column.label}
                    </TableSortLabel>
                  </Tooltip>
                </TableCell>
              );
            }, this)}
          </TableRow>
        </TableHead>
      );
    }
  }
  EnhancedTableHead.propTypes = {
    numSelected: PropTypes.number.isRequired,
    onRequestSort: PropTypes.func.isRequired,
    onSelectAllClick: PropTypes.func.isRequired,
    order: PropTypes.string.isRequired,
    orderBy: PropTypes.string.isRequired,
    rowCount: PropTypes.number.isRequired,
  };
  
  const toolbarStyles = theme => ({
    root: {
      paddingRight: theme.spacing.unit,
    },
    highlight:
      theme.palette.type === 'light'
        ? {
            color: theme.palette.secondary.main,
            backgroundColor: lighten(theme.palette.secondary.light, 0.85),
          }
        : {
            color: theme.palette.text.primary,
            backgroundColor: theme.palette.secondary.dark,
          },
    spacer: {
      flex: '1 1 100%',
    },
    actions: {
      color: theme.palette.text.secondary,
    },
    title: {
      flex: '0 0 auto',
    },
  });
  
  let EnhancedTableToolbar = props => {
    const { numSelected, classes } = props;
  
    return (
      <Toolbar
        className={classNames(classes.root, {
          [classes.highlight]: numSelected > 0,
        })}
      >
        <div className={classes.title}>
          {numSelected > 0 ? (
            <Typography color="inherit" variant="subheading">
              {numSelected} 选中
            </Typography>
          ) : (
            <Typography variant="title" id="tableTitle">
              用户通讯录
            </Typography>
          )}
        </div>
        <div className={classes.spacer} />
        <div className={classes.actions}>
          {numSelected > 0 ? (
            <Tooltip title="Delete">
              <IconButton aria-label="Delete">
                <DeleteIcon />
              </IconButton>
            </Tooltip>
          ) : (
            <Tooltip title="Filter list">
              <IconButton aria-label="Filter list">
                <FilterListIcon />
              </IconButton>
            </Tooltip>
          )}
        </div>
      </Toolbar>
    );
  };
  
  EnhancedTableToolbar.propTypes = {
    classes: PropTypes.object.isRequired,
    numSelected: PropTypes.number.isRequired,
  };
  
  EnhancedTableToolbar = withStyles(toolbarStyles)(EnhancedTableToolbar);
  

    const UsersLinkAddStyle = theme => ({
        button: {
            margin: theme.spacing.unit
        },
        textField: {
            width: theme.breakpoints.values.sm
        },
        menu: {
            width: theme.breakpoints.values.sm / 2,
        },
        dialog: {
            maxWidth: theme.breakpoints.values.sm + 50
        }
    });
    class UsersLinkAdd extends React.Component {
        constructor(props) {
            super(props);
            this.state = {
                open: false,
                inputAttr: {
                    contactname: {
                        error: false,
                        label: "姓名"
                    },
                    qq: {
                        error: false,
                        label: "QQ"
                    },
                    mobile: {
                        error: false,
                        label: "手机"
                    },
                    email: {
                        error: false,
                        label: "邮箱"
                    },
                    rank: {
                        error: false,
                        label: "权重"
                    },
                    site: {
                        currency: 1,
                        label: "显示位置"
                    }
                }
            };
        }
        handleClickOpen = () => {
            this.setState({ open: true });
        };
        
        handleClose = () => {
            this.setState({ open: false });
        };
        addPostUserLink = () => {
            // console.log(this.contactname.value);
            this.props.usersLinkInfoStores.addData({
                contactname: this.contactname.value,
                qq: this.qq.value,
                mobile: this.mobile.value,
                email: this.email.value,
                rank: this.rank.value,
                site: this.state.inputAttr.site.currency
            }).then((state) => {
                if(state) {
                    this.setState({ open: false });
                }
            });
        }
        handleChange = name => event => {
            this.setState(state => state.inputAttr.site[name] = event.target.value);
        };
        render() {
            const {classes} = this.props;
            const {inputAttr} = this.state;
            return [
                <Button variant="contained" onClick={this.handleClickOpen} color="primary" className={classes.button}>
                    添加联系方式
                </Button>,
                <Dialog
                open={this.state.open}
                onClose={this.handleClose}
                aria-labelledby="form-dialog-title"
                maxWidth="sm"
                PaperProps={{
                    className: classes.dialog
                }}
              >
                <DialogTitle id="form-dialog-title">添加员工联系方式</DialogTitle>
                <DialogContent>
                  <TextField
                    error={inputAttr.contactname.error}
                    margin="dense"
                    id="contactname"
                    label={inputAttr.contactname.label}
                    type="text"
                    fullWidth
                    className={classes.textField}
                    inputRef = {(ref) => this.contactname = ref}
                  />
                  <TextField
                    error={inputAttr.qq.error}
                    margin="dense"
                    id="qq"
                    label={inputAttr.qq.label}
                    type="text"
                    fullWidth
                    className={classes.textField}
                    inputRef = {(ref) => this.qq = ref}
                  />
                  <TextField
                    error={inputAttr.mobile.error}
                    margin="dense"
                    id="mobile"
                    label={inputAttr.mobile.label}
                    type="text"
                    fullWidth
                    className={classes.textField}
                    inputRef = {(ref) => this.mobile = ref}
                  />
                  <TextField
                    error={inputAttr.email.error}
                    margin="dense"
                    id="email"
                    label={inputAttr.email.label}
                    type="text"
                    fullWidth
                    className={classes.textField}
                    inputRef = {(ref) => this.email = ref}
                  />
                  <TextField
                    error={inputAttr.rank.error}
                    margin="dense"
                    id="rank"
                    label={inputAttr.rank.label}
                    type="text"
                    fullWidth
                    className={classes.textField}
                    inputRef = {(ref) => this.rank = ref}
                  />
                    <TextField
                        id="site"
                        select
                        label={inputAttr.site.label}
                        className={classes.textField}
                        value={inputAttr.site.currency}
                        onChange={this.handleChange('currency')}
                        SelectProps={{
                            MenuProps: {
                                className: classes.menu
                            },
                        }}
                        margin="normal"
                    >
                        <MenuItem value={1}>
                            左侧
                        </MenuItem>
                        <MenuItem value={2}>
                            联系人页面
                        </MenuItem>
                        <MenuItem value={3}>
                            两侧均显示
                        </MenuItem>
                    </TextField>
                </DialogContent>
                <DialogActions>
                  <Button onClick={this.handleClose} color="primary">
                    取消
                  </Button>
                  <Button onClick={this.addPostUserLink} color="primary">
                    添加
                  </Button>
                </DialogActions>
              </Dialog>
            ];
        }
    }
    UsersLinkAdd.propTypes = {
        classes: PropTypes.object.isRequired,
    };
    UsersLinkAdd = withStyles(UsersLinkAddStyle)(UsersLinkAdd);

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
  });
@inject("usersLinkInfoStores")
@observer 
  class EnhancedTable extends React.Component {
    constructor(props) {
      super(props);
  
      this.state = {
        order: 'asc',
        orderBy: 'calories',
        selected: [],
        page: 0,
        rowsPerPage: 5,
      };
    }
    componentDidMount() {
        this.props.usersLinkInfoStores.getData();
    }
    handleRequestSort = (event, property) => {
      const orderBy = property;
      let order = 'desc';
  
      if (this.state.orderBy === property && this.state.order === 'desc') {
        order = 'asc';
      }
  
      this.setState({ order, orderBy });
    };
  
    handleSelectAllClick = (event, checked) => {
      if (checked) {
        this.setState({ selected: this.props.usersLinkInfoStores.user.map(n => n.id) });
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
      const emptyRows = rowsPerPage - Math.min(rowsPerPage, this.props.usersLinkInfoStores.user.length - page * rowsPerPage);
  
      return [
          <UsersLinkAdd usersLinkInfoStores={this.props.usersLinkInfoStores} />,
        <Paper className={classes.root}>
          <EnhancedTableToolbar numSelected={selected.length} />
          <div className={classes.tableWrapper}>
            <Table className={classes.table} aria-labelledby="tableTitle">
              <EnhancedTableHead
                numSelected={selected.length}
                order={order}
                orderBy={orderBy}
                onSelectAllClick={this.handleSelectAllClick}
                onRequestSort={this.handleRequestSort}
                rowCount={this.props.usersLinkInfoStores.user.length}
              />
              <TableBody>
                {this.props.usersLinkInfoStores.user
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
                        <TableCell padding="checkbox">
                          <Checkbox checked={isSelected} />
                        </TableCell>
                        <TableCell component="th" scope="row" padding="none">
                          {n.contactname}
                        </TableCell>
                        <TableCell numeric>{n.qq}</TableCell>
                        <TableCell numeric>{n.mobile}</TableCell>
                        <TableCell numeric>{n.email}</TableCell>
                        <TableCell numeric>{n.rank}</TableCell>
                        <TableCell numeric>{n.site}</TableCell>
                        <TableCell numeric>{n.created_at}</TableCell>
                        <TableCell numeric>{n.updated_at}</TableCell>

                      </TableRow>
                    );
                  })}
                {emptyRows > 0 && (
                  <TableRow style={{ height: 49 * emptyRows }}>
                    <TableCell colSpan={9} />
                  </TableRow>
                )}
              </TableBody>
            </Table>
          </div>
          <TablePagination
            component="div"
            count={this.props.usersLinkInfoStores.user.length}
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
            labelDisplayedRows={({ from, to, count }) => `${from}到${to}条，一共： ${count}页` }
          />
        </Paper>
      ];
    }
  }
  EnhancedTable.propTypes = {
    classes: PropTypes.object.isRequired,
  };
  const UsersLinkList = (props) => {
    return <EnhancedTable {...props} />
  }
  export default withStyles(styles)(UsersLinkList);