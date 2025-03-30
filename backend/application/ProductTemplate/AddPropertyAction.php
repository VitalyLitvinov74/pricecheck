<?php

namespace app\application\ProductTemplate;

use app\domain\ProductTemplate\Models\Property;
use app\domain\ProductTemplate\Models\ValueType;
use app\infrastructure\repositories\ProductTemplate\ProductTemplateRepository;

class AddPropertyAction
{
    public function __construct(private ProductTemplateRepository $repository = new ProductTemplateRepository())
    {
    }

    public function __invoke(string $name, ValueType $type): int
    {
        $template = $this->repository->find();
        $template->add(
            new Property($name, $type)
        );
        return $this->repository->save($template);
    }
}