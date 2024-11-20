"use client"
import React, {useState} from "react";
import revalidateProductList from "../actions/RevalidateProductList";
import Link from "next/link";
import {tableSetting} from "../../utils/products";


export default function Table({importedProducts, tableSettings}:{
    importedProducts: object,
    tableSettings: tableSetting[]
}) {
    const [products, updateProducts] = useState(importedProducts)
    async function remove(product){
        let status = 204;
        const url = `http://api.pricecheck.my:82/product/remove`;
        await fetch(url, {
            body: JSON.stringify(product),
            headers: {
                'content-type': "application/json"
            },
            method: "delete",
        }).then(function (result) {
            status = result.status;
        })
        if(status === 204){
            updateProducts(
                products.filter(function(importedProduct){
                return product.id !== importedProduct.id
            }))
        }
    }

    function renderAttributeCol(product, propertyId){

        const attribute = product.productAttributes.find(function(attribute){
            return attribute.property_id == propertyId;
        });
        if(attribute){
            return (
                <td>
                    {attribute.value}
                </td>
            );
        }
        return (<td> - </td>);
    }

    console.log(importedProducts)
    return (
        <>
            <div className="table-responsive">
                <table className="table table-borderless">
                    <thead>
                    <tr>
                        <th>ID</th>
                        {tableSettings.map(function(setting){
                            return (
                                <th>{setting.property.name}</th>
                            );
                        })}
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    {products.map(function(product){
                        return (
                            <tr key={product.id}>
                                <td scope="row">#{product.id}</td>
                                {tableSettings.map(function(setting){
                                    return renderAttributeCol(product, setting.property_id)
                                })}
                                <td>
                                    <div className="button-list">
                                        <Link className="btn btn-success-rgba"
                                              href={`/products/update/${product.id}`}
                                        >
                                            <i className="feather icon-edit-2"></i>
                                        </Link>
                                        <button onClick={()=>{remove(product)}} className="btn btn-danger-rgba"><i
                                            className="feather icon-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        )
                    })}
                    </tbody>
                </table>
            </div>
        </>
    )
}