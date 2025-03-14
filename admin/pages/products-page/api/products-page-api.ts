import {TableSetting} from "../../../utils/types";

export async function loadProducts(queryString?:string) {
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

export const loadTableSettings = async function (): Promise<TableSetting[]> {
    const url = `${process.env.URL}/product/list-settings`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return await data.json();
}