import {ProductAttributePayload} from "../shared/types";
import {ProductProperty} from "./ProductProperty";
import {uuid} from "../shared/helpers";

export class ProductAttribute {
    _value: string
    _property: ProductProperty
    constructor(value: string, property: ProductProperty) {
        this._value = value
        this._property = property
    }

    changeValue(value: string) {
        this._value = value
    }

    payload(): ProductAttributePayload {
        return {}
    }

    basedOn(property: ProductProperty): boolean {
        return this._property.equalsTo(property);
    }

    value(): string{
        return '-';
    }

    id(): string|number{
        return uuid()
    }
}