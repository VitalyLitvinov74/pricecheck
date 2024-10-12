import {metadata} from "../../layout";
import Table from "./table";
import Toolbar from "./toolbar";

export default function ParsingSchemas(){
    metadata.title= "Схемы парсинга"
    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <Toolbar></Toolbar>
                            <Table></Table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}