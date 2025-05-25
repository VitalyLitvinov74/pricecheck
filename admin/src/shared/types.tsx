export type ParsingSchemaProperty = {
    "id": number,
    "schema_id": number,
    "property_id": number,
    "external_column_name": string,
    "property": ProductPropertyPayload
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
    Property = 1
}

export type UserSetting = {
    id: number
    user_id: number
    type: SettingType
    string_value: string
    int_value: number
    entity_id: number
    entity_type: EntityType
}



export type Property = {
    id: number
    name: string
    type: PropertyType
    product_template_id: number
}

export enum PropertyType {
    String = 'string',
    Int = 'int',
    Decimal = 'decimal'
}

export type Product = {
    id: number
    created_at: string
}

export type Attribute = {
    id: number
    property_id: number
    property_name: string
    value: string
    product_id: number
}