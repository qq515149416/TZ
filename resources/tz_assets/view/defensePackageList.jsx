import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import { routerConfig } from "../config/common/config.js";

const columnData = [
    { id: 'name', numeric: true, disablePadding: false, label: '套餐名字' },
    { id: 'description', numeric: true, disablePadding: false, label: '套餐描述' },
    { id: 'site', numeric: true, disablePadding: false, label: '地区' },
    { id: 'protection_value', numeric: true, disablePadding: false, label: '防御值' },
    { id: 'price', numeric: true, disablePadding: false, label: '价格' },
    { id: 'operat', numeric: true, disablePadding: false, label: '操作', extend: true, extendUrl: [
        {
            title: "相关业务",
            link: routerConfig.baseUrl+"/defenseBusines",
            param: ["id"]
        }
      ] }
];

const inputType = [
    {
        field: "name",
        label: "套餐名字",
        type: "text"
    },
    {
        field: "description",
        label: "套餐描述",
        type: "text"
    },
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
        field: "price",
        label: "价格",
        type: "text"
    }
];

@inject("defensePackagesStores")
@observer
class DefensePackageList extends React.Component {
    componentDidMount() {
        this.props.defensePackagesStores.getData({
            site: 1
        });
    }
    delData = (selectedData,callbrak) => {
        const {defensePackagesStores} = this.props;
        let delIng = selectedData.map(item => defensePackagesStores.delData(item));
        callbrak(delIng);
    }
    addData = (param,callbrak) => {
        this.props.defensePackagesStores.addData(param).then((state) => {
            callbrak(state);
        });
    }
    changeData = (param,callbrak) => {
        const {defensePackagesStores} = this.props;
        defensePackagesStores.changeData(param).then((state) => {
          callbrak(state);
        });
    }
    render() {
        return (
            <ListTableComponent
                inputType={inputType}
                title="高防套餐管理"
                operattext="高防套餐"
                headTitlesData={columnData}
                addData={this.addData.bind(this)}
                changeData={this.changeData.bind(this)}
                delData={this.delData.bind(this)}
                data={this.props.defensePackagesStores.defensePackages}
            />
        );
    }
}
export default DefensePackageList;
