export const preload = function (){
    return void loadProperties;
}
/** @type {Array.<object>}*/


export const availableTypes = async function(){
    const url = `${process.env.URL}/properties/available-types`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return data.json();
}