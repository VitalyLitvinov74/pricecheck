import {cache} from 'react'
import 'server-only'
export const preload = function (){
    return void loadProperties;
}
/** @type {Array.<object>}*/
export const loadProperties = async function(){
    const url = `${process.env.URL}/product/all-properties-list`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return data.json();
}

export const availableProps = async function(){
    const url = `${process.env.URL}/product-property/available`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return data.json();
}