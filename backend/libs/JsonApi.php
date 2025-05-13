<?php

namespace app\libs;

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
        $resultErrors = [];
        foreach ($errors as $title => $nestedErrors) {
            $firstKey = array_key_first($nestedErrors);

            //Если это обычная не вложенная ошибка
            if(!is_array($nestedErrors[$firstKey])){
                $resultErrors[$title] = $nestedErrors;
                continue;
            }

            $resultErrors = array_merge(
                $resultErrors,
                $this->flattenErrors(
                    $title,
                    $nestedErrors,
                )
            );
        }

        foreach ($resultErrors as $source => $attributeErrors) {
            foreach ($attributeErrors as $error){
                $this->errors->add([
                    'detail' => $error,
                    'source' => [
                        'pointer' => $source
                    ]
                ]);
            }
        }

        return $this;
    }

    /**
     * @param string $prefix
     * @param array $errors
     * @return void преобразует многомерный массив в ассоциативный с ошибками.
     */
    function flattenErrors(string $prefix, array $errors): array
    {
        $result = [];
        foreach ($errors as $key => $value) {
            if(is_array($value) && $this->isAssociative($value)){
                $result = array_merge(
                    $result,
                    $this->flattenErrors($prefix, $value)
                );
                continue;
            }

            $currentKey = $prefix . '/' . $key;
            $result[$currentKey] = $value;
        }
        return $result;
    }

    private function isAssociative(array $array): bool
    {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
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
        $this->code = $code;
        return $this;
    }

    public function asArray(): array
    {
        if ($this->errors->isEmpty()) {
            return [
                'data' => $this->fields->toArray()
            ];
        }
        if ($this->code === 200) {
            $this->setupCode(422);
        }
        return [
            'errors' => $this->errors->toArray(),
        ];
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