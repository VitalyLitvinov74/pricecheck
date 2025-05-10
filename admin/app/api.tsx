import {UserSettingPayload} from "../src/shared/types";
import {uuid} from "../src/shared/helpers";

export async function loadUserSettings(): Promise<UserSettingPayload[]> {
    const result = await fetch(`${process.env.URL}/user-settings`, {
        next: {
            revalidate: 0
        }
    })
    return await result.json();
}