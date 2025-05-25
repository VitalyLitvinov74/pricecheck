"use client"

import {createContext, useContext, useState} from "react";
import {EntityType, UserSettingPayload} from "../types";

const context = createContext<{
    findSettingsByTypeAndEntityId: (EntityType: EntityType, entityId: number) => UserSetting[],
}>({
    findSettingsByTypeAndEntityId: () => [],
});

export function UserContext({children, settingsPayload, defaultSettingsPayload}: {
    children: React.ReactNode,
    settingsPayload: UserSettingPayload[],
    defaultSettingsPayload: UserSettingPayload[],
}) {
    const [settings, setSettings] = useState(
        settingsPayload.map(function (item) {
            return new UserSetting(item)
        })
    )

    const [defaultSettings, setDefaultSettings] = useState(
        defaultSettingsPayload.map(function (item) {
            return new UserSetting(item)
        })
    )

    function findByTypeAndEntityId(entityType: EntityType, entityId: number): UserSetting[] {
        const filteredSettings = settings.filter(function (item) {
            return item.entityType === entityType && item.entityId === entityId
        })

        return hydrateDefaultSettings(filteredSettings)
    }

    /**
     * Насыщаяет настройки дейфолтными настройками если отсутствует ключеваое свойство.
     * @param filteredSettings
     */
    function hydrateDefaultSettings(filteredSettings: UserSetting[]): UserSetting[] {
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
                    findSettingsByTypeAndEntityId: findByTypeAndEntityId
                }
            }
        >
            {children}
        </context.Provider>)
}

export const useUserContext = () => useContext(context)