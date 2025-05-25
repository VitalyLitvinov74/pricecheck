import revalidateProductList from "../../../../../app/actions/RevalidateProductList";
import {Attribute, FormAction} from "../../../../shared/types";
import {createProduct} from "../../api";
import {router} from "next/client";

export function SaveProductButton({formAction, attributes}: {
    formAction: FormAction,
    attributes: Attribute[]
}){


    async function save(){
        try {
            if(formAction === FormAction.Create){
                if(attributes.length === 0) return;
                await createProduct(attributes)
            }
            await revalidateProductList()
            await router.push("/products")
        }catch (e) {
            console.log(e)
        }
    }
    return (<>
        <button
            type="button"
            onClick={save}
            disabled={attributes.length === 0}
            className="btn btn-success mr-2">
            <i className="feather icon-save mr-2"></i>
            Сохранить
        </button>
    </>)
}