import {Column} from "../../../shared/types";

export function removeSetting(){

}

export async function upsertSettings(column: Column): Promise<Column>{
    const payload = {
        relatedId: column.relatedId,
        settings: column.settings.map(function (s){
            return {
                propertyId: column.relatedId,
                type: s.type,
                value: s.value
            }
        })
    };
    const url = `${process.env.NEXT_PUBLIC_BASE_URL}/product-table-settings/default/upsert-column-settings`;
    const data = await fetch(url, {
        body: JSON.stringify(payload),
        method: "post",
        // mode: "no-cors",
        headers: {
            'content-type': "application/json"
        },
        next: {
            revalidate: 1
        }
    })
    return await data.json();
}