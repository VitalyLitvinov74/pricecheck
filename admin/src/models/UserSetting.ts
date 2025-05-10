import {EntityType, SettingType} from "../shared/types";
import {uuid} from "../shared/helpers";

export class UserSetting {
    id?: number | undefined
    type: number
    private stringValue: string
    private intValue: number
    frontendId: string
    entityId?: number | null
    entityType: EntityType
    entityFrontendId: string
    userId: number | null

    constructor(data) {
        this.id = data.id;
        this.type = data.type;
        this.stringValue = data.stringValue;
        this.frontendId = data.frontendId ? data.frontendId : uuid();
        this.entityId = data.entityId;
        this.entityType = data.entityType;
        this.userId = data.userId
        this.intValue = data.intValue

    }

    isDefault(): boolean {
        return this.entityId == null || this.userId == null;
    }

    label(): string {
        switch (this.type) {
            case SettingType.ColumnNumber:
                return "Номер колонки";
            case SettingType.IsEnabled:
                return "Включено"
            default:
                return ''
        }
    }

    value(): string|number{
        if(this.stringValue){
            return this.stringValue
        }
        return this.intValue
    }
}