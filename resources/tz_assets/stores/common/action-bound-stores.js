import {observable ,action} from "mobx";
class ActionBoundStores {
    @observable copyData = [];
    @action.bound
    addStoreData(storeAttr,AddStore,data) {
        this[storeAttr].push(new AddStore(data));
    }
    @action.bound
    delStoreData(storeAttr,id) {
        this[storeAttr].splice(this[storeAttr].findIndex((item) => item.id==id),1);
    }
    @action.bound
    changeStoreData(storeAttr,EditStore,param) {
        this[storeAttr][this[storeAttr].findIndex((item) => item.id==param.id)] = new EditStore(Object.assign(this[storeAttr][this[storeAttr].findIndex((item) => item.id==param.id)],param));
    }
    @action.bound
    filterStoreData(storeAttr, type, param) {
        if(type=="select") {
           this.copyData = this[storeAttr].map(item => item);

        }else if(type=="reset") {
            if(this.copyData && this.copyData.length > 0) {
                this[storeAttr] = this.copyData;
            }
        }
    }
}
export default ActionBoundStores;