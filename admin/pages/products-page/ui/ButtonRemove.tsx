import React from "react";

export function ButtonRemove({product}){

    async function remove(product) {
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
        if (status === 204) {
            // updateProducts(
            //     products.filter(function(importedProduct){
            //         return product.id !== importedProduct.id
            //     }))
        }
    }

    return (<>
        <button onClick={() => {
            remove(product)
        }} className="btn btn-danger-rgba"><i
            className="feather icon-trash"></i></button>
    </>)
}