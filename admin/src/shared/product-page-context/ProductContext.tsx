"use client"
import {createContext, useContext, useState} from "react";
import {Product} from "../../models/Product";
import {ProductPayload} from "../types";

const PageContext = createContext<{
    product: Product,
    setProduct: (product: Product) => void
}>();

export function ProductContext({children, productPayload}: {
    children: React.ReactNode,
    productPayload: ProductPayload
}) {
    const [product, setProduct] = useState(new Product(productPayload));

    return (<>
        <PageContext.Provider value={{
            product: product,
            setProduct: setProduct
        }}>
            {children}
        </PageContext.Provider>
    </>)
}

export const useProductContext = () => useContext(PageContext)