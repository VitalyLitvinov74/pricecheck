import {metadata} from "../layout";
import {loadProducts, loadColumns} from "../../src/shared/api/products-api";
import ProductsPage from "../../src/pages/products-page/ui/ProductsPage";


export default async function Products({ searchParams}) {
    metadata.title = "Список товаров"

    const search = new URLSearchParams(searchParams);
    const products = await loadProducts(search.toString());
    const tableSettings = await loadColumns();

    return (
        <ProductsPage products={products} tableSettings={tableSettings}/>
    );
}