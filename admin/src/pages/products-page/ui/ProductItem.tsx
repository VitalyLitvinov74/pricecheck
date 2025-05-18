import {Fragment} from "react";
import {Product} from "../../../models/Product";
import {ProductProperty} from "../../../models/ProductProperty";
import {AttributeCell} from "./AttributeCell";
import Link from "next/link";
import {ButtonRemove} from "./ButtonRemove";
import {ProductAttribute} from "../../../models/ProductAttribute";

export function ProductItem({product, sortedProperties}: {
    product: Product,
    sortedProperties: ProductProperty[]
}) {

    return (<tr>
        <td scope="row">#{product.id()}</td>
        {sortedProperties
            .map(function (property) {
                let attribute = product.attributeByProperty(property);
                if(!attribute){
                   attribute = new ProductAttribute({})
                }
                return (<Fragment key={attribute.id()}>
                    <AttributeCell
                        attribute={attribute}
                    />
                </Fragment>)
            })}
        <td>
            <div className="button-list">
                <Link className="btn btn-success-rgba"
                      href={`/products/update/${product.id()}`}
                >
                    <i className="feather icon-edit-2"></i>
                </Link>
                <ButtonRemove product={product}/>
            </div>
        </td>
    </tr>)
}