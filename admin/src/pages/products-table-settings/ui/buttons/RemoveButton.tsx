import React from "react";
import {Column} from "../../../../shared/types";

export function RemoveButton({column, isEditing}: {
    column: Column,
    isEditing: boolean
}) {
    return (
        <button type={"submit"}
                // onClick={() => removeRow(setting)}
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