import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";

const columnData = [
    { id: 'machineroom_name', numeric: true, disablePadding: true, label: '机房' },
    { id: 'use_state_cn', numeric: true, disablePadding: false, label: '使用状态' },
    { id: 'machine_count', numeric: true, disablePadding: false, label: '机器数量' },
    { id: 'machine_room_name', numeric: true, disablePadding: false, label: '机房' },
    { id: 'use_type_cn', numeric: true, disablePadding: false ,label: '使用类型' },
    { id: 'operat', numeric: true, disablePadding: false, label: '操作' }
];
const inputType = [
  {
    field: "cabinet_id",
    label: "机柜编号",
    type: "text"
  },
  {
    field: "use_type",
    label: "使用类型",
    radioData: [
        {
          checked: true,
          value: "0",
          label: "内部机柜"
        },
        {
          checked: false,
          value: "1",
          label: "客户机"
        }
      ],
      model: {
        selectCode: (data) => {
          switch(data) {
            case "内部机柜":
                return 0;
            case "客户机":
                return 1;
            default:
                return data;
          }
        }
    },
    type: "switch"
  },
  {
    field: "note",
    label: "备注信息",
    type: "text"
  },
  {
    field: "machineroom_id",
    label: "所属机房",
    type: "select",
    defaultData: []
  }
];
@inject("cabinetsStores")
@observer 
class CabinetList extends React.Component {
  componentDidMount() {
    this.props.cabinetsStores.getData();
  }
  addData = (param,callbrak) => {
    // console.log(param);
    this.props.cabinetsStores.addData(param).then((state) => {
      callbrak(state);
    });
  }
  render() {
    inputType[inputType.findIndex(item => item.field=="machineroom_id")].defaultData = this.props.cabinetsStores.comprooms.map(item => {
      return {
        value: item.roomid,
        text: item.machine_room_name
      }
    });
    return (
      <ListTableComponent 
        title="机柜资源库"
        operattext="机柜资源"
        inputType={inputType} 
        headTitlesData={columnData} 
        data={this.props.cabinetsStores.cabinets}  
        addData={this.addData.bind(this)}
      />
    );
  }
}
export default CabinetList;