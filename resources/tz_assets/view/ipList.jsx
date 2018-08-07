import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";

const columnData = [
    { id: 'ip', numeric: true, disablePadding: true, label: 'IP地址' },
    { id: 'vlan', numeric: true, disablePadding: false, label: 'vlan' },
    { id: 'ip_company', numeric: true, disablePadding: false, label: '所属运营商' },
    { id: 'ip_status', numeric: true, disablePadding: false, label: '使用状态' },
    { id: 'ip_lock', numeric: true, disablePadding: false, label: '锁定状态' },
    { id: 'ip_note', numeric: true, disablePadding: false, label: '备注信息' },
    { id: 'job', numeric: true, disablePadding: false, label: '岗位' },
    { id: 'mailbox', numeric: true, disablePadding: false, label: '邮箱' }
];