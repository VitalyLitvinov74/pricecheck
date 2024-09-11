import {cache} from 'react'
import 'server-only'
export const revalidate = 60
export const preload = function (){
    return void loadProperties;
}
/** @type {Array.<object>}*/
export const loadProperties = cache (async function(){
    const url = `${process.env.URL}/product/all-properties-list`;
    const data = await fetch(url)
    return data.json();
})