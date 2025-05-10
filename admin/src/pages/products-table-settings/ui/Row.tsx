import React, {useState} from "react";
import {EntityType,  SettingType, UserSettingPayload} from "../../../shared/types";
import {EditableButton} from "./buttons/EditableButton";
import {uuid} from "../../../shared/helpers";
import {useUserContext} from "../../../shared/user-context/UserContext";
import {ProductProperty} from "../../../models/ProductProperty";
import {UserSetting} from "../../../models/UserSetting";

export function Row({
                        productProperty,
                        headerColumns
                    }: {
    productProperty: ProductProperty,
    headerColumns: { type: SettingType, word: string }[]
}) {
    const user = useUserContext();
    const [settings, setSettings] = useState<UserSetting[]>(user.settings)

    function settingByType(settingType: SettingType): UserSettingPayload {
        const setting1: UserSettingPayload = {
            entityFrontendId: productProperty.frontendId,
            entity_type: EntityType.ProductProperty,
            frontendId: uuid(),
            entity_id: productProperty.id,
            type: SettingType.ColumnNumber,
            value: '99'
        }
        const setting2: UserSettingPayload = {
            entity_id: productProperty.id,
            entityFrontendId: productProperty.frontendId,
            entity_type: EntityType.ProductProperty,
            frontendId: uuid(),
            type: SettingType.IsEnabled,
            value: "1"
        }

        let setting = settings.find(function (setting) {
            return setting.type === settingType
                && (setting.entity_id === productProperty.id || setting.entityFrontendId === productProperty.frontendId)
        })
        if (setting) {
            return setting;
        }
        switch (settingType) {
            case SettingType.ColumnNumber:
                return setting1;
            case SettingType.IsEnabled:
                return setting2;
        }
    }

    const [isEditing, setIsEditing] = useState<Boolean>(false)

    function setSetting(setting: UserSettingPayload, newValue) {
        //не работает с дефольными полями
        const newSettings = settings.map(function (existedSetting) {
            if (existedSetting.frontendId === setting.frontendId) {
                setting.value = newValue;
                return setting
            }
            return existedSetting;
        })
        console.log(settings)
        setSettings(newSettings)
    }

    return (<>
        <td className="tabledit-edit-mode">
            {productProperty.name}
        </td>
        {headerColumns.map(function (column) {
            const setting = settingByType(column.type)
            return (<td key={setting.frontendId} className="tabledit-edit-mode">
                {isEditing &&
                    <input
                        type="number"
                        className={"form-control"}
                        value={setting.value}
                        onChange={(e) => setSetting(setting, e.target.value)}
                    />
                }
                {!isEditing &&
                    <>{setting.value}</>
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