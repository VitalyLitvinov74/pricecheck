import {uuid} from "../shared/helpers";
import {UserSetting} from "./UserSetting";

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
        this._userSettings = data.userSettings?.map(
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

    equalsTo(property: ProductProperty): boolean {
        return property.hasFronedId(this.frontendId) || property.hasType(this.type) && this.hasId(this.id);
    }

    private hasType(type: string): boolean {
        return this.type === type
    }

    private hasId(id: any): boolean {
        return this.id === id || this.frontendId === id
    }
}