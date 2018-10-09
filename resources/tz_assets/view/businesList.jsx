import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import InputExpansion from "../component/dialog/inputExpansion.jsx";
import OrderShow from "../component/dialog/orderShow.jsx";
import {post} from "../tool/http.js";
import { inject,observer } from "mobx-react";
const qs = require('qs');
const columnData = [
    { id: 'client_name', numeric: true, disablePadding: true, label: '客户' },
    { id: 'sales_name', numeric: true, disablePadding: true, label: '业务员' },
    { id: 'business_number', numeric: true, disablePadding: true, label: '业务号' },
    { id: 'type', numeric: true, disablePadding: true, label: '业务类型' },
    { id: 'machine_number', numeric: true, disablePadding: true, label: '机器/机柜编号' },
    { id: 'status', numeric: true, disablePadding: true, label: '业务状态' },
    { id: 'resource_detail_json.machineroom_name', numeric: true, disablePadding: true, label: '所属机房' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendData: [
        {id: "order_number", label: "订单号", type: "text"},
        {id: "resource_detail", label: "资源详情", type: "subordinate", subordinate: [
          {id: "machine_num", label: "机器编号", type: "text"},
          {id: "cpu", label: "CPU", type: "text"},
          {id: "memory", label: "内存", type: "text"},
          {id: "harddisk", label: "硬盘", type: "text"},
          {id: "bandwidth", label: "带宽", type: "text"},
          {id: "protect", label: "防御", type: "text"},
          {id: "loginname", label: "账号", type: "text"},
          {id: "loginpass", label: "密码", type: "text"},
          {id: "machine_type", label: "机器型号", type: "text"},
          {id: "machine_note", label: "机器备注", type: "text"},
          {id: "cabinet_id", label: "机柜编号", type: "text"}
        ]},
        {id: "money", label: "单价" ,type: "text"},
        {id: "length", label: "时长" ,type: "text"},
        {id: "start_time", label: "业务开始时间" ,type: "text"},
        {id: "endding_time", label: "业务结束时间" ,type: "text"},
        {id: "business_note", label: "业务备注" ,type: "text"}
    ],extendConfirm: {
      rule: {
        term: "business_status",
        execute: 1,
        type: "equal"
    },
      title: "业务操作",
      content: "是否要启用此业务？",
      ok: (data) => {
          return new Promise((resolve,reject) => {
              post("business/enable",{
                  business_status: 3,
                  id: data.id
              }).then((res) => {
                  if(res.data.code==1) {
                      alert("启用成功");
                      resolve(res.data);
                  } else {
                      alert(res.data.msg);
                      resolve(res.data);
                  }
              }).catch(reject);
          });
      }
    }, extendUrl: {
      title: "全部订单",
      link: "/tz_admin/business/order",
      param: ["business_number","client_id","client_name",{
        field: "resource_detail_json",
        value: ["machineroom_id"]
      }],
      rule: {
        term: "business_status",
        execute: 2,
        type: "equal"
    }
  }, label: '操作' }
];
const inputType = [
  {
    field: "client_name",
    label: "客户姓名",
    type: "text"
  },
  {
    field: "money",
    label: "资源单价",
    type: "text"
  },
  {
    field: "length",
    label: "时长",
    type: "text"
  },
  {
    field: "business_note",
    label: "业务备注",
    type: "text"
  },
  {
    field: "business_type",
    label: "业务类型",
    type: "switch",
    radioData: [
        {
            checked: true,
            value: "1",
            label: "租用主机"
        },
        {
            checked: false,
            value: "2",
            label: "托管主机"
        },
        {
            checked: false,
            value: "3",
            label: "租用机柜"
        }
    ]

  },
  {
    field: "machine_number",
    label: "主机/机柜编号",
    type: "component",
    Component: InputExpansion,
    rule: {
      term: "business_type",
      execute: [
        {
          index: "1",
          value: "rent_machine",
          default: true
        },
        {
          index: "3",
          value: "cabinet"
        },
        {
          index: "2",
          value: "hosting_machine"
        }
      ],
      type: "component"
    }
  }
];
@inject("businessStores")
@observer 
class BusinesList extends React.Component {
  componentDidMount() {
    this.props.businessStores.getData(qs.parse(location.search.substr(1)).id);
  }
  updata() {
    this.props.businessStores.getData(qs.parse(location.search.substr(1)).id);
  }
  addData = (param,callbrak) => {
    if(location.search.indexOf("?id=")!=-1&&location.search.indexOf("&")==-1) {
      param.client_id = location.search.substr(1).split("=")[1];
      param.resource_detail = JSON.stringify(param.machine_number);
      param.machine_number = param.machine_number.id;
      this.props.businessStores.addData(param).then((state) => {
        callbrak(state);
      });
    }
  
  }
  render() {
    return (
      <ListTableComponent 
        title="业务管理"
        operattext="业务信息"
        inputType={inputType} 
        headTitlesData={columnData} 
        data={this.props.businessStores.business}  
        addData={this.addData.bind(this)} 
        updata={this.updata.bind(this)}
      />
    );
  }
}
export default BusinesList;