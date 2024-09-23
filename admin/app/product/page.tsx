import {metadata} from "../layout";
import ProductsTable from "./products-table";
export default function Products(){
    metadata.title= "Список товаров"
    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            {/*<ProductsTable metadata={metadata}/>*/}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}