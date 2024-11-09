
import {metadata} from "../../layout";
import Table from "./table";
import {loadProperties, loadPropertiesSettings} from "../../../utils/product-properties";

export default async function Page(){
    metadata.title= "Настройка таблицы"

    let settings = [];
    await loadPropertiesSettings().then(function(data){
        settings = data;
    });

    let availableProperties = [];
    await loadProperties().then(function(data){
        availableProperties = data;
    });

    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <Table data={settings} availableProperties={availableProperties}/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}