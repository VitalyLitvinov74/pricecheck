import React from "react";
import {Column, ColumnSetting, SettingType} from "../../../shared/types";

export function Row({productColumn}: {
    productColumn: Column,
}) {
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
                    {/*<CommitButton/>*/}
                    {/*<RemoveButton/>*/}
                </div>
            </td>
        </tr>
    </>)
}