import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
import { get } from "../tool/http.js";
import Obtained from "../component/icon/obtained.jsx";

const qs = require('qs');

const columnData = [
    { id: 'user_name', numeric: true, disablePadding: false, label: '用户名' },
    { id: 'ip', numeric: true, disablePadding: false, label: 'IP' },
    { id: 'price', numeric: true, disablePadding: false, label: '价格' },
    { id: 'status', numeric: true, disablePadding: false, label: '使用状态' },
    { id: 'end_at', numeric: true, disablePadding: false, label: '过期时间' },
    { id: 'target_ip', numeric: true, disablePadding: false, label: '绑定IP' },
    { id: 'operat', numeric: true, disablePadding: false, label: '操作', extend: true, extendConfirm: {
        rule: {
            term: "status",
            execute: "正在使用",
            type: "equal"
          },
        title: "下架申请",
        content: "是否要下架次业务",
        icon: <Obtained />,
        ok: (data) => {
            return new Promise((resolve,reject) => {
                get("defenseip/remove/subExamine",{
                    business_id: data.id,
                }).then((res) => {
                    if(res.data.code==1) {
                        alert(res.data.msg);
                        resolve(res.data);
                    } else {
                        alert(res.data.msg);
                        resolve(res.data);
                    }
                }).catch(reject);
            });
        }
    } }
];

const inputType = [

]

@inject("defenseBusinessStores")
@observer
class DefenseBusinesList extends React.Component {
    componentDidMount() {
        this.props.defenseBusinessStores.getData(qs.parse(location.search.substr(1)).id);
    }

    updata() {
        this.props.defenseBusinessStores.getData(qs.parse(location.search.substr(1)).id);
    }

    render() {
        return (
          <ListTableComponent
            title="高防业务管理"
            operattext="高防IP相关业务"
            inputType={inputType}
            headTitlesData={columnData}
            data={this.props.defenseBusinessStores.defenseBusiness}
            updata={this.updata.bind(this)}
          />
        );
      }
}

export default DefenseBusinesList;
