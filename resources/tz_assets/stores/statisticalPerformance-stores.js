import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class StatisticalPerformanceStores {
    constructor(data) {
        extendObservable(this,data);
    }
}
class StatisticalPerformancesStores extends ActionBoundStores {
    @observable statisticalPerformances = [

    ];
    @action.bound
    getData(param={}) {
        let url = 'pfmStatistics/pfmStatisticsList';
        if(location.search.indexOf("?type=recharge") > -1) {
            url = 'rechargeStatistics/list';
        }
        this.statisticalPerformances = [];
        get(url,param).then((res) => {
            if(res.data.code==1) {
                this.statisticalPerformances = res.data.data.map(item => new StatisticalPerformanceStores(item));
            }
        });
    }
}
export default StatisticalPerformancesStores;
