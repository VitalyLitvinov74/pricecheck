import {metadata} from "../../../layout";
import {loadProperties} from "../../../../utils/product-properties";
import Form from "../../form";
import {loadProduct} from "../../../../utils/products";

export default async function Page({params}: { id: string }){
    metadata.title= "Обновить"
    let properties = [];
    await loadProperties().then(
        function (data) {
            properties = data;
        }
    );

    let product = {};
    await loadProduct(params.id).then(function(data){
        product = data
    })


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