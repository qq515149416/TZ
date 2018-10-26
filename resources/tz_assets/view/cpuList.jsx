import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";

const columnData = [
    { id: 'cpu_number', numeric: true, disablePadding: false, label: 'cpu编码' },
    { id: 'cpu_param', numeric: true, disablePadding: false, label: 'cpu参数' },
    { id: 'cpu_used', numeric: true, disablePadding: false, label: '使用状态' },
    { id: 'room', numeric: true, disablePadding: false, label: '机房名称' },
    { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
    { id: 'updated_at', numeric: true, disablePadding: false, label: '更新时间' },
    { id: 'operat', numeric: true, disablePadding: false, label: '操作' }
];
const inputType = [
    {
        field: "cpu_number",
        label: "cpu编码",
        type: "text"
    },
    {
        field: "cpu_param",
        label: "cpu参数",
        type: "text"
    },
    {
        field: "room_id",
        label: "所属机房",
        type: "select",
        defaultData: []
    }
];
@inject("cpusStores")
@observer 
class CpuList extends React.Component {
    componentDidMount() {
        this.props.cpusStores.getData();
    }
    addData = (param,callbrak) => {
        // console.log(param);
        this.props.cpusStores.addData(param).then((state) => {
          callbrak(state);
        });
    }
    changeData = (param,callbrak) => {
        const {cpusStores} = this.props;
        cpusStores.changeData(param).then((state) => {
          callbrak(state);
        });
    }
    delData = (selectedData,callbrak) => {
        const {cpusStores} = this.props;
        let delIng = selectedData.map(item => cpusStores.delData(item));
        callbrak(delIng);
    }
    render() {
        inputType[inputType.findIndex(item => item.field=="room_id")].defaultData = this.props.cpusStores.comprooms.map(item => {
            return {
              value: item.roomid,
              text: item.machine_room_name
            }
        });
        return (
          <ListTableComponent 
            title="cpu资源管理"
            operattext="cpu资源"
            inputType={inputType} 
            headTitlesData={columnData} 
            data={this.props.cpusStores.cpus} 
            addData={this.addData.bind(this)}
            changeData={this.changeData.bind(this)}
            delData={this.delData.bind(this)}  
          />
        );
      }
}
export default CpuList;