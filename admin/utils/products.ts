export const loadProducts = async function () {
    const url = `${process.env.URL}/product/index`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return data.json();
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

export type tableSetting = {
    property_id: bigint,
    setting_type_id: bigint,
    property: {
        id: bigint,
        name: string,
        type: string
    }
}
export const loadTableSettings = async function (): Promise<Array<tableSetting>> {
    const url = `${process.env.URL}/product/list-settings`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return data.json();
}