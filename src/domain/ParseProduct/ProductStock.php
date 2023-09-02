<?php

namespace app\domain\ParseProduct;

use app\domain\ParseProduct\Model\Document;
use app\domain\ParseProduct\Model\ParsingSchema;
use app\domain\ParseProduct\Model\Product;
use Doctrine\Common\Collections\ArrayCollection;
use yii\db\Exception;

class ProductStock
{
    private string $version;

    private ArrayCollection $parsedProducts;

    public function __construct(private ArrayCollection $parsingSchemas)
    {
        $this->version = uniqid();
    }

    /**
     * @param string $documentPath
     * @param int $schemaId
     * @return void
     * @throws Exception
     */
    public function parseFromDocument(string $documentPath, int $schemaId): void
    {
        $document = new Document(
            $documentPath,
            $this->parsingSchemaById(
                $schemaId
            )
        );
        $document
            ->parse()
            ->map(
                function (int $key, Product $product) {
                    $this->parsedProducts->add($product);
                }
            );
    }

    public function parseFromApi(string $apiClassName): void
    {

    }

    public function addSchema(ParsingSchema $parsingSchema): void
    {
        $this->parsingSchemas->add($parsingSchema);
    }

    private function parsingSchemaById(string $id): ParsingSchema
    {
        $schema = $this->parsingSchemas->findFirst(
            function (int $key, ParsingSchema $parsingSchema) use ($id) {
                return $parsingSchema->hasId($id);
            }
        );
        if ($schema === false) {
            throw  new Exception('Схема соотношений не найдена');
        }
        return $schema;
    }
}