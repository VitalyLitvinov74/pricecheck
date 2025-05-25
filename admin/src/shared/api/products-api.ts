
import {uuid} from "../helpers";
import {PropertyLibrary} from "../../models/PropertyLibrary";
import {Attribute, Product, ProductPropertyPayload, Property} from "../types";


export async function loadProducts(queryString?: string): Promise<
    (Product & {productAttributes: Attribute[]})[]
> {
    const url = `${process.env.URL}/product/index?${queryString}`;
    const response = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    const result = await response.json();
    return result.data;
}

export const loadProduct = async function (id) {
    const url = `${process.env.URL}/product/${id}`;
    const response = await fetch(url, {
        next: {
            revalidate: 1
        }
    })
    const result = await response.json()
    return result.data;
}

export async function loadGeneralProperties(): Promise<Property[]> {
    const url = `${process.env.URL}/product/general-properties`;
    const result = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    const data = await result.json();
    return data.data;
}