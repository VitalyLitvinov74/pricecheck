import React from "react";
import {commitUserSettings} from "../../api/api-products-table-settings";

export function CommitButton({productProperty, rowIsEditing, setIsEditingCallback}: {
    productProperty: Property,
    rowIsEditing: boolean,
    setIsEditingCallback: (isEditing: boolean) => void
}) {
    async function commit() {
        await commitUserSettings(productProperty)
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