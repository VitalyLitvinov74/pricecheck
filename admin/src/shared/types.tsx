export type ColumnSetting = {
    id: bigint | undefined,
    type: number,
    value: number,
    frontendId?: string
}

export type Property = {
    id: bigint,
    name: string,
    type: string
}

export type ParsingSchemaProperty = {
    "id": bigint,
    "schema_id": bigint,
    "property_id": bigint,
    "external_column_name": string,
    "property": Property
}

export type ParsingSchema = {
    "id": bigint,
    "name": string,
    "start_with_row_num": bigint,
    "parsingSchemaProperties": ParsingSchemaProperty[]
}

export enum ColumnSettingType {
    IsEnabled = 2,
    ColumnNumber = 1,
}

export type ProductProperty = {
    id: bigint,
    name: string,
    type: string,
}

export type Column = {
    relatedId: bigint,
    name: string,
    settings: ColumnSetting[],
}

export enum PropertyTypeOfEntity {
    ProductProperty = 1
}

export type AdminPanelElement = {
    id: bigint,
    user_id: bigint,
    type: bigint,
    columnsSettings?: AdminPanelColumnSetting[]
}

export type AdminPanelColumnSetting = {
    id: bigint,
    column_setting_type: ColumnSettingType,
    value: any,
    property_of_business_logic_entity_id: bigint,
    admin_panel_entity_id: bigint,
    property_type_of_business_logic_entity: PropertyTypeOfEntity,
}

export type ProductColumnSetting = AdminPanelColumnSetting & {
    productProperty: ProductProperty
}

