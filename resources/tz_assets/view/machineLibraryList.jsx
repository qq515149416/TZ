import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
const columnData = [
    { id: 'machine_num', numeric: true, disablePadding: true, label: '机器编号' },
    { id: 'cpu', numeric: true, disablePadding: true, label: 'CPU' },
    { id: 'memory', numeric: true, disablePadding: true, label: '内存' },
    { id: 'harddisk', numeric: true, disablePadding: true, label: '硬盘' },
    { id: 'machineroom_name', numeric: true, disablePadding: true, label: '机房' },
    { id: 'cabinets', numeric: true, disablePadding: true, label: '机柜编号' },
    { id: 'ip', numeric: true, disablePadding: true, label: 'IP' },
    { id: 'bandwidth', numeric: true, disablePadding: true, label: '带宽(M)' },
    { id: 'protect', numeric: true, disablePadding: true, label: '防护(G)' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendData: [
        {id: "loginname", label: "登陆名", type: "text"},
        {id: "loginpass", label: "登录密码", type: "text"},
        {id: "machine_type", label: "机器型号" ,type: "text"},
        {id: "used", label: "使用状态" ,type: "text"},
        {id: "status", label: "机器状态" ,type: "text"},
        {id: "own_business", label: "所属业务编号" ,type: "text"},
        {id: "business_end", label: "业务到期时间" ,type: "text"},
        {id: "business", label: "业务类型" ,type: "text"},
        {id: "machine_note", label: "备注" ,type: "text"}
    ], label: '操作' }
];
const inputType = [
    {
        field: "machine_num",
        label: "机器编号",
        type: "text"
    },
    {
        field: "cpu",
        label: "CPU",
        type: "text"
    },
    {
        field: "memory",
        label: "内存",
        type: "text"
    },
    {
        field: "harddisk",
        label: "硬盘",
        type: "text"
    },
    {
        field: "machineroom",
        label: "选择机房",
        type: "select",
        defaultData: []
    },
    {
        field: "cabinet",
        label: "选择机柜",
        type: "select",
        defaultData: []
    },
    {
        field: "ip_company",
        label: "选择运营商",
        type: "switch",
        radioData: [
            {
                checked: true,
                value: "0",
                label: "电信公司"
            },
            {
                checked: false,
                value: "1",
                label: "移动公司"
            },
            {
                checked: false,
                value: "2",
                label: "联通公司"
            }
        ]
    },
    {
        field: "ip_id",
        label: "选择IP",
        type: "select",
        defaultData: []
    },
    {
        field: "bandwidth",
        label: "带宽(M)",
        type: "text"
    },
    {
        field: "protect",
        label: "防护(G)",
        type: "text"
    },
    {
        field: "loginname",
        label: "登陆名",
        type: "text"
    },
    {
        field: "loginpass",
        label: "登录密码",
        type: "text"
    },
    {
        field: "machine_type",
        label: "机器型号",
        type: "text"
    },
    {
        field: "used_status",
        label: "使用状态",
        type: "switch",
        radioData: [
            {
                checked: true,
                value: "0",
                label: "未使用"
            },
            {
                checked: false,
                value: "1",
                label: "使用中"
            },
            {
                checked: false,
                value: "2",
                label: "锁定"
            },
            {
                checked: false,
                value: "3",
                label: "迁移"
            }
        ]
    },
    {
        field: "machine_status",
        label: "机器状态",
        type: "switch",
        radioData: [
            {
                checked: true,
                value: "0",
                label: "上架"
            },
            {
                checked: false,
                value: "1",
                label: "下架"
            }
        ]
    },
    {
        field: "business_type",
        label: "业务类型",
        type: "switch",
        radioData: [
            {
                checked: true,
                value: "1",
                label: "租用"
            },
            {
                checked: false,
                value: "2",
                label: "托管"
            },
            {
                checked: false,
                value: "3",
                label: "备用"
            }
        ]
    },
    {
        field: "machine_note",
        label: "备注",
        type: "text"
    }
];
@inject("machineLibrarysStores")
@observer 
class MachineLibraryList extends React.Component {
    componentDidMount() {
        this.props.machineLibrarysStores.getData(1);
        inputType[inputType.findIndex(item => item.field=="machineroom")].model = {
            getSubordinateData: this.getCabinetData.bind(this)
        };
        inputType[inputType.findIndex(item => item.field=="cabinet")].model = {
            editGetSubordinateData: this.getCabinetData.bind(this)
        };
        inputType[inputType.findIndex(item => item.field=="ip_id")].model = {
            editGetSubordinateData: this.getIpsData.bind(this)
        };
        inputType[inputType.findIndex(item => item.field=="ip_company")].model = {
            getSubordinateData: this.getIpsData.bind(this)
        };
    }
    changeData = (param,callbrak) => {
        const {machineLibrarysStores} = this.props;
        machineLibrarysStores.changeData(param).then((state) => {
          callbrak(state);
        });
      }
    delData = (selectedData,callbrak) => {
        const {machineLibrarysStores} = this.props;
        let delIng = selectedData.map(item => machineLibrarysStores.delData(item));
        callbrak(delIng);
    }
    addData = (param,callbrak) => {
        // console.log(param);
        this.props.machineLibrarysStores.addData(param).then((state) => {
          callbrak(state);
        });
      }
    getCabinetData(param) {
        if(param.machineroom) {
            this.props.machineLibrarysStores.getCabinetsData({
                roomid: param.machineroom.value
            });
        }
        if(param.machineroom&&param.ip_company) {
            this.props.machineLibrarysStores.getIpsData({
                roomid: param.machineroom.value,
                ip_company: param.ip_company.value
            });
        }
    }
    getIpsData(param) {
        if(param.machineroom&&param.ip_company) {
            this.props.machineLibrarysStores.getIpsData({
                roomid: param.machineroom.value,
                ip_company: param.ip_company.value
            });
        }
    }
    render() {
        inputType[inputType.findIndex(item => item.field=="machineroom")].defaultData = this.props.machineLibrarysStores.comprooms.map(item => {
            return {
              value: item.roomid,
              text: item.machine_room_name
            }
        });
        inputType[inputType.findIndex(item => item.field=="cabinet")].defaultData = this.props.machineLibrarysStores.cabinets.map(item => {
            return {
              value: item.cabinetid,
              text: item.cabinet_id
            }
        });
        inputType[inputType.findIndex(item => item.field=="ip_id")].defaultData = this.props.machineLibrarysStores.ips.map(item => {
            return {
              value: item.ipid,
              text: item.ip
            }
        });
        return (
          <ListTableComponent 
            title="机器库"
            operattext="机器资源"
            inputType={inputType}
            headTitlesData={columnData} 
            data={this.props.machineLibrarysStores.machineLibrarys}  
            addData={this.addData.bind(this)} 
            delData={this.delData.bind(this)} 
            // changeData={this.changeData.bind(this)} 
          />
        );
      }
}
export default MachineLibraryList;