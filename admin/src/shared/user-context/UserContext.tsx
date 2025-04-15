"use client"

import {createContext, useContext, useState} from "react";
import {UserSetting} from "../types";

const context = createContext<{
    settings: UserSetting[],
    setSettings: (settings: UserSetting[]) => void
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