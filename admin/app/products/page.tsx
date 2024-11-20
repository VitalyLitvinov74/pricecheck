import {metadata} from "../layout";
import Table from "./table";
import Toolbar from "./toolbar";
import {loadProducts, loadTableSettings} from "../../utils/products";
export default async function Products(){
    metadata.title= "Список товаров"

    let products = [];
    await loadProducts().then(function(data){
        products = data;
    });

    const tableSettings = await loadTableSettings();

    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <Toolbar />
                            <Table importedProducts={products} tableSettings={tableSettings}/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}