import {metadata} from "../layout";
import {loadProducts, loadTableSettings} from "../../pages/products-page/api/products-page-api";
import ProductsPage from "../../pages/products-page/ui/products-page";


export default async function Products() {
    metadata.title = "Список товаров"

    const products = await loadProducts();
    const tableSettings = await loadTableSettings();

    return (
        <ProductsPage products={products} tableSettings={tableSettings}/>
    );
}