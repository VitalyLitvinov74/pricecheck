<?php

namespace app\domain\ParseDocument\Models;

use app\domain\ParseDocument\Snapshots\ProductSnapshot;

class Product
{
    public function __construct(
        private string $nomenclature, //номенклатура
        private string $vendorCode, //артикул
        private string $brand,
        private string $name,
        private string $description,
        private float  $price,
        private int    $minimumOrderCount, //минимальный заказ
        private int    $frequencyOfShipment, //кратность открузки
        private int    $deliveryDays, //время доставки (во днях)
        private string $stockName,//имя склада, где хранится товар
        private int $availableCount,
        private string $physCharacteristic,
        private string $dimensionOfCharacteristic,
    )
    {
    }

    public function makeSnapshot(): ProductSnapshot
    {

    }
}