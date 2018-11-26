import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";

class DefenseBusinesStores {
    constructor(data) {
        extendObservable(this,data);
    }
}

class DefenseBusinessStores extends ActionBoundStores {
    @observable defenseBusiness = [

    ];
    @action.bound
    getData(id) {
        get("defenseip/remove/showBusinessByPackage",{
            package_id: id
        }).then(res => {
            if(res.data.code==1) {
                this.defenseBusiness = res.data.data.map(item => new DefenseBusinesStores(item));
            }
        });
    }
}

export default DefenseBusinessStores;
