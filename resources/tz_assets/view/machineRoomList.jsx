import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";

const columnData = [
    { id: 'machine_room_id', numeric: true, disablePadding: false, label: '机房编号' },
    { id: 'machine_room_name', numeric: true, disablePadding: false, label: '机房中文名' },
    { id: 'list_order', numeric: true, disablePadding: false, label: '排序' },
    { id: 'created_at', numeric: true, disablePadding: false, label: '创建时间' },
    { id: 'updated_at', numeric: true, disablePadding: false, label: '更新时间' }
];
const inputType = [
  {
    field: "room_id",
    label: "机房编号",
    type: "text"
  },
  {
    field: "room_name",
    label: "机房中文名",
    type: "text"
  },
  {
    field: "list_order",
    label: "排序",
    type: "text"
  }
];
@inject("MachineRoomsStores")
@observer 
class MachineRoomList extends React.Component {
  componentDidMount() {
    this.props.MachineRoomsStores.getData();
  }
  addData = (param,callbrak) => {
    // console.log(param);
    this.props.MachineRoomsStores.addData(param).then(state => {
      callbrak(state);
    });
  }
  render() {
    return (
      <ListTableComponent 
        title="机房管理"
        operattext="机房"
        inputType={inputType} 
        headTitlesData={columnData} 
        data={this.props.MachineRoomsStores.machineRooms}
        addData={this.addData.bind(this)}  
      />
    );
  }
}
export default MachineRoomList;