export async function searchProducts(queryString: string): Promise<void> {
    const result = await fetch(`/product/index?queryString=${queryString}`, {
        method: "get",
    })

    const data = await result.json()
    if (result.status < 300 && result.status > 199) {
        return data;
    }
    throw new Error(data);
}