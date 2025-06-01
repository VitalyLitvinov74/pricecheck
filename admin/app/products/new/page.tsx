import {metadata} from "../../layout";
import {loadGeneralProperties} from "../../../src/shared/api/products-api";
import {Form} from "../../../src/pages/product-create/ui/Form";
import {FormAction, Product} from "../../../src/shared/types";
import {getCurrentDateTime, uniqNumber} from "../../../src/shared/helpers";

export default async function newProduct() {
    metadata.title = "Создать товар"
    const properties = await loadGeneralProperties();
    const product: Product = {created_at: getCurrentDateTime(), id: uniqNumber()};
    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <Form
                            attributesPayload={[]}
                            propertiesPayload={properties}
                            productPayload={product}
                            formAction={FormAction.Create}
                        />
                    </div>
                </div>

            </div>
        </div>
    );
}