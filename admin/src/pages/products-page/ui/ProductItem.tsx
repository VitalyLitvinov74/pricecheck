import {Fragment} from "react";
import {Product} from "../../../models/Product";
import {ProductProperty} from "../../../models/ProductProperty";
import {AttributeCell} from "./AttributeCell";

export function ProductItem({product, sortedProperties}: {
    product: Product,
    sortedProperties: ProductProperty[]
}) {

    return (<tr>
        <td scope="row">#{product.id()}</td>
        {sortedProperties
            .map(function (property) {
                const attribute = product.attributeByProperty(property);
                return (<Fragment key={attribute.id()}>
                    <AttributeCell
                        attribute={attribute}
                    />
                </Fragment>)
            })}
        <td>
            <div className="button-list">
                {/*<Link className="btn btn-success-rgba"*/}
                {/*      href={`/products/update/${product.id}`}*/}
                {/*>*/}
                {/*    <i className="feather icon-edit-2"></i>*/}
                {/*</Link>*/}
                {/*<ButtonRemove product={product}/>*/}
            </div>
        </td>
    </tr>)
}