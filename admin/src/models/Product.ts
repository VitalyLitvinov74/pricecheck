import {ProductPayload} from "../shared/types";
import {ProductAttribute} from "./ProductAttribute";
import {uuid} from "../shared/helpers";
import {ProductProperty} from "./ProductProperty";

export class Product {

    _id: number
    _createdAt: string
    _attributes: ProductAttribute[]
    _frontEndId: string

    constructor(productPayload: ProductPayload | Product) {
        if (productPayload instanceof Product) {
            productPayload = productPayload.payload()
        }
        this._id = productPayload.id
        this._createdAt = productPayload.createdAt
        this._attributes = productPayload.productAttributes
            .map(function (item) {
                return new ProductAttribute(item)
            })
        this._frontEndId = uuid()
    }

    id() {
        return this._id
    }

    payload(): ProductPayload {
        return {
            id: this._id,
            createdAt: this._createdAt,
            productAttributes: this._attributes
                .map(function (item) {
                    return item.payload()
                })
        }
    }

    attributeByProperty(property: ProductProperty): ProductAttribute  {
        const attr = this._attributes
            .find(function(attribute){
                return attribute.basedOn(property)
            })
        if(attr){
            return attr;
        }
        return new ProductAttribute({});
    }
}