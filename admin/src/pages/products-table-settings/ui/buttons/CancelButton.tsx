import React from "react";
import {Column} from "../../../../shared/types";

export function CancelButton({column, isEditing, setCallbackColumn, originalColumn, setIsEditingCallback}: {
    column: Column,
    isEditing: boolean,
    setCallbackColumn: (column: Column) => void,
    originalColumn: Column,
    setIsEditingCallback: (isEditing: boolean) => void
}) {

    function click() {
        if (isEditing) {
            setCallbackColumn(originalColumn)
            setIsEditingCallback(false)
            return;
        }
        console.log('remove')
        setIsEditingCallback(false)
    }

    return (
        <>{isEditing &&
            <button type={"submit"}
                    onClick={click}
                    className="btn btn-danger-rgba"
            >
                <i className={"feather icon-slash"}/>
            </button>
        }</>
    )
}