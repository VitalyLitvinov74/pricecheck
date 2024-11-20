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