import {metadata} from "../../../layout";
import {loadProduct, loadGeneralProperties} from "../../../../src/shared/api/products-api";
import {Form} from "../../../../src/pages/product-create/ui/Form";
import {ProductContext} from "../../../../src/shared/product-page-context/ProductContext";


export default async function Page({params}: { id: string }){
    metadata.title= "Обновить"
    const properties = await loadGeneralProperties();
    const productPayload = await loadProduct(params.id);

    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <Form
                            propertiesPayload={properties}
                            productPayload={productPayload}
                        />
                    </div>
                </div>

            </div>
        </div>
    );
}