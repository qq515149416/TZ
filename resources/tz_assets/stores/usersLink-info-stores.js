import { observable, action} from "mobx";
import {get,post} from "../tool/http.js";
class UsersLinkInfoStores {
    counter = 0;
    @observable user = [

    ];
    
}