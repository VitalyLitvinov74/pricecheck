
import {uuid} from "../helpers";
import {ProductProperty} from "../../models/ProductProperty";
import {ProductPropertyPayload} from "../types";


export async function loadProducts(queryString?: string) {
    const url = `${process.env.URL}/product/index?${queryString}`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return await data.json();
}

export const loadProduct = async function (id) {
    const url = `${process.env.URL}/product/${id}`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return data.json();
}

export async function loadProperties(): Promise<ProductPropertyPayload[]> {
    const url = `${process.env.URL}/product-module/available-properties`;
    const result = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    const data = await result.json();
    return data.data;
}