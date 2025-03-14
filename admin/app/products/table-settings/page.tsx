
import {metadata} from "../../layout";
import {loadProperties, loadTableSettings} from "../../../shared/api/products-api";
import ProductsTableSettings from "../../../pages/products-table-settings/ui/ProductsTableSettings";


export default async function Page(){
    metadata.title= "Настройка таблицы"

    const settings = await loadTableSettings()
    const availableProperties = await loadProperties();

    return (
        <ProductsTableSettings settings={settings} availableProperties={availableProperties}/>
    );
}