import {UserSetting} from "../src/shared/types";

export async function loadUserSettings(): Promise<{
    settings: UserSetting[],
    defaultSettings: UserSetting[]
}> {
    const result = await fetch(`${process.env.URL}/user-settings`, {
        next: {
            revalidate: 0
        }
    })
    const data = await result.json();
    return data.data;
}