"use client"

import Toolbar from "./toolbar";
import React, {useState} from "react";
import {useUserContext} from "../../../shared/user-context/UserContext";
import {EntityType, ProductPayload, ProductPropertyPayload, SettingType} from "../../../shared/types";
import {ProductProperty} from "../../../models/ProductProperty";
import {UserSetting} from "../../../models/UserSetting";
import {Product} from "../../../models/Product";
import {ProductItem} from "./ProductItem";

export default function ProductsPage({productsPayload, generalPropertiesPayload}: {
    productsPayload: ProductPayload[],
    generalPropertiesPayload: ProductPropertyPayload[],
}) {
    const user = useUserContext();
    const [properties, setProperties] = useState(
        generalPropertiesPayload
            .map(function (item) {
                return new ProductProperty(
                    {
                        ...item,
                        userSettings: user.findSettingsByTypeAndEntityId(
                            EntityType.ProductProperty,
                            item.id
                        )
                    }
                )
            })
            .filter(function (property) {
                //отображаем только включенные свойства
                const isEnabled = property
                    .userSettings()
                    .find(function (setting: UserSetting) {
                        return setting.is(SettingType.IsEnabled) && setting.value() == 1
                    })
                return isEnabled !== undefined
            })
            .sort(function (item1, item2) {
                //сортировка по номеру колонки
                const firstColumnNum = item1
                    .userSettings()
                    .find(function (setting: UserSetting) {
                        return setting.is(SettingType.ColumnNumber)
                    })
                    ?.value()
                const secondColumnNum = item2
                    .userSettings()
                    .find(function (setting: UserSetting) {
                        return setting.is(SettingType.ColumnNumber)
                    })
                    ?.value()
                return firstColumnNum - secondColumnNum;
            })
    );


    const [products, setProducts] = useState(
            productsPayload.map(function (item) {
                return new Product(item)
            })
        )
    ;

    return (
        <>
            <div className="contentbar">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="card m-b-30">
                            <div className="card-body">

                                <Toolbar/>
                                <div className={"col-lg-12 mt-4 mb-4"}>
                                    {/*<ProductSearchWidget/>*/}
                                </div>
                                <div className="table-responsive">
                                    <table className="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            {properties.map(function (property) {
                                                return (
                                                    <th>{property.name}</th>
                                                );
                                            })}
                                            <th>Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {products.map(function (product) {
                                            return (
                                                <ProductItem
                                                    key={product.id()}
                                                    product={product}
                                                    sortedProperties={properties}
                                                />)
                                        })}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}