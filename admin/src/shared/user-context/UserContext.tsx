"use client"

import {createContext, useContext, useState} from "react";
import {EntityType, UserSettingPayload} from "../types";
import {UserSetting} from "../../models/UserSetting";

const context = createContext<{
    settingsPayload: UserSettingPayload[],
    setSettings: (settings: UserSetting[]) => void,
    settings: UserSetting[],
    findByTypeAndEntityId: (EntityType: EntityType, entityId: number) => UserSetting[]
}>({
    settingsPayload: [],
    setSettings: () => {
    },
    settings: [],
    findByTypeAndEntityId: () => []
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

    function findByTypeAndEntityId(entityType: EntityType, entityId: number): UserSetting[] {
        const filteredSettings = settings.filter(function (item) {
            return item.entityType === entityType && item.entityId === entityId
        })

        //дальше нужно добавить девофлтовые значения
        const defaultSettings = settings.filter(function (item) {
            return item.entityType === entityType && item.isDefault()
        })

        defaultSettings.forEach(function (item) {
            const filteredSetting = filteredSettings.find(function (item2) {
                return item2.type === item.type
            });
            if (!filteredSetting) {
                filteredSettings.push(item)
            }
        })

        return filteredSettings;
    }

    return (
        <context.Provider
            value={
                {
                    settingsPayload: settingsPayload,
                    setSettings: setSettings,
                    settings: settings,
                    findByTypeAndEntityId: findByTypeAndEntityId
                }
            }
        >
            {children}
        </context.Provider>)
}

export const useUserContext = () => useContext(context)