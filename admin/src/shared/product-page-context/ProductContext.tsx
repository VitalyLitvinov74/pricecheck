"use client"
import {createContext, useContext, useState} from "react";
import {ProductLibrary} from "../../models/ProductLibrary";
import {ProductPayload} from "../types";

const PageContext = createContext<{
    product: ProductLibrary,
    setProduct: (product: ProductLibrary) => void
}>();

export function ProductContext({children, productPayload}: {
    children: React.ReactNode,
    productPayload: ProductPayload
}) {
    const [product, setProduct] = useState(new ProductLibrary(productPayload));

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