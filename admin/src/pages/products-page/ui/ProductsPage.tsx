"use client"

import Toolbar from "./toolbar";
import Link from "next/link";
import React, {useState} from "react";
import {ButtonRemove} from "./ButtonRemove";
import {useUserContext} from "../../../shared/user-context/UserContext";
import {EntityType, ProductPropertyPayload, SettingType} from "../../../shared/types";
import {ProductProperty} from "../../../models/ProductProperty";
import {UserSetting} from "../../../models/UserSetting";

export default function ProductsPage({products, generalPropertiesPayload}: {
    products: any[],
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

    function renderAttributeColumn(product, propertyId) {

        const attribute = product.productAttributes.find(function (attribute) {
            return attribute.property_id == propertyId;
        });
        if (attribute) {
            return (
                <td>
                    {attribute.value}
                </td>
            );
        }
        return (<td> - </td>);
    }

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
                                        {/*{products.map(function (product) {*/}
                                        {/*    return (*/}
                                        {/*        <tr key={product.id}>*/}
                                        {/*            <td scope="row">#{product.id}</td>*/}
                                        {/*            {tableSettings.map(function (setting) {*/}
                                        {/*                return renderAttributeColumn(product, setting.property_id)*/}
                                        {/*            })}*/}
                                        {/*            <td>*/}
                                        {/*                <div className="button-list">*/}
                                        {/*                    <Link className="btn btn-success-rgba"*/}
                                        {/*                          href={`/products/update/${product.id}`}*/}
                                        {/*                    >*/}
                                        {/*                        <i className="feather icon-edit-2"></i>*/}
                                        {/*                    </Link>*/}
                                        {/*                    <ButtonRemove product={product}/>*/}
                                        {/*                </div>*/}
                                        {/*            </td>*/}
                                        {/*        </tr>*/}
                                        {/*    )*/}
                                        {/*})}*/}
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