"use client"

import {createContext, useContext, useState} from "react";
import {EntityType, SettingType, UserSetting} from "../types";

const context = createContext<{
    settingsBy: (EntityType: EntityType, entityId: number) => UserSetting[],
    findSettingsByType: (settingType: SettingType) => UserSetting[],
    settingLabelByType: (settingType: SettingType) => string
}>({
    settingsBy: () => [],
    findSettingsByType: () => [],
    settingLabelByType: () => ""
});

export function UserContext({children, settingsPayload, defaultSettingsPayload}: {
    children: React.ReactNode,
    settingsPayload: UserSetting[],
    defaultSettingsPayload: UserSetting[],
}) {
    const [settings, setSettings] = useState(settingsPayload)

    const [defaultSettings, setDefaultSettings] = useState(defaultSettingsPayload)

    function findByTypeAndEntityId(entityType: EntityType, entityId: number): UserSetting[] {
        const filteredSettings = settings.filter(function (item) {
            return item.entity_type === entityType && item.entity_id === entityId
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

    function settingLabelByType(settingType: SettingType) {
        switch (settingType) {
            case SettingType.ColumnNumber:
                return "Номер колонки"
            case SettingType.IsEnabled:
                return "Включено"
        }
    }

    return (
        <context.Provider
            value={
                {
                    settingsBy: findByTypeAndEntityId,
                    findSettingsByType: function (settingType: SettingType) {
                        return settings.filter(function (item) {
                            return item.type === settingType
                        })
                    },
                    settingLabelByType: settingLabelByType
                }
            }
        >
            {children}
        </context.Provider>)
}

export const useUserContext = () => useContext(context)