import {metadata} from "../layout";
import {loadProducts, loadTableSettings} from "../../pages/products-page/api/products-page-api";
import ProductsPage from "../../pages/products-page/ui/products-page";


export default async function Products({ searchParams}) {
    metadata.title = "Список товаров"

    const search = new URLSearchParams(searchParams);
    const products = await loadProducts(search.toString());
    const tableSettings = await loadTableSettings();

    return (
        <ProductsPage products={products} tableSettings={tableSettings}/>
    );
}