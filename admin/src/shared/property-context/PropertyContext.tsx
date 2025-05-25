import {createContext, useContext} from "react";

const Context = createContext<{
    
}>({} as any)

export function PropertyContext({children, property}){
    return <Context.Provider value={{
        property
    }}>
        {children}
    </Context.Provider>
}

export const usePropertyContext = () => useContext(Context)