import {ProductProperty} from "../../../models/ProductProperty";
import {UserSetting} from "../../../models/UserSetting";

export function removeSetting(){

}

export async function commitUserSettings(productProperty: ProductProperty): Promise<void>{
    const payload = {
        settings: productProperty.userSettings().map(function (s: UserSetting){
            return s.payload()
        })
    };
    const url = `${process.env.NEXT_PUBLIC_BASE_URL}/user-settings/upsert`;
    const data = await fetch(url, {
        body: JSON.stringify(payload),
        method: "post",
        mode: "no-cors",
        headers: {
            'content-type': "application/json"
        },
        next: {
            revalidate: 0
        }
    })
    console.log(await data.text())
    // return await data.json();
}