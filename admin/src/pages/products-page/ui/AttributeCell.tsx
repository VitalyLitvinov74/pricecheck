import React from "react";
import {ProductAttribute} from "../../../models/ProductAttribute";

export function AttributeCell({attribute}: {
    attribute: ProductAttribute|undefined
}) {
    if (attribute) {
        return (
            <td>
                {attribute.value()}
            </td>
        );
    }
    return (<td> - </td>);
}