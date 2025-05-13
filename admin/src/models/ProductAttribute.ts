import {ProductAttributePayload} from "../shared/types";
import {ProductProperty} from "./ProductProperty";

export class ProductAttribute {
    constructor(payload: ProductAttributePayload) {
    }

    payload(): ProductAttributePayload {
        return {}
    }

    basedOn(property: ProductProperty): boolean {
        return true;
    }

    value(): string{
        return '';
    }
}