export const loadProducts = async function(){
    const url = `${process.env.URL}/product/index`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return data.json();
}