<?php

namespace app\application\Property;

use app\infrastructure\repositories\property\PropertyRepository;

class AttachSettingsToProperty
{
    public function __construct(private PropertyRepository $repository = new PropertyRepository())
    {
    }

    public function __invoke(int $propertyId, array $settings): void
    {
        $property = $this->repository->findBy($propertyId);
        foreach ($settings as $setting){

        }
    }
}