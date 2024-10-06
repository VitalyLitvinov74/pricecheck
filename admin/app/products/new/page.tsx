import {metadata} from "../../layout";
import Form from "./form";
import {loadProperties} from "../../../utils/product-properties";

export default async function newProduct(){
    metadata.title= "Список товаров"
    let properties = [];
    await loadProperties().then(
        function (data) {
            properties = data;
        }
    );
    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <Form properties={properties}/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}