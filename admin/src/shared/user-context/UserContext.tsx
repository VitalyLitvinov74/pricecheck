"use client"

import {createContext, useContext, useState} from "react";
import {UserSettingPayload} from "../types";
import {UserSetting} from "../../models/UserSetting";

const context = createContext<{
    settingsPayload: UserSettingPayload[],
    setSettings: (settings: UserSetting[]) => void,
    settings: UserSetting[],
}>({
    settingsPayload: [],
    setSettings: () => {
    },
    settings: [],
});

export function UserContext({children, settingsPayload}: {
    children: React.ReactNode,
    settingsPayload: UserSettingPayload[]
}) {
    const [settings, setSettings] = useState(
        settingsPayload.map(function (item) {
            return new UserSetting(item)
        })
    )

    return (
        <context.Provider
            value={
                {
                    settingsPayload: settingsPayload,
                    setSettings: setSettings,
                    settings: settings
                }
            }
        >
            {children}
        </context.Provider>)
}
export const useUserContext = () => useContext(context)