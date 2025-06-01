"use client"
import {createContext, Fragment, useContext, useState} from "react";
import {Attribute, FormAction, Option, Product, Property} from "../../../shared/types";
import {AddAttributeButton} from "./buttons/AddAttributeButton";
import {AttributeInput} from "./AttributeInput";
import {SaveProductButton} from "./buttons/SaveProductButton";

const Context = createContext<{
    addAttribute: (attribute: Attribute) => void
    buildOptionsByAttribute: (attribute: Attribute) => Option[],
    changeAttribute: (attribute: Attribute) => void,
    removeAttribute: (attribute: Attribute) => void
}>({} as any)

export function Form({propertiesPayload, productPayload, formAction, attributesPayload}: {
    propertiesPayload: Property[],
    productPayload: Product,
    attributesPayload: Attribute[],
    formAction: FormAction
}) {
    const [properties, setProperties] = useState<Property[]>(propertiesPayload)
    const [attributes, setAttributes] = useState(attributesPayload)

    function optionsFor(attribute: Attribute): Option[] {
        let options: any;
        options = propertiesPayload
            .filter(function (property) {
                let needShow = true
                attributes.forEach(function (createdAttribute) {
                    if (createdAttribute.property_id === property.id) {
                        needShow = false
                    }
                })
                return needShow
            })
            .map(function (property, key) {
                return {
                    value: property.id,
                    label: property.name
                }
            });
        if (attribute !== null) {
            options = [{
                value: attribute.property_id,
                label: findPropertyById(attribute.property_id)?.name
            }, ...options]
        }
        return options;
    }

    function changeAttribute(attribute: Attribute): void {
        setAttributes(function (prevState) {
            return prevState.map(function (item) {
                if (item.id === attribute.id) {
                    return attribute
                }
                return item
            })
        })
    }

    function addAttribute(attribute) {
        setAttributes(function (prevState) {
            return [...prevState, attribute]
        })
    }

    function removeAttribute(attribute): void {
        setAttributes(function (prevState) {
            return prevState.filter(function (item) {
                return item.id !== attribute.id
            })
        })
    }

    function findPropertyById(id: number): Property | undefined {
        return properties.find(function (property) {
            return property.id === id
        })
    }

    // console.log(attributes)

    return (
        <Context.Provider value={{
            addAttribute: addAttribute,
            buildOptionsByAttribute: optionsFor,
            changeAttribute: changeAttribute,
            removeAttribute: removeAttribute
        }}>
            <div className="card-body">
                <div className="row mt-2">
                    <div className="col-md-9">
                        <AddAttributeButton
                            properties={properties}
                            attributes={attributes}
                            product={productPayload}
                        />
                        <SaveProductButton attributes={attributes} formAction={formAction}/>
                        {/*<button type="button" className="btn btn-secondary-rgba mr-2"><i*/}
                        {/*    className="feather icon-share-2 mr-2"></i> Сохранить шаблон*/}
                        {/*</button>*/}
                    </div>
                </div>
                <div className="row ">
                    <div className="col-md-12">
                        {attributes.map(
                            function (attribute) {
                                return <Fragment key={attribute.id}>
                                    <AttributeInput
                                        attribute={attribute}
                                        property={
                                            findPropertyById(attribute.property_id)
                                        }
                                    />
                                </Fragment>
                            }
                        )}
                    </div>
                </div>
            </div>
        </Context.Provider>
    );
}

export const useProductFormContext = () => useContext(Context)