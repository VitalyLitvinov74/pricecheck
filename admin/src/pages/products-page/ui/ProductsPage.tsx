"use client"

import Toolbar from "./toolbar";
import React, {createContext, Fragment, useContext} from "react";
import {useUserContext} from "../../../shared/user-context/UserContext";
import {Attribute, EntityType, Product, Property, SettingType, UserSetting} from "../../../shared/types";
import {ProductItem} from "./ProductItem";

const Context = createContext<{
    getProductById: (id: number) => Product & { attributes: Attribute[] },
    getHeaderSortedAvailableProperties: () => Property[],
}>({} as any);

export function ProductsPage({products, properties}: {
    products: (Product & { productAttributes: Attribute[] })[],
    properties: Property[],
}) {
    const user = useUserContext();

    function productById(id: number): Product & { attributes: Attribute[] } {
        const product = products.find(function (product) {
            return product.id === id
        })
        if (product) {
            return {
                ...product,
                attributes: product.productAttributes
            } as Product & { attributes: Attribute[] }
        }
        return {} as Product & { attributes: Attribute[] }
    }

    function getHeaderSortedAvailableProperties(): Property[] {
        return properties
            .filter(function (property) {
                //отображаем только включенные свойства
                return user
                    .settingsBy(EntityType.Property, property.id)
                    .filter(function (setting: UserSetting) {
                        return setting.type === SettingType.IsEnabled && setting.int_value == 1
                    }).length != 0
            })
            .sort(function (item1, item2) {
                //сортировка по номеру колонки
                const firstColumnNum =
                    user
                        .settingsBy(EntityType.Property, item1.id)
                        .find(function (setting: UserSetting) {
                            return setting.type === SettingType.ColumnNumber
                        })
                        ?.int_value
                const secondColumnNum =
                    user.settingsBy(EntityType.Property, item2.id)
                        .find(function (setting: UserSetting) {
                            return setting.type === SettingType.ColumnNumber
                        })
                        ?.int_value
                return firstColumnNum - secondColumnNum;
            })
    }

    return (
        <>
            <Context.Provider value={{
                getHeaderSortedAvailableProperties: getHeaderSortedAvailableProperties,
                getProductById: productById,
            }}>
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
                                                {getHeaderSortedAvailableProperties().map(function (property) {
                                                    return (
                                                        <th key={property.id}>
                                                            {property.name}
                                                        </th>
                                                    );
                                                })}
                                                <th>Действия</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {products.map(function (product) {
                                                return (
                                                    <Fragment key={product.id}>
                                                        <ProductItem
                                                            productId={product.id}
                                                        />
                                                    </Fragment>
                                                )
                                            })}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Context.Provider>
        </>
    )
}

export const useProductsPageContext = () => useContext(Context)
