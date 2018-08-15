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
class NewsStores extends ActionBoundStores {
    @observable articles = [

    ];
    @action.bound 
    getData() {
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