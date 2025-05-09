import {EntityType} from "../shared/types";

export class UserSetting{
    id?: number | undefined
    type: number
    value: string
    frontendId: string
    entityId?: number|undefined
    entityType: EntityType
    entityFrontendId: string
    constructor(data) {
        this.id = data.id;
        this.type = data.type;
        this.value = data.value;
        this.frontendId = data.frontendId;
        this.entityId = data.entityId;
        this.entityType = data.entityType;
        this.entityFrontendId = data.entityFrontendId
    }
}