import revalidateProductList from "../../../../../app/actions/RevalidateProductList";
import {Attribute, FormAction} from "../../../../shared/types";
import {createProduct} from "../../api";

export function SaveProductButton({formAction, attributes}: {
    formAction: FormAction,
    attributes: Attribute[]
}){


    async function save(){
        if(formAction === FormAction.Create){
            await createProduct(attributes)
        }
        // let status = 204;
        //
        // await fetch(url, {
        //     body: JSON.stringify(dataForBackend()),
        //     headers: {
        //         'content-type': "application/json"
        //     },
        //     method: "post",
        // }).then(function (result) {
        //     status = result.status;
        // })
        // if (status === 204) {
        //     await revalidateProductList()
        //     router.push("/products")
        // }
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