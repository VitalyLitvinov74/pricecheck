import React, {useState} from "react";
import {Column, ColumnSetting, SettingType} from "../../../shared/types";
import {CommitButton} from "./buttons/CommitButton";
import {EditableButton} from "./buttons/EditableButton";
import {RemoveButton} from "./buttons/RemoveButton";

export function Row({originalProductColumn}: {
    originalProductColumn: Column,
}) {
    const [productColumn, setProductColumn] = useState(originalProductColumn)
    const [isEditing, setIsEditing] = useState<Boolean>(false)
    function options() {
        return [];
    }

    return (<>
        <tr key={productColumn.relatedId}>
            <td className="tabledit-edit-mode">
                {productColumn.name}
                {/*<Select*/}
                {/*    options={optionsFor(setting)}*/}
                {/*    defaultValue={buildOptionBy(setting)}*/}
                {/*    onChange={function (option) {*/}
                {/*        changeSetting(option, setting)*/}
                {/*    }}*/}
                {/*    menuPosition={"fixed"}*/}
                {/*>*/}
                {/*</Select>*/}
            </td>
            {productColumn.settings
                .filter(function (setting: ColumnSetting) {
                    return setting.type === SettingType.ColumnNumber
                })
                .map(function (setting: ColumnSetting) {
                    return (<td key={setting.id}>{setting.value}</td>)
                })
            }
            <td>
                <div className="button-list">
                    <EditableButton
                        isEditing={isEditing}
                        setIsEditing={setIsEditing}
                    />
                    <CommitButton
                        column={productColumn}
                        rowIsEditing={isEditing}
                        setIsEditingCallback={setIsEditing}
                    />
                    <RemoveButton
                        column={productColumn}
                        isEditing={isEditing}
                    />
                </div>
            </td>
        </tr>
    </>)
}