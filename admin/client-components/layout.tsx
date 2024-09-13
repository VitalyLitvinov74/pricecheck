'use client'
import React, {createContext, useCallback, useContext, useEffect, useReducer, useState} from "react";
import Breadcrumbs from "./breadcrumbs/Breadcrumbs";

export const ClientContext = createContext({});

export function updateState(handler, newData){
    useEffect(
        function () {
            handler(newData)
        },
        []
    )
}
export default function Layout({children, serverMetadata}){
    {
        const [metadata, setMetadata] = useState(serverMetadata);

        return <ClientContext.Provider value={{
            metadata: metadata,
            setMetadata: setMetadata
        }}>
            <Breadcrumbs/>
            {children}
        </ClientContext.Provider>
    }
}