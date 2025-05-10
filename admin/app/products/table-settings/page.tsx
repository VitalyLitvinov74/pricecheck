
import {metadata} from "../../layout";
import {ProductsTableSettings} from "../../../src/pages/products-table-settings/ui/ProductsTableSettings";
import {loadProperties} from "../../../src/shared/api/products-api";
import {UserContext} from "../../../src/shared/user-context/UserContext";
import {loadUserSettings} from "../../api";



export default async function Page(){
    metadata.title= "Настройка таблицы"
    const productProperties = await loadProperties();
    const userSettings = await loadUserSettings();
    return (
        <UserContext settingsPayload={userSettings}>
            <ProductsTableSettings
                productPropertiesPayload={productProperties}
            />
        </UserContext>
    );
}