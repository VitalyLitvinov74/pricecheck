import Select from "react-select";
import {CommitButton} from "./CommitButton";
import React, {useState} from "react";
import {ColumnSetting, ProductProperty, TableSetting} from "../../../shared/types";
import {RemoveButton} from "./RemoveButton";

export function Row({setting}: {
    setting: ProductProperty & {settings: ColumnSetting[]},
}) {
    function options() {
        return [];
    }

    return (<>
        <tr key={setting.id}>
            <td className="tabledit-edit-mode">
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
            <td>
                <div className="button-list">
                    <CommitButton/>
                    <RemoveButton/>
                </div>
            </td>
        </tr>
    </>)
}