export function RemoveAttributeButton(){

    function remove(attribute) {
        changeAttributes(
            attributes.filter(function (validateAttribute) {
                return validateAttribute.id !== attribute.id;
            }))

        if (optionsFor(attribute).length > 0) {
            disableAddButton(false);
            return;
        }
    }

    return (<>

    </>)
}