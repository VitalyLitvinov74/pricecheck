import {ProductAttributePayload} from "../shared/types";
import {ProductProperty} from "./ProductProperty";
import {uuid} from "../shared/helpers";

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
        return '-';
    }

    id(): string|number{
        return uuid()
    }
}