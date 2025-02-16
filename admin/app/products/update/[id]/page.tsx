import {metadata} from "../../../layout";
import {loadProperties} from "../../../../utils/product-properties";
import Form from "../../form";
import {loadProduct} from "../../../../utils/products";

export default async function Page({params}: { id: string }){
    metadata.title= "Обновить"
    const properties = await loadProperties();

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