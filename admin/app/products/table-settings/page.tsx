
import {metadata} from "../../layout";
import {ProductsTableSettings} from "../../../src/pages/products-table-settings/ui/ProductsTableSettings";
import {loadColumnsSettings} from "./api";
import {PropertyTypeOfEntity} from "../../../src/shared/types";



export default async function Page(){
    metadata.title= "Настройка таблицы"
    const columnsSettings = await loadColumnsSettings(PropertyTypeOfEntity.ProductProperty);
    return (
        <ProductsTableSettings columnsSettings={columnsSettings} productProperties={[]}/>
    );
}