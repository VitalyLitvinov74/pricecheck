<?php

namespace app\domain\Product\SubDomains\Property;

use app\domain\Product\SubDomains\Property\Models\Setting;
use app\domain\Type;
use Doctrine\Common\Collections\ArrayCollection;

class Property
{
    private int $id;

    private Type $type;

    /** @var ArrayCollection<int, Setting> $settings */
    private ArrayCollection $settings;

    public function __construct(
        private string $name,
        string $type
    )
    {
        $this->type = Type::from($type);
        $this->settings = new ArrayCollection();
    }

    public function change(Type $newType): void
    {
        $this->type = $newType;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }
}