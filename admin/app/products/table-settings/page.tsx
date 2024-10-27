import {loadProperties} from "../../../utils/product-properties";
import {metadata} from "../../layout";

export default async function Page(){
    metadata.title= "Настройка таблицы"

    let products = [];
    await loadProperties().then(function(data){
        products = data;
    });

    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <Table importedProducts={products}/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}