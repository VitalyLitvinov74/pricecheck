<?php

namespace app\infrastructure\libs;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Yii;
use yii\base\Model;

/**
 * формирует массив по стандарту jsonApi
 */
class JsonApi
{
    private ArrayCollection $errors;
    private int|string $code = 200;

    private ArrayCollection $fields;

    public function __construct()
    {
        $this->errors = new ArrayCollection();
        $this->fields = new ArrayCollection();
    }

    public function addModelErrors(Model $model): self
    {
        $errors = $model->getErrors();
        foreach ($errors as $title => $nestedErrors) {
            $this->errors->set($title, $nestedErrors);
        }
        return $this;
    }

    public function addError(string|array $detail, string|null $title = null): self
    {
        $error = [
            'detail' => $detail
        ];
        if ($title) {
            $error['title'] = $title;
        }
        $this->errors->add($error);
        return $this;
    }

    public function addException(\Throwable $exception): self
    {
        if ($exception->getCode() < 400) {
            $this->setupCode(500);
        } else {
            $this->setupCode($exception->getCode());
        }

        $this->addError($exception->getMessage());
        return $this;
    }

    public function setupCode(int|string $code): self
    {
        try {
            Yii::$app->response->setStatusCode($code);
        } catch (Exception $exception) {
            Yii::$app->response->setStatusCode(500);
        }
        return $this;
    }

    public function asArray(): array
    {
        if ($this->errors->isEmpty()) {
            return $this->fields->toArray();
        }
        if($this->code === 200){
            $this->setupCode(422);
        }
        return $this->errors->toArray();
    }

    public function addBody(array|null $body): self
    {
        if ($body === null) {
            return $this;
        }
        foreach ($body as $key => $field) {
            $this->addField($key, $field);
        }
        return $this;
    }

    public function addField(string $key, mixed $value): self
    {
        $this->fields->set($key, $value);
        return $this;
    }
}