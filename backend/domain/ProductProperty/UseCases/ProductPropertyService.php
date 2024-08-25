<?php

namespace app\domain\ProductProperty\UseCases;

use app\domain\ProductProperty\Persistence\PropertyRepository;
use app\forms\ProductPropertyForm;

class ProductPropertyService
{
    public function __construct(
        private PropertyRepository $propertiesRepository = new PropertyRepository()
    ) {
    }

    /**
     * @param ProductPropertyForm[] $propertiesData
     * @return void - id
     * @throws \yii\base\Exception
     */
    public function push(array $propertiesData): void
    {
        $properties = $this->propertiesRepository->findAll();
        foreach ($propertiesData as $propertyData){
            $properties->add(
                $propertyData->name,
                $propertyData->type
            );
        }
        $this->propertiesRepository->merge($properties);
    }

    public function change(): void
    {

    }
}