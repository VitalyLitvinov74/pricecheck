import {Attribute, Product, Property} from "../../../../shared/types";
import {useProductFormContext} from "../Form";
import {uniqNumber} from "../../../../shared/helpers";
import {useEffect, useState} from "react";

export function AddAttributeButton({properties, attributes, product}: {
    properties: Property[],
    attributes: Attribute[],
    product: Product
}) {
    const form = useProductFormContext()
    const [isDisabled, setIsDisabled] = useState(false)

    useEffect(function(){
        const length = properties.filter(function(property){
            return !attributes.find(function(attribute){
                return attribute.property_id === property.id
            })
        }).length;
        setIsDisabled(length === 0)
    }, [attributes])
    function defaultAttributeFor(property: Property): Attribute {
        return {
            id: uniqNumber(),
            product_id: product.id,
            property_id: property.id,
            value: ""
        }
    }

    function add() {
        const property = properties.find(
            function (property: Property) {
                const attribute = attributes.find(function(item){
                    return item.property_id === property.id
                })
                if (!attribute) {
                    return true;
                }
                return false;
            }
        )

        //если на все свойства назанчены атрибуты
        if (property === undefined) {
            return;
        }

        form.addAttribute(
            defaultAttributeFor(property)
        )
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