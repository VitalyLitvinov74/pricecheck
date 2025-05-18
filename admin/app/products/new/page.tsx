import {metadata} from "../../layout";
import {loadGeneralProperties} from "../../../src/shared/api/products-api";
import {Form} from "../../../src/pages/product-create/ui/Form";
import {ProductPayload} from "../../../src/shared/types";
import {ProductContext} from "../../../src/shared/product-page-context/ProductContext";

export default async function newProduct() {
    metadata.title = "Создать товар"
    const propertiesPayload = await loadGeneralProperties();
    const productPayload: ProductPayload = {productAttributes: []};
    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <ProductContext productPayload={productPayload}>
                            <Form
                                propertiesPayload={propertiesPayload}
                            />
                        </ProductContext>
                    </div>
                </div>

            </div>
        </div>
    );
}