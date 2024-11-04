<?php

namespace app\domain\Property\Models;

use app\domain\Type;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property as Prop;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel]
class Property
{
    #[Prop(
        defaultMapWith: 'id'
    )]
    private int|null $id = null;

    #[Prop(
        defaultMapWith: 'type',
        typecast: Type::class
    )]
    private Type $type;


    #[HasManyModels(
        nestedType: Setting::class,
        mapWithArrayKey: 'settings',
        mapWithObjectKey: 'settingsSnapshots'
    )]
    /** @var ArrayCollection<int, Setting> $settings */
    private ArrayCollection $settings;

    public function __construct(
        #[Prop(mapWithArrayKey: 'name')]
        private string $name,
        string         $type
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

    public function hasName(string $name): bool
    {
        return strtolower($this->name) === strtolower($name);
    }

    public function hasId(int $id): bool
    {
        return $id === $this->id;
    }

    public function attach(Setting $setting): void
    {
        $setting = $this->settings->findFirst(
            function (Setting $existedSetting) use ($setting) {
                return $setting->compareWith($existedSetting);
            }
        );
        if($setting !== null){
            return;
        }
        $this->settings->add($setting);
    }
}