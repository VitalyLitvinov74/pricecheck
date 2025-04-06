
import {metadata} from "../../layout";
import {loadProperties, loadTableSettings} from "../../../src/shared/api/products-api";
import ProductsListSettings from "../../../src/pages/products-table-settings/ui/ProductsListSettings";


export default async function Page(){
    metadata.title= "Настройка таблицы"

    const settings = await loadTableSettings()
    const availableProperties = await loadProperties();

    return (
        <ProductsListSettings settings={settings}/>
    );
}