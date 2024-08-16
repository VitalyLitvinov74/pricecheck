<?php

namespace app\domain\ManageCategory\Models;

use app\domain\ManageCategory\Persistence\Snapshots\FieldSnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;

#[DomainModel(mapWith: FieldSnapshot::class)]
class CategoryField
{
    public function __construct(
        #[Property(defaultMapWith: 'name')]                               /** @see FieldSnapshot::$name */
        private string $name,
        #[Property(defaultMapWith: 'type')]                               /** @see FieldSnapshot::$type */
        private string $type,
        #[Property(defaultMapWith: 'state', typecast: FieldState::class)] /** @see FieldSnapshot::$state */
        private FieldState $state = FieldState::On
    )
    {
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