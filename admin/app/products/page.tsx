import {metadata} from "../layout";
import Table from "./table";
import Toolbar from "./toolbar";
export default function Products(){
    metadata.title= "Список товаров"
    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <Toolbar />
                            <Table/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}