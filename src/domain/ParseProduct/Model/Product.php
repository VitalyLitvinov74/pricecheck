<?php

class Product
{

    public function __construct(
        private string $articular,
        private string $name,
        private string $description = '',
        private string $brand,
        private string $stockName = '',
        private int    $howManyInStock,
        private int    $price,
        private int    $deliveryTimeInDay,
        private bool   $isSale = false,
        private int    $minimumOrder = 0,
        private string $catalogNumber = '',
        private string $physicalCharacteristics = '',
        private int    $shipmentFrequency = 1,
        private string $oemNumber = '',
        private string $appliedWith = ''
    )
    {
    }
}