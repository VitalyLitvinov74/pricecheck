import {createContext, useContext} from "react";

const PageContext = createContext<{
    upsertProduct: (product) => void
}>();

export default function ProductPageContext({children}){
    function reload(){}

    return (<>
        <PageContext.Provider value={}>
            {children}
        </PageContext.Provider>
    </>)
}

export const useProductPageContext = () => useContext(PageContext)