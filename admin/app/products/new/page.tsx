import {metadata} from "../../layout";
import Form from "../form";
import {loadProperties} from "../../../utils/product-properties";

export default async function newProduct(){
    metadata.title= "Создать товар"
    const properties = await loadProperties();
    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <Form properties={properties}/>
                    </div>
                </div>

            </div>
        </div>
    );
}