import revalidateProductList from "../../../../../app/actions/RevalidateProductList";

export function SaveProductButton(){
    function save(){
        let status = 204;
        const url = `http://api.pricecheck.my:82/product/create}`;
        await fetch(url, {
            body: JSON.stringify(dataForBackend()),
            headers: {
                'content-type': "application/json"
            },
            method: "post",
        }).then(function (result) {
            status = result.status;
        })
        if (status === 204) {
            await revalidateProductList()
            router.push("/products")
        }
    }
    return (<>
        <button
            type="button"
            onClick={save}
            className="btn btn-success mr-2">
            <i className="feather icon-save mr-2"></i>
            Сохранить
        </button>
    </>)
}