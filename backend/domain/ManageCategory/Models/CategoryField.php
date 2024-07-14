<?php

namespace app\domain\ManageCategory\Models;

use app\domain\ManageCategory\Models\FieldState;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;

#[DomainModel]
class CategoryField
{
    public function __construct(
        #[Property(mapWithArrayKey: 'name')]
        private string $name,
        #[Property(mapWithArrayKey: 'type')]
        private string $type,
        #[Property(mapWithArrayKey: 'state')]
        private FieldState $state = FieldState::On
    ) {
    }

    public function hasName(string $name): bool
    {
        return $this->name === $name;
    }

    public function switch(): void
    {
        if ($this->state === FieldState::On) {
            $this->state = FieldState::Off;
            return;
        }
        $this->state = FieldState::On;
    }
}