import React, {useState} from "react";
import {EditableButton} from "./buttons/EditableButton";
import {useTableSettingsPageContext} from "./ProductsTableSettings";
import {useUserContext} from "../../../shared/user-context/UserContext";
import {EntityType, Property, SettingType, UserSetting} from "../../../shared/types";
import {uuid} from "../../../shared/helpers";

export function Row({property}: { property: Property }) {
    const [isEditing, setIsEditing] = useState<Boolean>(false)
    const user = useUserContext();
    const tableSettingPage = useTableSettingsPageContext()

    const priorityMap = new Map<SettingType, number>();
    tableSettingPage.settingsTypesForProperties.forEach((type, index) => {
        priorityMap.set(type, index);
    });

    return (<tr>
        <td className="tabledit-edit-mode">
            {property.name}
        </td>
        {user
            .settingsBy(EntityType.Property, property.id)
            .sort(function (userSetting1, userSetting2) {
                const aPriority = priorityMap.get(userSetting1.type) ?? Infinity; // Неизвестные типы в конец
                const bPriority = priorityMap.get(userSetting2.type) ?? Infinity;

                return aPriority - bPriority;
            })
            .map(function (setting: UserSetting) {
                return (
                    <td key={uuid()} className="tabledit-edit-mode">
                        {isEditing &&
                            <input
                                type="number"
                                className={"form-control"}
                                value={setting.int_value}
                                // onChange={(e) => setSetting(setting, e.target.value)}
                                // onFocus={()=>{setSetting(setting, '')}}
                            />
                        }
                        {!isEditing &&
                            <>{setting.int_value}</>
                        }
                    </td>
                )
            })}
        <td>
            <div className="button-list">
                <EditableButton
                    isEditing={isEditing}
                    setIsEditing={setIsEditing}
                />
                {/*<CommitButton*/}
                {/*    productProperty={property}*/}
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
    </tr>)
}