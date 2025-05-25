"use client"
import {useState} from "react";
import {ProductPropertyPayload} from "../../../shared/types";
import {AddAttributeButton} from "./buttons/AddAttributeButton";
import {AttributeInput} from "./AttributeInput";
import {PropertyLibrary} from "../../../models/PropertyLibrary";

export function Form({propertiesPayload}: {
    propertiesPayload: ProductPropertyPayload[],
}) {
    const [properties, setProperties] = useState<PropertyLibrary[]>(
        propertiesPayload.map(
            function (payload: ProductPropertyPayload) {
                return new PropertyLibrary(payload)
            }
        )
    )
    const [attributes, changeAttributes] = useState([])
    const [addButtonDisabled, disableAddButton] = useState(false)

    function defaultAttribute() {
        return {
            id: uuidv4(),
            name: optionsFor()[0].label,
            propertyId: optionsFor()[0].value,
            value: null
        }
    }

    function optionsFor(attribute = null) {
        let options: any;
        options = propertiesPayload
            .filter(function (property) {
                let needShow = true
                attributes.forEach(function (createdAttribute) {
                    if (createdAttribute.propertyId === property.id) {
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
                value: attribute.propertyId,
                label: attribute.name
            }, ...options]
        }
        return options;
    }

    function attributeChangedOn(attribute, option = null, attributeValue = null) {
        const newAttributes = attributes.slice()
        newAttributes.forEach(function (newAttribute) {
            if (attribute.propertyId === newAttribute.propertyId) {
                if (option) {
                    newAttribute.name = option.label
                    newAttribute.propertyId = option.value
                }
                if (attributeValue !== null) {
                    if (attributeValue === '') {
                        newAttribute.value = null
                        return;
                    }
                    newAttribute.value = attributeValue
                }
            }
        })
        changeAttributes(newAttributes)
        console.log(newAttributes)
    }

    return (
        <div className="card-body">
            <div className="row mt-2">
                <div className="col-md-9">
                    <AddAttributeButton properties={properties}/>
                    {/*<SaveProductButton/>*/}
                    {/*<button type="button" className="btn btn-secondary-rgba mr-2"><i*/}
                    {/*    className="feather icon-share-2 mr-2"></i> Сохранить шаблон*/}
                    {/*</button>*/}
                </div>
            </div>
            <div className="row ">
                <div className="col-md-12">
                    {attributes.map(
                        function (attribute) {
                            return <AttributeInput attribute={attribute}/>
                        }
                    )}
                </div>
            </div>
        </div>
    );
}