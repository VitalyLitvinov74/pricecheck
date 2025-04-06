import React from "react";

export function RemoveButton(){
    return (
        <button type={"submit"} onClick={() => removeRow(setting)} className="btn btn-danger-rgba">
            <i className={
                setting.committed !== true
                    ? "feather icon-slash"
                    : "feather icon-trash"}>
            </i>
        </button>
    )
}