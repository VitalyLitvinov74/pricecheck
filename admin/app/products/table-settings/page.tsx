
import {metadata} from "../../layout";
import {loadProperties, loadColumns} from "../../../src/shared/api/products-api";
import ProductsTableSettings from "../../../src/pages/products-table-settings/ui/ProductsTableSettings";


export default async function Page(){
    metadata.title= "Настройка таблицы"

    const settings = await loadColumns()
    const availableProperties = await loadProperties();

    return (
        <ProductsTableSettings columns={settings} productProperties={availableProperties}/>
    );
}