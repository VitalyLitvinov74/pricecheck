import {metadata} from "../../layout";
import Form from "./form";

export default function newProduct(){
    metadata.title= "Список товаров"
    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <Form />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}