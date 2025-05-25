"use client"

import {createContext, useContext, useState} from "react";
import {EntityType, SettingType, UserSetting} from "../types";
import {uniqNumber} from "../helpers";
import {commitUserSettings} from "../../pages/products-table-settings/api/api-products-table-settings";

const context = createContext<{
    settingsBy: (EntityType: EntityType, entityId: number) => UserSetting[],
    findSettingsByType: (settingType: SettingType) => UserSetting[],
    settingLabelByType: (settingType: SettingType) => string,
    setSetting: (setting: UserSetting) => void,
    commitSettings: (settings: UserSetting[]) => void
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
        const result: UserSetting[] = [];
        const map = new Map<number, UserSetting[]>();
        inputtedSettings.forEach(function (userSetting) {
            const userSettings = map.get(userSetting.entity_id);
            if (userSettings) {
                userSettings.push(userSetting)
                map.set(userSetting.entity_id, userSettings);
            } else {
                map.set(userSetting.entity_id, [userSetting]);
            }
        })

        defaultSettings.forEach(function (item1: UserSetting) {
            map.forEach(function (items2: UserSetting[], key: number) {
                const filteredSettings = items2.find(function (item2) {
                    return item2.type === item1.type
                });
                if (!filteredSettings) {
                    item1.id = uniqNumber()
                    result.push({
                        ...item1,
                        ...{
                            entity_id: key
                        }
                    })
                }
            })
        })

        return [...inputtedSettings, ...result];
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

    async function commitSettings(settings: UserSetting[]): void{
        const result = await commitUserSettings(settings);
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
                    setSetting,
                    commitSettings
                }
            }
        >
            {children}
        </context.Provider>)
}

export const useUserContext = () => useContext(context)