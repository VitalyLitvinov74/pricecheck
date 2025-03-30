<?php

namespace app\domain\Product\SubDomains\Property\UseCases;

use app\domain\Product\SubDomains\Property\Models\PropertySettingType;
use app\domain\Product\SubDomains\Property\Models\Setting;
use app\domain\Product\SubDomains\Property\Property;
use app\domain\Type;
use app\modules\Property\Domain\Persistence\PropertyRepository;
use app\presentation\forms\ProductPropertyForm;
use app\presentation\forms\PropertySettingForm;
use yii\base\Exception;

class ProductPropertyService
{
    public function __construct(
        private PropertyRepository $repository = new PropertyRepository()
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
        $properties = $this->repository->findAll();
        $createdProperties = [];
        foreach ($propertiesData as $propertyData) {
            $exist = false;
            foreach ($properties as $property){
                if($property->hasName($propertyData->name)){
                    $exist = true;
                    break;
                }
            }
            if(!$exist){
                $createdProperties[] = new Property(
                    $propertyData->name,
                    $propertyData->type
                );
            }
        }
        $this->repository->saveAll($createdProperties);
    }

    public function change(int $id, string $newName, string $newType): void
    {
        $property = $this->repository->find($id);
        $property->rename($newName);
        $property->change(Type::from($newType));
        $this->repository->saveAll([$property]);
    }

    public function remove(int $id): void
    {
        $this->repository->remove($id);
    }

    /**
     * @param PropertySettingForm[] $settings
     * @return void
     */
    public function attachSettings(array $settings): void
    {
        $properties = $this->repository->findAll();
        foreach ($settings as $setting) {
            foreach ($properties as $property){
                if(!$property->hasId($setting->property->id)){
                    continue;
                }
                $property->attach(
                    new Setting(
                        $setting->property->id,
                        PropertySettingType::from($setting->settingTypeId)
                    )
                );
            }
        }
        $this->repository->saveAll($properties);
    }

    public function disAttachSetting(int $propertyId, int $settingTypeId): void
    {
        $property = $this->repository->find($propertyId);
        $property->disAttach(
            PropertySettingType::from($settingTypeId)
        );
        $this->repository->saveAll([$property]);
    }
}