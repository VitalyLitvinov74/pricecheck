import {metadata} from "../layout";
import {loadProducts, loadTableSettings} from "../../shared/api/products-api";
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