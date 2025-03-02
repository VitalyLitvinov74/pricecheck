<?php

namespace app\presentation\forms;

abstract class Scenarious
{
    public const CreateProduct = 'createProduct';
    public const RemoveProduct = 'removeProduct';
    public const UpdateProduct = 'updateProduct';
    public const CreateParsingSchema = 'createParsingSchema';
    public const UpdateParsingSchema = 'updateParsingSchema';
    public const Default = 'default';
    public const RemoveProperty = 'removeProperty';
    const UpdateProductProperty = 'updateProductProperty';
    const ChangeProductListSettings = 'changeProductListSettings';
    const DisAttachSetting = 'disAttachSetting';
}