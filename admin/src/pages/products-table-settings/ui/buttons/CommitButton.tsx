import React from "react";
import {Property} from "csstype";
import {useUserContext} from "../../../../shared/user-context/UserContext";
import {EntityType} from "../../../../shared/types";

export function CommitButton({property, rowIsEditing, setIsEditingCallback}: {
    property: Property,
    rowIsEditing: boolean,
    setIsEditingCallback: (isEditing: boolean) => void
}) {
    const user = useUserContext();

    function commit() {
        try {
            user.commitSettings(
                user.settingsBy(EntityType.Property, property.id)
            )
            setIsEditingCallback(false)
        } catch (e) {
            console.log(e)
        }
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