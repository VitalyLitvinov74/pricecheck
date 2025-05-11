export type Property = {
    id: number,
    name: string,
    type: string
}

export type ParsingSchemaProperty = {
    "id": number,
    "schema_id": number,
    "property_id": number,
    "external_column_name": string,
    "property": Property
}

export type ParsingSchema = {
    "id": number,
    "name": string,
    "start_with_row_num": number,
    "parsingSchemaProperties": ParsingSchemaProperty[]
}

export enum SettingType {
    IsEnabled = 2,
    ColumnNumber = 1,
}

export enum EntityType {
    ProductProperty = 1
}

export type ProductPropertyPayload = {
    id?: number,
    name: string,
    type: string,
    userSettingsPayload: UserSettingPayload[]
}

export type UserSettingPayload = {
    id?: number | undefined
    type: number
    stringValue?: string,
    intValue?: number
    frontendId: string
    entityId?: number|null
    entityType: EntityType
    entityFrontendId: string
}
