<?php

namespace app\domain\ProductProperty\Models;

use app\domain\Type;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property as Prop;
use MongoDB\BSON\ObjectId;

#[DomainModel]
class Property
{
    #[Prop(
        mapWithArrayKey: '_id'
    )]
    private ObjectId $id; //автоинкремент

    #[Prop(
        mapWithArrayKey: 'type',
        typecast: Type::class
    )]
    private Type $type;

    public function __construct(
        #[Prop(mapWithArrayKey: 'name')]
        private string $name,
        string $type
    )
    {
        $this->type = Type::from($type);
        $this->id = new ObjectId();
    }

    public function change(Type $newType): void
    {
        $this->type = $newType;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function hasName(string $name): bool
    {
        return strtolower($this->name) === strtolower($name);
    }
}