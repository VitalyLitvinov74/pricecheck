import React from "react";

export function CommitButton() {
    function commit() {

    }

    return (<>
        <button type={"submit"}
                onClick={() => commit(setting)}
                className="btn btn-primary-rgba">
            <i className="feather icon-save"></i>
        </button>
    </>)
}