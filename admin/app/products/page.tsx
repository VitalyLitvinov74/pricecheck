import {metadata} from "../layout";
import ProductsPage from "../../src/pages/products-page/ui/ProductsPage";
import {loadProducts, loadTableSettings} from "../../src/pages/products-page/api/products-page-api";


export default async function Products() {
    metadata.title = "Список товаров"

    const products = await loadProducts();
    const tableSettings = await loadTableSettings();

    return (
        <ProductsPage products={products} tableSettings={tableSettings}/>
    );
}