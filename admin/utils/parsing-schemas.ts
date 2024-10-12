export const loadParsingSchema = async function (id){
    const url = `${process.env.URL}/parsing-schemas/view?id=${id}`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    if(data.status === 404){
        return null;
    }
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