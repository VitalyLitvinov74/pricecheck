import {loadProperties} from "../../../utils/product-properties";
import ProductPropertiesPage from "../../../client-components/product-properties/product-properties-page";
import {metadata} from "../../layout";

export default async function ProductProperties() {
    let properties = [];
    metadata.title = "Свойства товаров"
    await loadProperties().then(
        function (data) {
            properties = data;
        }
    );

    return (
        <>
            <ProductPropertiesPage data={properties} title={metadata.title}/>
        </>
    );
}