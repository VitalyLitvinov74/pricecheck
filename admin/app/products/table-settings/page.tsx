
import {metadata} from "../../layout";
import {ProductsTableSettings} from "../../../src/pages/products-table-settings/ui/ProductsTableSettings";
import {loadColumnsSettings} from "./api";
import {PropertyTypeOfEntity} from "../../../src/shared/types";
import {loadProperties} from "../../../src/shared/api/products-api";



export default async function Page(){
    metadata.title= "Настройка таблицы"
    const columnsSettings = await loadColumnsSettings(PropertyTypeOfEntity.ProductProperty);
    const productProperties = await loadProperties();
    return (
        <ProductsTableSettings
            productColumnsSettings={columnsSettings}
            productProperties={productProperties
        }/>
    );
}