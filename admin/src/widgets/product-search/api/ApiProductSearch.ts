export async function searchProducts(searchQuery?: string): Promise<void> {
    const result = await fetch(`${process.env.apiUrl}/product/index?${searchQuery}`, {
        method: "get",
    })

    const data = await result.json()
    if (result.status < 300 && result.status > 199) {
        return data;
    }
    throw new Error(data);
}