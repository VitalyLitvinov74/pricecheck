import {loadProperties} from "../../../utils/product-properties";
import {metadata} from "../../layout";
import ProductPropertiesPage from "../../../client-components/product-properties/product-properties-page";
import Breadcrumbs from "../../../client-components/breadcrumbs/breadcrumbs";

export default async function ProductProperties() {
    let properties = [];
    metadata.title = 'Свойства товаров'
    const title = metadata.title
    await loadProperties().then(
        function (data) {
            properties = data;
        }
    );

    const path = [
            {
                link: "/",
                title: "Домашняя",
                isCurrent: false,
            },
            {
                link: "/product",
                title: "Товары",
                isCurrent: false,
            },
            {
                link: "/product/properties",
                title: title,
                isCurrent: true,
            }
        ];

return (
    <>
        <ProductPropertiesPage data={properties} title={title} path={path}/>
    </>
);
}