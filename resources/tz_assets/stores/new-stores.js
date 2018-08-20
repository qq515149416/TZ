import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";
const dateFormat = require('dateformat');
class NewStores {
    @observable id =  1;
    @observable title =  "";
    @observable digest ="";
    @observable top_status = "";
    @observable home_status = "";
    @observable seoKeywords = "";
    @observable seoDescription = "";
    @observable seoTitle = "";
    @observable type_name = {};
    @observable content = "";
    constructor({id, title, content, digest, top_status, home_status, seoKeywords, seoDescription, seoTitle,type_name}) {
        Object.assign(this,{
            id,
            title,
            digest,
            content,
            top_status,
            home_status,
            seoKeywords,
            seoDescription,
            seoTitle,
            type_name
        });
    }
}
class TypeStores {
    @observable tid =  1;
    @observable type_name =  "";
    constructor({tid,type_name}) {
        Object.assign(this,{
            tid,
            type_name
        });
    }
}
class NewsStores extends ActionBoundStores {
    @observable articles = [

    ];
    @observable types = [

    ];
    addData(data) {
        return new Promise((resolve,reject) => {
            post("news/insert",data).then((res) => {
                if(res.data.code==1) {
                    this.addStoreData("articles",NewStores,Object.assign(data,{
                        id: res.data.data,
                        top_status: this.stateText(String(data.top_status),{
                            "0" : "不显示",
                            "1": "显示"
                        }),
                        home_status: this.stateText(String(data.ip_status),{
                            "0" : "不显示",
                            "1": "显示"
                        }),
                        created_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss"),
                        updated_at: dateFormat(new Date(),"yyyy-mm-dd hh:MM:ss")
                    }));
                    resolve(true);
                } else {
                    alert(res.data.msg);
                    resolve(false);
                }
            }).catch(reject);
        });
    }
    @action.bound 
    getData() {
        get("news/get_news_type").then((res) => {
            if(res.data.code==1) {
                this.types = res.data.data.map(item => new TypeStores(item));
            }
        });
        get("news/news_list").then((res) => {
            if(res.data.code==1) {
                this.articles = res.data.data.map(item => new NewStores({
                    ...{
                        id: item.id,
                        title: item.title,
                        digest: item.digest,
                        top_status: item.top_status,
                        home_status: item.home_status,
                        seoKeywords: item.seoKeywords,
                        seoDescription: item.seoDescription,
                        seoTitle: item.seoTitle,
                        type_name: item.type_name,
                        content: item.content
                    }
                }));
            }
        });
    }
}
export default NewsStores;