

export function EditableButton({isEditing, setIsEditing}: {
    isEditing: boolean,
    setIsEditing: (isEditing: boolean) => void
}) {
    return (<>
        {!isEditing &&
            <button
                onClick={() => setIsEditing(true)}
                className="btn btn-success-rgba"
            ><i className="feather icon-edit-2"></i>
            </button>
        }
    </>)
}