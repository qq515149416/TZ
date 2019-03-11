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
    business_type = 1
    @action.bound
    getData(param={}) {
        let url = 'pfmStatistics/pfmBig';
        if(location.search.indexOf("?type=recharge") > -1) {
            url = 'rechargeStatistics/list';
        }
        this.statisticalPerformances = [];
        get(url,Object.assign(param,{
            business_type: this.business_type
        })).then((res) => {
            if(res.data.code==1) {
                this.statisticalPerformances = res.data.data.map(item => new StatisticalPerformanceStores(item));
            }
        });
    }
}
export default StatisticalPerformancesStores;
