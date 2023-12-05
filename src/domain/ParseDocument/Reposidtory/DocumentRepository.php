<?php

namespace app\domain\ParseDocument\Reposidtory;

use app\domain\ParseDocument\Document;
use app\records\ProductCollection;
use Yii;

class DocumentRepository
{
    public function save(Document $document): void
    {
        $snapshot = $document->makeSnapshot();
        $dataForInsert = [];
        foreach ($snapshot->productsSnapshots as $productSnapshot){
            $dataForInsert[] = [
                'version' => $snapshot->version,
                'mapping_schema'=>$snapshot->mappingSchemaSnapshot
            ];
        }
        Yii::$app->mongodb
            ->createCommand()
            ->batchInsert(
                ProductCollection::collectionName(),
                $dataForInsert,
            );
    }
}