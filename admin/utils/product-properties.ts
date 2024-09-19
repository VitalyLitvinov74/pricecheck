import {cache} from 'react'
import 'server-only'
export const revalidate = false
export const preload = function (){
    return void loadProperties;
}
/** @type {Array.<object>}*/
export const loadProperties = cache (async function(){
    const url = `${process.env.URL}/product/all-properties-list`;
    const data = await fetch(url, {
        next: {
            revalidate: false
        }
    })
    return data.json();
})

export const availableProps = cache(
    async function(){
        const url = `${process.env.URL}/product-property/available`;
        const data = await fetch(url, {
            next: {
                revalidate: false
            }
        })
        return data.json();
    }
)