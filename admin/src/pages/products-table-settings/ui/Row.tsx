import React, {useState} from "react";
import {Column, ColumnSetting, SettingType} from "../../../shared/types";
import {CommitButton} from "./buttons/CommitButton";
import {EditableButton} from "./buttons/EditableButton";
import {RemoveButton} from "./buttons/RemoveButton";
import {uuid} from "../../../shared/helpers";

export function Row({originalProductColumn}: {
    originalProductColumn: Column,
}) {

    const existedColumnNum = originalProductColumn.settings.find(function (s) {
        return s.type === SettingType.ColumnNumber
    })

    if (!existedColumnNum) {
        originalProductColumn.settings.push({
            id: undefined,
            type: SettingType.ColumnNumber,
            value: 999,
        })
    }
    originalProductColumn.settings = originalProductColumn.settings.map(function (setting: ColumnSetting) {
        return {
            ...setting,
            frontendId: uuid()
        }
    })

    const [productColumn, setProductColumn] = useState(originalProductColumn)
    const [isEditing, setIsEditing] = useState<Boolean>(false)

    function options() {
        return [];
    }

    function changeSetting(setting: ColumnSetting, newValue) {
        const newSetting = {...setting, value: newValue}
        setProductColumn({
            ...productColumn,
            settings: productColumn.settings.map(function (s) {
                if (s.frontendId === newSetting.frontendId) {
                    return newSetting;
                }
                return s;
            })
        })
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
                    if (!isEditing) {
                        return (<td key={setting.id}>{setting.value}</td>)
                    }
                    return (
                        <td
                            key={setting.id}
                            className={'tabledit-edit-mode'}>
                            <input
                                key={setting.id}
                                className={"tabledit-input form-control input-sm"}
                                value={setting.value}
                                onChange={(event) => {
                                    changeSetting(setting, event.target.value)
                                }}
                            />
                        </td>
                    )
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
                        originalColumn={originalProductColumn}
                        isEditing={isEditing}
                        setCallbackColumn={setProductColumn}
                        setIsEditingCallback={setIsEditing}
                    />
                </div>
            </td>
        </tr>
    </>)
}