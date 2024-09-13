import ProductPage from "../../client-components/product/product-page";
import {metadata} from "../layout";
export default function Products(){
    metadata.title= "Список товаров"
    return (
        <>
            <ProductPage title={metadata.title}/>
        </>
    );
}