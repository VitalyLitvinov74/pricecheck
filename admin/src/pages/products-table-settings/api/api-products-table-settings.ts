import {Column} from "../../../shared/types";
import {ProductProperty} from "../../../models/ProductProperty";

export function removeSetting(){

}

export async function commitUserSettings(productProperty: ProductProperty): Promise<void>{
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
    const url = `${process.env.NEXT_PUBLIC_BASE_URL}/user-settings/upsert`;
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