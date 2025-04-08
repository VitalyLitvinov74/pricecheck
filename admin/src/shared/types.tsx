export type ColumnSetting = {
    id: bigint | undefined,
    type: number,
    value: number,
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
