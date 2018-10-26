import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import CustomizeTableToolbar from "../component/listTable/customizeTableToolbar.jsx";

const styles = theme => ({
    listTableComponent: {
        marginTop: 0,
        borderRadius: "0 0 4px 4px",
        boxShadow: "0px 4px 5px 0px rgba(0, 0, 0, 0.1), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.12)"
    }
});
const columnData = [
    { id: 'salesman', numeric: true, disablePadding: false, label: '业务员' },
    { id: 'all_arrears', numeric: true, disablePadding: false, label: '总的欠款' },
    { id: 'this_arrears', numeric: true, disablePadding: false, label: '当月欠款' },
    { id: 'performance', numeric: true, disablePadding: false, label: '订单业绩' },
    { id: 'total_money', numeric: true, disablePadding: false, label: '总消费额' },
    { id: 'updated_at', numeric: true, disablePadding: false, label: '统计时间' },
    { id: 'month', numeric: true, disablePadding: false, label: '统计的月份' }
];
const inputType = [
];
@inject("statisticalPerformancesStores")
@observer 
class StatisticalPerformanceList extends React.Component {
    constructor(props) {
        super(props);
    }
    componentDidMount() {
        this.props.statisticalPerformancesStores.getData();
    }
    render() {
        const {classes} = this.props;
        return (
            <ListTableComponent 
            title="业绩统计"
            operattext="业绩管理"
            inputType={inputType} 
            headTitlesData={columnData} 
            data={this.props.statisticalPerformancesStores.statisticalPerformances} 
            customizeToolbar={<CustomizeTableToolbar getData={this.props.statisticalPerformancesStores.getData} />}
          />
        );
      }
}
StatisticalPerformanceList.propTypes = {
    classes: PropTypes.object.isRequired,
};
const StatisticalPerformanceListComponent = (props) => {
    return <StatisticalPerformanceList {...props} />
}
export default withStyles(styles)(StatisticalPerformanceListComponent);