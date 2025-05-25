import {UserSetting} from "../../../shared/types";

export function removeSetting() {

}

export async function commitUserSettings(settings: UserSetting[]): Promise<void> {
    const payload = settings.map(function (setting: UserSetting) {
        return {
            type: setting.type,
            stringValue: setting.string_value,
            intValue: setting.int_value,
            entityId: setting.entity_id,
            entityType: setting.entity_type,
        }
    })
    const url = `${process.env.NEXT_PUBLIC_BASE_URL}/user-settings/upsert`;
    const data = await fetch(url, {
        body: JSON.stringify({
            settings: payload
        }),
        method: "post",
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