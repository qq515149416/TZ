import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import TabComponent from "../component/tabComponent.jsx";
import ChecksComponent from "../component/checksComponent.jsx";

const styles = theme => ({
    listTableComponent: {
        marginTop: 0,
        borderRadius: "0 0 4px 4px",
        boxShadow: "0px 4px 5px 0px rgba(0, 0, 0, 0.1), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.12)"
    }
});

const columnData = [
    { id: 'id', numeric: true, disablePadding: false, label: 'ID' },
    { id: 'ip', numeric: true, disablePadding: false, label: 'IP' },
    { id: 'site', numeric: true, disablePadding: false, label: '地区' },
    { id: 'protection_value', numeric: true, disablePadding: false, label: '防御值' },
    { id: 'status', numeric: true, disablePadding: false, label: '使用状态' },
    { id: 'operat', numeric: true, disablePadding: false, label: '操作' }
];

const inputType = [
    {
        field: "site",
        label: "地区",
        type: "select",
        defaultData: [{
            value: 1,
            text: "西安"
        }],
        model: {
            selectCode: (data) => {
              switch(data) {
                case "西安":
                    return 1;
              }
            }
        }
    },
    {
        field: "protection_value",
        label: "防御值",
        type: "text"
    },
    {
        field: "ip",
        label: "",
        type: "component",
        Component: ChecksComponent
    }
];

@inject("defenseipsStores")
@observer
class DefenseipList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: 0
        };
    }
    componentDidMount() {
        this.props.defenseipsStores.getData({
            status: this.state.value,
            site: 1
        });
    }
    addData = (param,callbrak) => {
        this.props.defenseipsStores.addData(param).then((state) => {
            callbrak(state);
        });
    }
    changeData = (param,callbrak) => {
        const {defenseipsStores} = this.props;
        defenseipsStores.changeData(param).then((state) => {
          callbrak(state);
        });
    }
    handleChange = (value) => {
        this.props.defenseipsStores.getData({
            status: value,
            site: 1
        });
        this.setState({ value });
    }
    render() {
        const { classes } = this.props;
        return (
            <TabComponent onChange={this.handleChange} type={this.state.value} types={[
                {
                    label: "未使用",
                    value: 0
                },
                {
                    label: "使用中",
                    value: 1
                }
            ]}>
                <ListTableComponent
                    className={classes.listTableComponent}
                    inputType={inputType}
                    title="高防IP管理"
                    operattext="高防IP"
                    headTitlesData={columnData}
                    addData={this.addData.bind(this)}
                    changeData={this.changeData.bind(this)}
                    data={this.props.defenseipsStores.defenseips}
                />
          </TabComponent>
        );
      }
}
DefenseipList.propTypes = {
    classes: PropTypes.object.isRequired,
};
export default withStyles(styles)(DefenseipList);
