import ProductPage from "../../client-components/product/product-page";
import {metadata} from "../layout";
import Breadcrumbs from "../../client-components/breadcrumbs/breadcrumbs";

export default function Products(){
    metadata.title = 'Список товаров'
    const path = [
        {
            link: '/',
            title: 'Домашняя',
            isCurrent: false
        },
        {
            link: '/product',
            title: 'Список товаров',
            isCurrent: true
        }
    ]
    return (<ProductPage/>);
}