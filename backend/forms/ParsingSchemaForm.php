<?php

namespace app\forms;

use vloop\Yii2\Validators\ArrayValidator;
use vloop\Yii2\Validators\CustomEachValidator;
use yii\base\Model;

class ParsingSchemaForm extends Model
{
    public $name;

    public $maps;
    public $productTypeId;

    /** @var BunchOfPropertiesForm[] */
    public $mapCollection;

    public function rules(): array
    {
        return [
            [['name', 'maps', 'productTypeId'], 'required'],
            ['productTypeId', 'integer'],
            ['maps', 'validateMaps'],
            ['mapCollection', 'safe']
        ];
    }

    public function validateMaps(): void
    {
        $loadedBunches = [];
        foreach ($this->maps as $bunch) {
            $bunchForm = new BunchOfPropertiesForm();
            $validated = $bunchForm->load($bunch) and $bunchForm->validate();
            if ($validated) {
                $loadedBunches[] = $bunchForm;
                continue;
            }

        }
        $this->mapCollection = $loadedBunches;
    }

    public function formName(): string
    {
        return '';
    }
}