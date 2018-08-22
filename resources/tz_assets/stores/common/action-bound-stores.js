import {action} from "mobx";
class ActionBoundStores {
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
}
export default ActionBoundStores;