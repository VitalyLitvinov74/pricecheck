"use client"

import Toolbar from "./toolbar";
import Link from "next/link";
import React from "react";
import ProductSearchWidget from "../../../widgets/product-search/ui/ProductSearch";
import {ButtonRemove} from "./ButtonRemove";

export default function ProductsPage({products, tableSettings}) {
    console.log(products)
    function renderAttributeCol(product, propertyId) {

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
                                    <ProductSearchWidget/>
                                </div>
                                <div className="table-responsive">
                                    <table className="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            {tableSettings.map(function (setting) {
                                                return (
                                                    <th>{setting.property.name}</th>
                                                );
                                            })}
                                            <th>Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {products.map(function (product) {
                                            return (
                                                <tr key={product.id}>
                                                    <td scope="row">#{product.id}</td>
                                                    {tableSettings.map(function (setting) {
                                                        return renderAttributeCol(product, setting.property_id)
                                                    })}
                                                    <td>
                                                        <div className="button-list">
                                                            <Link className="btn btn-success-rgba"
                                                                  href={`/products/update/${product.id}`}
                                                            >
                                                                <i className="feather icon-edit-2"></i>
                                                            </Link>
                                                            <ButtonRemove product={product}/>
                                                        </div>
                                                    </td>
                                                </tr>
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
        </>
    )
}