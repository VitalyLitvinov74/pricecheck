"use client"

import {createContext, useContext, useState} from "react";
import {UserSettingPayload} from "../types";
import {UserSetting} from "../../models/UserSetting";

const context = createContext<{
    settings: UserSettingPayload[],
    setSettings: (settings: UserSettingPayload[]) => void
}>({
    settings: [],
    setSettings: () => {
    }
});

export function UserContext({children, settings}: {
    children: React.ReactNode,
    settings: UserSetting[]
}) {
    const [inputtedSettings, setSettings] = useState(settings)
    return (
        <context.Provider
            value={
                {
                    settings: inputtedSettings,
                    setSettings: setSettings
                }
            }
        >
            {children}
        </context.Provider>)
}
export const useUserContext = () => useContext(context)