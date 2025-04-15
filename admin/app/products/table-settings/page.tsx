
import {metadata} from "../../layout";
import {ProductsTableSettings} from "../../../src/pages/products-table-settings/ui/ProductsTableSettings";
import {loadProperties} from "../../../src/shared/api/products-api";



export default async function Page(){
    metadata.title= "Настройка таблицы"
    const productProperties = await loadProperties();
    return (
        <ProductsTableSettings
            productProperties={productProperties
        }/>
    );
}