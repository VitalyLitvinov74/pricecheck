<?php

namespace app\modules\Property\Application;

use app\modules\Property\Infrastructure\Repositories\PropertyRepository;

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