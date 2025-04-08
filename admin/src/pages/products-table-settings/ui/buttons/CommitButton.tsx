import React from "react";
import {Column} from "../../../../shared/types";

export function CommitButton({column, rowIsEditing, setIsEditingCallback}: {
    column: Column,
    rowIsEditing: boolean,
    setIsEditingCallback: (isEditing: boolean) => void
}) {
    function commit() {
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