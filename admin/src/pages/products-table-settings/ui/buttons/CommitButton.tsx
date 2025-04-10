import React from "react";
import {Column} from "../../../../shared/types";
import {upsertSettings} from "../../api/api-products-table-settings";

export function CommitButton({column, rowIsEditing, setIsEditingCallback}: {
    column: Column,
    rowIsEditing: boolean,
    setIsEditingCallback: (isEditing: boolean) => void
}) {
    async function commit() {
        await upsertSettings(column)
        setIsEditingCallback(false)
    }

    return (<>
        {rowIsEditing &&
            <button type={"submit"}
                    onClick={commit}
                    className="btn btn-primary-rgba">
                <i className="feather icon-save"></i>
            </button>}
    </>)
}