import {metadata} from "../../layout";
import Table from "./table";
import Toolbar from "./toolbar";
import {loadParsingSchemas} from "../../../utils/product-properties";

export default async function ParsingSchemas(){
    metadata.title= "Схемы парсинга"
    let parsingSchemas = [];
    await loadParsingSchemas().then(
        function (data) {
            parsingSchemas = data;
        }
    );
    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <Toolbar></Toolbar>
                            <Table parsingSchemas={parsingSchemas}></Table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}