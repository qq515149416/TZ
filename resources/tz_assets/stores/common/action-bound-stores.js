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
           if(!this.copyData.length) {
            for(let key in this[storeAttr]) {
                this.copyData[key] = this[storeAttr][key];
            }
           }
           this[storeAttr] = this.copyData.filter(item => {
               for(let key in param) {
                    console.log(key!="startTime"&&key!="endTime",item[key],param[key]);
                   if(key!="startTime"&&key!="endTime"&&item[key]==param[key]) {
                       return item;
                   }else if(key!="startTime"&&key!="endTime"&&param[key]=="all"&&item[key]) {
                        return item;
                   }
               }
           });
           console.log(this[storeAttr],param,"typeFilter");
           this[storeAttr] = this[storeAttr].filter(item => {
                let create_time = Math.round(new Date(item.created_at).getTime()/1000);
               if(item.created_at&&param["startTime"]&&param["endTime"]) {
                    if(create_time>param["startTime"]&&create_time<param["endTime"]) {
                        return item;
                    }
               }else if(item.created_at&&param["startTime"]) {
                    if(create_time>param["startTime"]) {
                        return item;
                    }
               }else if(item.created_at&&param["endTime"]) {
                    if(create_time<param["endTime"]) {
                        return item;
                    }
               } else {
                    return item;
               }
           });
           console.log(this[storeAttr],param,"dateFilter");
           if(param["searchContent"]&&param["searchType"]) {
            this[storeAttr] = this[storeAttr].filter(item => {
                if(param["searchType"]=="all") {
                    for(let key in item) {
                        if(item[key].indexOf(param["searchContent"])!=-1) {
                            return item;
                        }
                    }
                } else {
                    if(item[param["searchType"]] && item[param["searchType"]].indexOf(param["searchContent"])!=-1) {
                        return item;
                    }
                }
            });
           }
           console.log(this[storeAttr],param,"searchFilter");
        }else if(type=="reset") {
            if(this.copyData && this.copyData.length > 0) {
                this[storeAttr] = this.copyData;
            }
        }
    }
}
export default ActionBoundStores;