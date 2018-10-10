import React from "react";
import classNames from 'classnames';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';
import DeleteIcon from '@material-ui/icons/Delete';
import FilterListIcon from '@material-ui/icons/FilterList';
import { lighten } from '@material-ui/core/styles/colorManipulator';
import PostData from "./postData.jsx";
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
      width: 48 * 2 + 10,
      textAlign: "right"
    },
    title: {
      flex: '0 0 auto',
    },
  });
  
  let EnhancedTableToolbar = props => {
    const { numSelected, classes, selectedData, getParentData } = props;
    let data = selectedData.map(item => getParentData().find((e) => e.id == item));
    const delData = () => {
        let isDel = confirm(`是否要删除选中的${numSelected}个数据？`);
        if(isDel) {
            props.handleSelectAllEmptyClick();
            props.delData(selectedData,(delIng) => {
                Promise.all(delIng).then((ret) => {
                    selectedData.forEach((item,index) => {
                      if(ret[index]) {
                        console.log("ID:"+item+"，删除成功");
                      } else {
                        console.warn("ID:"+item+"，删除失败");
                      }
                    });
                  });
            });
        }
    }
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
            <Typography variant="title" id="tableTitle" dangerouslySetInnerHTML={{__html: props.title}}>
            </Typography>
          )}
        </div>
        <div className={classes.spacer} />
        <div className={classes.actions}>
          {numSelected > 0 ? [
            <div>
              {
                props.delData && (<Tooltip title="删除">
                  <IconButton onClick={()=>{delData();}} aria-label="Delete">
                    <DeleteIcon />
                  </IconButton>
                </Tooltip>)
              }
            </div>
          ]: (
            <span>
              {
                props.addData && (
                  <PostData operattext={props.operattext || this.props.title} inputType={props.inputType} addData={props.addData} postType="add" />
                )
              }
            </span>
          )}
        </div>
      </Toolbar>
    );
  };
  
  EnhancedTableToolbar.propTypes = {
    classes: PropTypes.object.isRequired,
    numSelected: PropTypes.number.isRequired,
  };
  
 export default withStyles(toolbarStyles)(EnhancedTableToolbar);