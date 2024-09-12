'use client'

import {createContext, useCallback, useContext, useState} from "react";
import Breadcrumbs from "./product/properties/button-component";
import {metadata} from "./layout";

export const ClientContext = createContext({});

export default function NestedClientPage({children}){
    {
        const [buttonFunction, setButtonFunction] = useState()
        return <ClientContext.Provider value={{buttonFunction, setButtonFunction}}>
            <Breadcrumbs title='nnn'/>
            {children}
        </ClientContext.Provider>
    }
}