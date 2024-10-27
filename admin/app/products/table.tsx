"use client"
import React, {useState} from "react";
import revalidateProductList from "../actions/RevalidateProductList";

export default function Table({importedProducts}) {

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
    return (
        <>
            <div className="table-responsive">
                <table className="table table-borderless">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    {products.map(function(product){
                        return (
                            <tr key={product.id}>
                                <th scope="row">#{product.id}</th>
                                <td>
                                    <div className="button-list">
                                        <button className="btn btn-success-rgba"><i
                                            className="feather icon-edit-2"></i></button>
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