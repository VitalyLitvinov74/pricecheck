import {useProductContext} from "../../../../shared/product-page-context/ProductContext";
import {PropertyLibrary} from "../../../../models/PropertyLibrary";
import {ProductAttribute} from "../../../../models/ProductAttribute";

export function AddAttributeButton({properties}: {
    properties: PropertyLibrary[]
}) {
    const isDisabled = false;
    const context = useProductContext()
    const product = context.product;

    function add() {
        const property = properties.find(function (property: PropertyLibrary) {
            const attribute = product.attributeByProperty(property);
            if (!attribute) {
                return true;
            }
            return false;
        })

        if (property === undefined) {
            return;
        }

        product.addAttribute(
            new ProductAttribute("", property)
        )

        context.setProduct(product);
    }

    return (<>
        <button
            type="button"
            className="btn btn-default mr-2"
            disabled={isDisabled}
            onClick={add}
        >
            <span className="glyphicon glyphicon-screenshot"></span>
            Добавить аттрибут
        </button>
    </>)
}