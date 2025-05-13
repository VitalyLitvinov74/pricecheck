import {metadata} from "../../../layout";

import Form from "../../../../src/pages/product-update/ui/form";
import {loadProduct, loadGeneralProperties} from "../../../../src/shared/api/products-api";

export default async function Page({params}: { id: string }){
    metadata.title= "Обновить"
    const properties = await loadGeneralProperties();

    const product = await loadProduct(params.id);

    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <Form properties={properties} productData={product} action={"update"}/>
                    </div>
                </div>

            </div>
        </div>
    );
}