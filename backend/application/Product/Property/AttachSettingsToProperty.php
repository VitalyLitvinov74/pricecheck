<?php

namespace app\application\Product\Property;

use app\repositories\property\PropertyRepository;

class AttachSettingsToProperty
{
    public function __construct(private PropertyRepository $repository = new PropertyRepository())
    {
    }

    /**
     * @param int $propertyId
     * @param SettingDTO[] $settings
     * @return void
     */
    public function __invoke(int $propertyId, array $settings): void
    {
        $property = $this->repository->findBy($propertyId);

    }
}