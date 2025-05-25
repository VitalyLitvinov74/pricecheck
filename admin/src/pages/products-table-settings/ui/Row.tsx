import React, {useState} from "react";
import {EditableButton} from "./buttons/EditableButton";
import {PropertyLibrary} from "../../../models/PropertyLibrary";
import {UserSetting} from "../../../models/UserSetting";
import {CommitButton} from "./buttons/CommitButton";

export function Row({
                        productProperty,
                        setProductProperty
                    }: {
    productProperty: PropertyLibrary,
    setProductProperty: (productProperty: PropertyLibrary) => void
}) {
    const [isEditing, setIsEditing] = useState<Boolean>(false)

    function setSetting(setting: UserSetting, newValue) {
        const newSetting = new UserSetting({
            ...setting,
            intValue: newValue
        });
        setProductProperty(
            new PropertyLibrary({
                ...productProperty,
                userSettings: productProperty.userSettings().map(function (item) {
                    if (item.frontendId === newSetting.frontendId) {
                        return newSetting
                    }
                    return item
                })
            })
        )
    }

    return (<>
        <td className="tabledit-edit-mode">
            {productProperty.name}
        </td>
        {productProperty.userSettings().map(function (setting: UserSetting) {
            return (<td key={setting.frontendId} className="tabledit-edit-mode">
                {isEditing &&
                    <input
                        type="number"
                        className={"form-control"}
                        value={setting.value()}
                        onChange={(e) => setSetting(setting, e.target.value)}
                        onFocus={()=>{setSetting(setting, '')}}
                    />
                }
                {!isEditing &&
                    <>{setting.value()}</>
                }
            </td>)
        })}
        <td>
            <div className="button-list">
                <EditableButton
                    isEditing={isEditing}
                    setIsEditing={setIsEditing}
                />
                <CommitButton
                    productProperty={productProperty}
                    rowIsEditing={isEditing}
                    setIsEditingCallback={setIsEditing}
                />
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