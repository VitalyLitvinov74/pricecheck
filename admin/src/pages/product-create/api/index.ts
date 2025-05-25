import {Attribute} from "../../../shared/types";

export async function createProduct(attributes: Attribute[]) {
    const url = `${process.env.NEXT_PUBLIC_BASE_URL}/product/create`;
    const payload = {
        attributes: attributes.map(function (item: Attribute) {
            return {
                ...item,
                propertyId: item.property_id,
                propertyName: item.property_name,
            }
        })
    }
    const data = await fetch(url, {
        body: JSON.stringify(payload),
        method: "post",
        headers: {
            'content-type': "application/json"
        }
    })
    if(data.status === 204) return;
    if(data.status > 400) throw new Error('Что то не так');
}