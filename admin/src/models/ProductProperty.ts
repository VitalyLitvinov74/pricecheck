import {uuid} from "../shared/helpers";
import {UserSetting} from "./UserSetting";

export class ProductProperty {
    id?: number;
    name: string;
    type: string;
    frontendId: string;
    userSettings: UserSetting[]

    constructor(data) {
        this.id = data.id;
        this.name = data.name;
        this.type = data.type;
        this.frontendId = uuid();
        this.userSettings = data.userSettings
    }
}