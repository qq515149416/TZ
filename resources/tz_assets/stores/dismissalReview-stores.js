import { observable, action, extendObservable} from "mobx";
import {get,post} from "../tool/http.js";
import ActionBoundStores from "./common/action-bound-stores.js";

class DismissalReviewStores {
    constructor(data) {
        extendObservable(this,data);
    }
}
class DismissalReviewsStores extends ActionBoundStores {
    @observable dismissalReviews = {
        business: [],
        orders: [],
    };
    @action.bound
    getData(type = "dismissalReview") {
        this.dismissalReviews = {
            business: [],
            orders: [],
        };
        get("under/show_apply_under").then((res) => {
            if(res.data.code==1) {
                if(type=="dismissalReview") {
                    this.dismissalReviews.business = res.data.data.business.map(item => new DismissalReviewStores(item));
                    this.dismissalReviews.orders = res.data.data.orders.map(item => new DismissalReviewStores(item));
                } else {
                    this.dismissalReviews.business = res.data.data.business.filter(item => item.remove_status > 1).map(item => new DismissalReviewStores(item));
                    this.dismissalReviews.orders = res.data.data.orders.filter(item => item.remove_status > 1).map(item => new DismissalReviewStores(item));
                }

            }
        });
    }
}
export default DismissalReviewsStores;
