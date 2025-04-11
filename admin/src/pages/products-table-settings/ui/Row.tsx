import React, {useState} from "react";
import {AdminPanelColumnSetting, ColumnSettingType, ProductProperty, PropertyTypeOfEntity} from "../../../shared/types";
import {EditableButton} from "./buttons/EditableButton";
import {uuid} from "../../../shared/helpers";

export function Row({
                        productPropertiesSettings: originalProductPropertiesSettings,
                        productProperty,
                        headerColumns
                    }: {
    productPropertiesSettings: AdminPanelColumnSetting[],
    productProperty: ProductProperty,
    headerColumns: { type: ColumnSettingType, word: string }[]
}) {
    const [productPropertiesSettings, setProductPropertiesSettings] = useState(
        originalProductPropertiesSettings.filter(
            function (setting) {
                return setting.property_of_business_logic_entity_id === productProperty.id
            }
        )
    )
    // const existedColumnNum = originalProductColumn.settings.find(function (s) {
    //     return s.type === ColumnSettingType.ColumnNumber
    // })
    //
    // if (!existedColumnNum) {
    //     originalProductColumn.settings.push({
    //         id: undefined,
    //         type: ColumnSettingType.ColumnNumber,
    //         value: 999,
    //     })
    // }
    // originalProductColumn.settings = originalProductColumn.settings.map(function (setting: ColumnSetting) {
    //     return {
    //         ...setting,
    //         frontendId: uuid()
    //     }
    // })
    //
    // const [productColumn, setProductColumn] = useState(originalProductColumn)
    const [isEditing, setIsEditing] = useState<Boolean>(false)


    function createSetting(property: ProductProperty, type: ColumnSettingType): AdminPanelColumnSetting {
        let value;
        switch (type) {
            case ColumnSettingType.IsEnabled:
                value = 0;
                break;
            case ColumnSettingType.ColumnNumber:
                value = 99;
                break;
        }
        return {
            admin_panel_entity_id: undefined,
            column_setting_type: type,
            id: undefined,
            property_of_business_logic_entity_id: property.id,
            property_type_of_business_logic_entity: PropertyTypeOfEntity.ProductProperty,
            value: value,
            frontend_id: uuid()
        }
    }

    function changeProductPropertySetting(setting, newValue,) {
        setProductPropertiesSettings(function (prevState) {
            console.log(productPropertiesSettings)
            return prevState.map(function (existingSetting) {
                if(existingSetting.frontend_id === setting.frontend_id) {

                    setting.value = newValue
                    return setting;
                }
                console.log('heelo')
                return existingSetting;
            });
        })
    }

    return (<>
        <tr key={productProperty.id}>
            <td className="tabledit-edit-mode">
                {productProperty.name}
            </td>
            {headerColumns.map(function (column) {
                let needlePropertySetting = productPropertiesSettings.find(
                    function (setting) {
                        return setting.column_setting_type === column.type
                            && productProperty.id === setting.property_of_business_logic_entity_id
                    })
                if (!needlePropertySetting) {
                    needlePropertySetting = createSetting(
                        productProperty,
                        column.type,
                    );
                }
                return (<td className="tabledit-edit-mode">
                    {isEditing &&
                        <input
                            type="text"
                            className={"form-control"}
                            value={needlePropertySetting.value}
                            onChange={(e) => changeProductPropertySetting(needlePropertySetting, e.target.value)}
                        />
                    }
                    {!isEditing &&
                        <>{needlePropertySetting.value}</>
                    }
                </td>)
            })}
            <td>
                <div className="button-list">
                    <EditableButton
                        isEditing={isEditing}
                        setIsEditing={setIsEditing}
                    />
                    {/*<CommitButton*/}
                    {/*    column={productColumn}*/}
                    {/*    rowIsEditing={isEditing}*/}
                    {/*    setIsEditingCallback={setIsEditing}*/}
                    {/*/>*/}
                    {/*<CancelButton*/}
                    {/*    column={productColumn}*/}
                    {/*    originalColumn={originalProductColumn}*/}
                    {/*    isEditing={isEditing}*/}
                    {/*    setCallbackColumn={setProductColumn}*/}
                    {/*    setIsEditingCallback={setIsEditing}*/}
                    {/*/>*/}
                </div>
            </td>
        </tr>
    </>)
}