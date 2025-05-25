import {Fragment} from "react";
import {AttributeCell} from "./AttributeCell";
import Link from "next/link";
import {useProductsPageContext} from "./ProductsPage";
import {Attribute, Property} from "../../../shared/types";
import {uuid} from "../../../shared/helpers";

export function ProductItem({productId}: {
    productId: number,
}) {
    const productPage = useProductsPageContext();
    const product = productPage.getProductById(productId);

    function attributeByProperty(prperty: Property): Attribute | undefined {
        return product?.attributes.find(function (attribute: Attribute) {
            return attribute.property_id === prperty.id
        })
    }


    return (<tr>
        <td scope="row">#{product?.id}</td>
        {productPage
            .getHeaderSortedAvailableProperties()
            .map(function (property) {
                let attribute = attributeByProperty(property);
                if (!attribute) {
                    return (<Fragment key={uuid()}>
                        <td> -</td>
                    </Fragment>)
                }
                return (<Fragment key={attribute.id}>
                    <AttributeCell
                        attribute={attribute}
                    />
                </Fragment>)
            })}
        <td>
            <div className="button-list">
                <Link className="btn btn-success-rgba"
                      href={`/products/update/${productId}`}
                >
                    <i className="feather icon-edit-2"></i>
                </Link>
                {/*<ButtonRemove product={product}/>*/}
            </div>
        </td>
    </tr>)
}