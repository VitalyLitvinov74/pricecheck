import React from "react";
import {Attribute} from "../../../shared/types";

export function AttributeCell({attribute}: {
    attribute: Attribute
}) {
    if (attribute) {
        return (
            <td>
                {attribute.value}
            </td>
        );
    }
    return (<td> - </td>);
}