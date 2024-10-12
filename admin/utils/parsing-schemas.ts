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