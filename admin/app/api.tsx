import {UserSetting} from "../src/shared/types";
import {uuid} from "../src/shared/helpers";

export async function loadUserSettings(): Promise<UserSetting[]> {
    const result = await fetch(`${process.env.URL}/user-settings`, {
        next: {
            revalidate: 0
        }
    })
    const settings: UserSetting[] = await result.json();
    return settings.map(function(setting){
        setting.entityFrontendId = uuid()
        setting.frontendId = uuid()
        return setting
    })
}