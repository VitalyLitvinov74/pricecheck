<?php

namespace app\domain\Enum;

enum ProductFields
{
    case nomenclature; //номенклатура
    case vendorCode; //артикул
    case brand;
    case name;
    case description;
    case price;
    case minimumOrderCount; //минимальный заказ
    case frequencyOfShipment; //кратность открузки
    case deliveryDays; //время доставки (во днях)
    case stockName;//имя склада, где хранится товар
    case availableCount;
    case physCharacteristic;
    case dimensionOfCharacteristic;
}