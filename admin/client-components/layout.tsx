'use client'
import {createContext, useCallback, useContext, useState} from "react";

export const ClientContext = createContext({});

export default function Layout({children}){
    {
        return <ClientContext.Provider value={{}}>
            {children}
        </ClientContext.Provider>
    }
}