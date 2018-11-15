import React from "react";
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import ListTableComponent from "../component/listTableComponent.jsx";
import InputExpansion from "../component/dialog/inputExpansion.jsx";
import StatisticsShowComponent from "../component/statisticsShowComponent.jsx";
import RenewalFee from "../component/dialog/renewalFee.jsx";
import WorkOrderPost from "../component/dialog/workOrderPost.jsx";
import {post} from "../tool/http.js";
import extendElementsComponent from "../tool/extendElementsComponent";
import TabComponent from "../component/tabComponent.jsx";
import { inject,observer } from "mobx-react";
import Enable from "../component/icon/enable.jsx";
const classNames = require('classnames');
const dateFormat = require('dateformat');
const qs = require('qs');

const styles = theme => ({
    fastExpired: {
        background: "orange"
    },
    expired: {
        background: "crimson"
    },
    tableHover: {
       "&:hover": {
            backgroundColor: "#3c8dbc !important"
       }
    },
    textStyle: {
        fontSize: 16
    },
    listTableComponent: {
        marginTop: 0,
        borderRadius: "0 0 4px 4px",
        boxShadow: "0px 4px 5px 0px rgba(0, 0, 0, 0.1), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.12)"
    },
    listFilterComponent: {
        marginTop: 0,
        borderRadius: "0",
        boxShadow: "0px 4px 5px 0px rgba(0, 0, 0, 0.1), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.12)"
    }
});

const columnData = [
    { id: 'business_number', numeric: true, disablePadding: true, label: '业务号' },
    { id: 'type', numeric: true, disablePadding: true, label: '业务类型' },
    { id: 'machine_number', numeric: true, disablePadding: true, label: '机器/机柜编号' },
    { id: 'status', numeric: true, disablePadding: true, label: '业务状态' },
    { id: 'resource_detail_json.ip', numeric: true, disablePadding: true, label: 'IP' },
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
      icon: <Enable />,
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
    },extendElement: (data) => {
      if(data.business_status==2) {
        let Element = extendElementsComponent([
          RenewalFee,
          WorkOrderPost
        ]);
        return <Element {...data} postUrl="business/renewresource" nameParam="machine_number" type="业务" />;
      }else {
        return null;
      }
  }, extendUrl: [
    {
        title: "全部订单",
        link: "/tz_admin/business/order",
        param: ["business_number","client_id","client_name","machine_number",{
          field: "resource_detail_json",
          value: ["machineroom_id"]
        }],
        rule: {
          term: "business_status",
          execute: 2,
          type: "equal"
      }
    }
  ], label: '操作' }
];
const inputType = [
  // {
  //   field: "client_name",
  //   label: "客户姓名",
  //   type: "text"
  // },
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
  },
  {
    field: "showInfo",
    label: "",
    type: "component",
    Component: StatisticsShowComponent
  }
];
const filterType = [
    {
        field: "type",
        label: "业务类型",
        options: [
            {
            view: "租用主机"
            },
            {
            view: "托管主机"
            },
            {
            view: "租用机柜"
            }
        ],
        type: "select"
    },
    {
        field: "start_time",
        label: "创建时间",
        type: "date"
    }
];
@inject("businessStores")
@observer
class BusinesList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: "all"
        };
    }
  componentDidMount() {
    this.props.businessStores.getData(qs.parse(location.search.substr(1)).id);
    // inputType[inputType.findIndex(item => item.field=="client_name")].model = {
    //   getSubordinateData: this.setClientName.bind(this)
    // };
    inputType[inputType.findIndex(item => item.field=="money")].model = {
      getSubordinateData: this.setMoneyName.bind(this)
    };
    inputType[inputType.findIndex(item => item.field=="length")].model = {
      getSubordinateData: this.setLengthName.bind(this)
    };
    inputType[inputType.findIndex(item => item.field=="business_type")].model = {
      getSubordinateData: this.setBusinessTypeName.bind(this)
    };
    inputType[inputType.findIndex(item => item.field=="machine_number")].model = {
      getSubordinateData: this.setMachineNumberName.bind(this)
    };
  }
  // setClientName(param,type) {
  //   // console.log(param);
  //   this.props.businessStores.changeStatistics("clientName",param);
  // }
  setMoneyName(param,type) {
    this.props.businessStores.changeStatistics("unitPrice",param);
  }
  setLengthName(param,type) {
    this.props.businessStores.changeStatistics("length",param);
  }
  setBusinessTypeName(param,type) {
    let codeValue = {
      1: "租用主机",
      2: "托管主机",
      3: "租用机柜"
    };
    this.props.businessStores.changeStatistics("businessType",codeValue[param.business_type.value]);
  }
  setMachineNumberName(param,type) {
    // console.log(param);
    this.props.businessStores.changeStatistics("productName",param);
  }
  updata() {
    this.props.businessStores.getData(qs.parse(location.search.substr(1)).id);
  }
  handleChange = (value) => {
        this.props.businessStores.findData({
            business_status: value
        });
        this.setState({ value });
    }
  addData = (param,callbrak) => {
    param.client_id = qs.parse(location.search.substr(1)).id;
    param.resource_detail = JSON.stringify(param.machine_number);
    param.machine_number = param.machine_number.id;
    this.props.businessStores.addData(param).then((state) => {
      callbrak(state);
    });
  }
  delData = (selectedData,callbrak) => {
    const {businessStores} = this.props;
    let delIng = selectedData.map(item => businessStores.delData(item));
    callbrak(delIng);
  }
  filterData = (param) => {
    const {businessStores} = this.props;
    businessStores.filterData(param);
  }
  render() {
      const {classes} = this.props;
    return (
        <TabComponent onChange={this.handleChange} type={this.state.value} types={[
            {
                label: "全部",
                value: "all"
            },
            {
                label: "未付款",
                value: 1
            },
            {
                label: "审核中",
                value: 0
            },
            {
                label: "审核不通过",
                value: -2
            },
            {
                label: "取消",
                value: -1
            },
            {
                label: "到期",
                value: 5
            },
            {
                label: "退款",
                value: 6
            }
        ]}>
             <ListTableComponent
                title={`客户账号：${qs.parse(location.search.substr(1)).email}&nbsp;&nbsp;&nbsp;&nbsp;客户余额：${qs.parse(location.search.substr(1)).money}&nbsp;&nbsp;&nbsp;&nbsp;客户账号状态：${qs.parse(location.search.substr(1)).status}&nbsp;&nbsp;&nbsp;&nbsp;业务员：${qs.parse(location.search.substr(1)).clerk_name}`}
                operattext="业务信息"
                listFilterComponentClassName={classes.listFilterComponent}
                className={classes.listTableComponent}
                inputType={inputType}
                filterType={filterType}
                headTitlesData={columnData}
                data={this.props.businessStores.business}
                addData={this.addData.bind(this)}
                updata={this.updata.bind(this)}
                delData={this.delData.bind(this)}
                filterData={this.filterData.bind(this)}
                tableRowStyle={data => {
                    let endTime = Math.round(new Date(data.endding_time).getTime()/1000);
                    let nowTime = Math.round(new Date().getTime()/1000);
                    return {
                        classes: {
                            root: classNames({
                                [classes.fastExpired]:  (endTime > nowTime && (endTime - nowTime) < 60*60*24*3),
                                [classes.expired]: endTime < nowTime
                            }),
                            hover: classes.tableHover
                        }
                    };
                }}
            />
        </TabComponent>
    );
  }
}
BusinesList.propTypes = {
    classes: PropTypes.object.isRequired,
};
export default withStyles(styles)(BusinesList);
