export type TableSetting = {
    property_id: bigint,
    setting_type_id: bigint,
    property: Property
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