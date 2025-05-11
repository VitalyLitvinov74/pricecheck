import {uuid} from "../shared/helpers";
import {UserSetting} from "./UserSetting";
import {ProductPropertyPayload} from "../shared/types";

export class ProductProperty {
    id?: number;
    name: string;
    type: string;
    frontendId: string;
    private _userSettings: UserSetting[]

    constructor(data) {
        this.id = data.id;
        this.name = data.name;
        this.type = data.type;
        this.frontendId = data.frontendId ? data.frontendId : uuid();
        const self = this;
        this._userSettings = data.userSettings.map(
            function (item: UserSetting) {
                item.entityFrontendId = self.frontendId
                item.entityId = self.id
                return item
            }
        )
    }

    userSettings(): UserSetting[] {
        return this._userSettings.sort(function (item1, item2) {
            return item1.type > item2.type ? 1 : -1
        })
    }

    hasFronedId(frontendId: string): boolean {
        return this.frontendId === frontendId;
    }
}