<?php

namespace app\forms;

enum Scenarious: string
{
    case CreateProduct = 'createProduct';
    case CreateParsingSchema = 'createParsingSchema';
    case Default = 'default';
    case RemoveProperty = 'removeProperty';
}