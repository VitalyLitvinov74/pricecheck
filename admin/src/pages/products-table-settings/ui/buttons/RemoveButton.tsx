import React from "react";
import {Column} from "../../../../shared/types";

export function RemoveButton({column, isEditing, setCallbackColumn, originalColumn, setIsEditingCallback}: {
    column: Column,
    isEditing: boolean,
    setCallbackColumn: (column: Column) => void,
    originalColumn: Column,
    setIsEditingCallback: (isEditing: boolean) => void
}) {

    function click() {
        if(isEditing){
            setCallbackColumn(originalColumn)
            setIsEditingCallback(false)
            return;
        }
        console.log('remove')
        setIsEditingCallback(false)
    }

    return (
        <button type={"submit"}
            onClick={click}
                className="btn btn-danger-rgba"
        >
            <i className={
                isEditing
                    ? "feather icon-slash"
                    : "feather icon-trash"}
            >
            </i>
        </button>
    )
}