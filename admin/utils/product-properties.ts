import {cache} from 'react'
import 'server-only'
import {notFound} from "next/navigation";
export const preload = function (){
    return void loadProperties;
}
/** @type {Array.<object>}*/
export const loadProperties = async function(){
    const url = `${process.env.URL}/properties/list`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return data.json();
}

export const availableTypes = async function(){
    const url = `${process.env.URL}/properties/available-types`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return data.json();
}

export const loadParsingSchemas = async function(){
    const url = `${process.env.URL}/parsing-schemas/index`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return data.json();
}