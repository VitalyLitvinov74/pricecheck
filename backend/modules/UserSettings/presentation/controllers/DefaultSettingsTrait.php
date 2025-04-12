<?php

namespace app\modules\UserSettings\presentation\controllers;

use app\modules\UserSettings\domain\Models\EntityType;
use app\modules\UserSettings\domain\Models\SettingType;

trait DefaultSettingsTrait
{
    private function addDefaultSettingsToProductProperties(array $properties): array
    {
        foreach ($properties as $key=>$property) {
            $columnNum = [
                'id' => null,
                'user_id' => 1,
                'type' => SettingType::ColumnNumber->value,
                'value' => 1,
                'entity_id' => $property['id'],
                'entity_type' => EntityType::ProductProperty->value
            ];
            $columnIsEnabled =  [
                'id' => null,
                'user_id' => 1,
                'type' => SettingType::IsEnabled->value,
                'value' => 1,
                'entity_id' => $property['id'],
                'entity_type' => EntityType::ProductProperty->value
            ];
            if ($property['userSettings'] === []) {
                $properties[$key]['userSettings'] = [$columnIsEnabled, $columnNum];
                continue;
            }
            foreach ($property['userSettings'] as $userSetting) {
                if ($userSetting['type'] === SettingType::ColumnNumber->value) {
                    $properties[$key]['userSettings'][] = $columnNum;
                    continue;
                }
                if ($userSetting['type'] === SettingType::IsEnabled->value) {
                    $properties[$key]['userSettings'][] = $columnIsEnabled;
                    continue;
                }
            }
        }
        return $properties;
    }
}