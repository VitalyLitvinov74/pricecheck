"use client"

import {createContext, useContext, useState} from "react";
import {EntityType, SettingType, UserSetting} from "../types";
import {uniqNumber} from "../helpers";

const context = createContext<{
    settingsBy: (EntityType: EntityType, entityId: number) => UserSetting[],
    findSettingsByType: (settingType: SettingType) => UserSetting[],
    settingLabelByType: (settingType: SettingType) => string,
    setSetting: (setting: UserSetting) => void
}>({} as any);

export function UserContext({children, settingsPayload, defaultSettingsPayload}: {
    children: React.ReactNode,
    settingsPayload: UserSetting[],
    defaultSettingsPayload: UserSetting[],
}) {
    const [settings, setSettings] = useState(
        hydrateDefaultSettings(
            settingsPayload,
            defaultSettingsPayload
        )
    )

    function findByTypeAndEntityId(entityType: EntityType, entityId: number): UserSetting[] {
        return settings.filter(function (item) {
            return item.entity_type === entityType && item.entity_id === entityId
        })
    }

    /**
     * Насыщаяет настройки дейфолтными настройками если отсутствует ключеваое свойство.
     * @param inputtedSettings
     * @param defaultSettings
     */
    function hydrateDefaultSettings(
        inputtedSettings: UserSetting[],
        defaultSettings: UserSetting[]
    ): UserSetting[] {
        defaultSettings.forEach(function (item) {
            const filteredSettings = inputtedSettings.find(function (item2) {
                return item2.type === item.type
            });
            console.log(filteredSettings)
            if (!filteredSettings) {
                item.id = uniqNumber()
                inputtedSettings.push(item)
            }
        })

        return inputtedSettings;
    }

    function settingLabelByType(settingType: SettingType) {
        switch (settingType) {
            case SettingType.ColumnNumber:
                return "Номер колонки"
            case SettingType.IsEnabled:
                return "Включено"
        }
    }

    function setSetting(setting: UserSetting) {
        setSettings(function (prevState) {
            return prevState.map(function (item) {
                if (item.type === setting.type && item.entity_id === setting.entity_id) {
                    return setting
                }
                return item
            })
        })
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
                    settingLabelByType: settingLabelByType,
                    setSetting
                }
            }
        >
            {children}
        </context.Provider>)
}

export const useUserContext = () => useContext(context)