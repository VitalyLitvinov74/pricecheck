'use client'

import {createContext, useContext, useState} from "react";
import Breadcrumbs from "./product/properties/button-component";
import {metadata} from "./layout";

export class ClientContext {
    static buttonFunction: any
}

export default function NestedClientPage({children}){
    {
        return <>
            <Breadcrumbs title='nnn' />
            {children}
        </>
    }
}