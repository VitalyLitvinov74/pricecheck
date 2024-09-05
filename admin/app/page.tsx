export default async function Page() {
    let url = 'http://api.pricecheck.my:82/product/all-properties-list';
    // const https = require('https');
    // const httpsAgent = new https.Agent({
    //     rejectUnauthorized: false,
    // });
    // let data = await fetch(url, {
    //     method: 'get',
    //     // agent: httpsAgent,
    //     cache: 'no-store'
    // });


    let data = await fetch(url)
    let posts = await data.json()
    return (
        <ul>
            {posts.map((post) => (
                <li key={post.id}>{post.title}</li>
            ))}
        </ul>
    )
}