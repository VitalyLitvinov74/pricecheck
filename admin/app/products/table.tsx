import {loadProducts} from "../../utils/products";

"use-client"
import React from "react";

export default async function Table({}) {
    let products = [];
    await loadProducts().then(function(data){
        products = data;
    });
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
                                        <a href="#" className="btn btn-success-rgba"><i
                                            className="feather icon-edit-2"></i></a>
                                        <a href="#" className="btn btn-danger-rgba"><i
                                            className="feather icon-trash"></i></a>
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