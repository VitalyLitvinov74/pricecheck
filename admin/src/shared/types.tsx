export type TableSetting = {
    property_id: bigint,
    type: bigint,
    value: string,
}

export type ColumnSetting = {
    id: bigint | undefined,
    type: bigint,
    value: bigint,
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

export enum SettingType {
    IsEnabled = 1,
    ColumnNumber = 2,
}

export type ProductProperty = {
    id: bigint,
    name: string,
    type: string,
}

export type ProductTableSettings = {
    columnSettings: ProductProperty & {
        settings: ColumnSetting[],
    }[],
}
