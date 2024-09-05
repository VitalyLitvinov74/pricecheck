export default async function Page() {
    let url = `${process.env.URL}/product/all-properties-list`;
    let data = await fetch(url)
    let posts = await data.json()
    return (
        <ul>
            {posts.map((post) => (
                <li key={post.id}>{post.name}</li>
            ))}
        </ul>
    )
}