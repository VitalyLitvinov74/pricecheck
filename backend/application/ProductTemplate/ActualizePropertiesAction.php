<?php

namespace app\application\ProductTemplate;

use app\domain\ProductTemplate\Models\Property;
use app\domain\ProductTemplate\Models\ValueType;
use app\repositories\ProductTemplate\ProductTemplateRepository;

class ActualizePropertiesAction
{
    public function __construct(private ProductTemplateRepository $repository = new ProductTemplateRepository())
    {
    }

    public function __invoke(array $propertiesDTOs): int
    {
        $template = $this->repository->find();
        $actualNames = [];
        foreach ($propertiesDTOs as $propertyDTO) {
            $template->add(
                new Property(
                    $propertyDTO->name,
                    ValueType::from($propertyDTO->type)
                )
            );
            $actualNames[] = $propertyDTO->name;
        }
        $template->actualizeProperties($actualNames);
        return $this->repository->save($template);
    }
}