import {Column, ColumnSetting} from "../types";


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

export const loadColumns = async function (): Promise<Column[]> {
    const url = `${process.env.URL}/product-table-settings/default/list-settings`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    console.log(url)
    return await data.json();
}

export async function loadProperties(){
    const url = `${process.env.URL}/properties/list`;
    const result = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    console.log(result)
    const data = await result.json();
    console.log(data)

    return data;
}