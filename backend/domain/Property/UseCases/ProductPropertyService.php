<?php

namespace app\domain\Property\UseCases;

use app\domain\Property\Models\PropertySettingType;
use app\domain\Property\Models\Setting;
use app\domain\Property\Persistence\PropertyRepository;
use app\forms\ProductPropertyForm;
use app\forms\PropertySettingForm;
use yii\base\Exception;

class ProductPropertyService
{
    public function __construct(
        private PropertyRepository $propertiesRepository = new PropertyRepository()
    )
    {
    }

    /**
     * @param ProductPropertyForm[] $propertiesData
     * @return void - id
     * @throws Exception
     */
    public function push(array $propertiesData): void
    {
        $properties = $this->propertiesRepository->findAll();
        foreach ($propertiesData as $propertyData) {
            $properties->add(
                $propertyData->name,
                $propertyData->type
            );
        }
        $this->propertiesRepository->upsert($properties);
    }

    public function change(int $id, string $newName, string $newType): void
    {
        $properties = $this->propertiesRepository->findAll();
        $properties->change($id, $newName, $newType);
        $this->propertiesRepository->upsert($properties);
    }

    public function remove(int $id): void
    {
        $properties = $this->propertiesRepository->findAll();
        $properties->remove($id);
        $this->propertiesRepository->upsert($properties);
    }

    /**
     * @param PropertySettingForm[] $settings
     * @return void
     */
    public function attachSettings(array $settings): void
    {
        $properties = $this->propertiesRepository->findAll();
        foreach ($settings as $setting) {
            $properties->attach(
                new Setting(
                    $setting->property->id,
                    PropertySettingType::from($setting->settingTypeId)
                )
            );
        }
        $this->propertiesRepository->upsert($properties);
    }

    public function disattachSettung(int $propertyId, int $settingId): void
    {
        $properties = $this->propertiesRepository->findAll();
//        $properties->
    }
}