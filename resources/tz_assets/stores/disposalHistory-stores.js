import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";

class DisposalHistoryStores {
    constructor(data) {
        extendObservable(this,data);
    }
}
class DisposalHistorysStores extends ActionBoundStores {
    @observable disposalHistorys = [];
    @action.bound
    getData(type = 1) {
        this.disposalHistorys = [];
        get("under/under_history",{
            type: type
        }).then((res) => {
            if(res.data.code==1) {
                this.disposalHistorys = res.data.data.map(item => new DisposalHistoryStores(item));
            }
        });
    }
}
export default DisposalHistorysStores;
