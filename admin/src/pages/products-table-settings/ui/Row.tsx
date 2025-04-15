import React, {useState} from "react";
import {AdminPanelColumnSetting, SettingType, ProductProperty, PropertyTypeOfEntity} from "../../../shared/types";
import {EditableButton} from "./buttons/EditableButton";
import {uuid} from "../../../shared/helpers";
import {CancelButton} from "./buttons/CancelButton";

export function Row({
                        productColumnsSettings,
                        productProperty,
                        headerColumns
                    }: {
    productColumnsSettings: AdminPanelColumnSetting[],
    productProperty: ProductProperty,
    headerColumns: { type: SettingType, word: string }[]
}) {
   const [fullProductColumnsSettings, setFullProductColumnsSettings] = useState(
       headerColumns.map(function (headerColumn) {
           let productColumnSetting = productColumnsSettings.find(function (setting) {
               return setting.column_setting_type === headerColumn.type
               && productProperty.id === setting.property_of_business_logic_entity_id
           })
           if(!productColumnSetting){
               return createSetting(productProperty, headerColumn.type)
           }
           return productColumnSetting;
       })
   )
    const [isEditing, setIsEditing] = useState<Boolean>(false)


    function createSetting(property: ProductProperty, type: SettingType): AdminPanelColumnSetting {
        let value;
        switch (type) {
            case SettingType.IsEnabled:
                value = 0;
                break;
            case SettingType.ColumnNumber:
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
        setFullProductColumnsSettings(function (prevState) {
            return prevState.map(function (existingSetting) {
                if (existingSetting.frontend_id === setting.frontend_id) {
                    setting.value = newValue
                    return setting;
                }
                return existingSetting;
            });
        })
    }

    return (<>
        <td className="tabledit-edit-mode">
            {productProperty.name}
        </td>
        {headerColumns.map(function (column) {
            let needlePropertySetting = fullProductColumnsSettings.find(
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
            return (<td key={needlePropertySetting.frontend_id} className="tabledit-edit-mode">
                {isEditing &&
                    <input
                        type="number"
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
    </>)
}