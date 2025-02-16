
import {metadata} from "../../layout";
import Table from "./table";
import {loadProperties} from "../../../../utils/product-properties";
import {loadTableSettings} from "../../../../utils/products";

export default async function Page(){
    metadata.title= "Настройка таблицы"

    const settings = await loadTableSettings()
    const availableProperties = await loadProperties();

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