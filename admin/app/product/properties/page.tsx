import {loadProperties} from "../../../utils/product-properties";
import {metadata} from "../../layout";
import ProductPropertiesClient from "./product-properties-client";
import Breadcrumbs from "./button-component";
import {createContext} from "react";

export default async function ProductProperties() {
    let properties = [];
    metadata.title = 'Свойства товаров'
    await loadProperties().then(
        function (data) {
            properties = data;
        }
    );

    return (
        <>
            <ProductPropertiesClient propertiesData={properties}/>
        </>
    );
}