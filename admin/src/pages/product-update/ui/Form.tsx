"use client"
import Select from "react-select";
import {useState} from "react";
import {useRouter} from "next/navigation";
import revalidateProductList from "../../../../app/actions/RevalidateProductList";
import {ProductPayload, ProductPropertyPayload} from "../../../shared/types";

export function Form({
                         propertiesPayload,
                         productPayload,
                         action = 'create'
                     }:{
    propertiesPayload: ProductPropertyPayload[],
    productPayload: ProductPayload[],
}) {

    console.log(productPayload)

    const [attributes, changeAttributes] = useState(productPayload.productAttributes)
    const [addButtonDisabled, disableAddButton] = useState(false)

    console.log(attributes)

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

    function add() {
        if (optionsFor(null).length === 0) {
            disableAddButton(true);
            return;
        }
        changeAttributes([defaultAttribute(), ...attributes])
    }

    function remove(attribute) {
        changeAttributes(
            attributes.filter(function (validateAttribute) {
                return validateAttribute.id !== attribute.id;
            }))

        if (optionsFor(attribute).length > 0) {
            disableAddButton(false);
            return;
        }
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

    function attributeInput(attribute) {
        return (
            <div key={attribute.id}>
                <div className="row mt-4">
                    <div className="col-md-6">
                        <label htmlFor={attribute.id}>{attribute.name}</label>

                        {/*<div className="invalid-feedback">*/}
                        {/*    Please provide a valid city.*/}
                        {/*</div>*/}

                    </div>
                    {/*<div className="col-md-3">*/}
                    {/*    <label htmlFor="validationServer04">City</label>*/}
                    {/*</div>*/}

                </div>
                <div className="row">
                    <div className="col-md-6">
                        <input type="text"
                               className="form-control is-invalid"
                               id={attribute.id} required=""
                               onBlur={(e) => {
                                   attributeChangedOn(attribute, null, e.target.value)
                               }}
                               defaultValue={attribute.value}
                        />
                    </div>
                    <div className="col-md-3">
                        <Select
                            defaultValue={optionsFor(attribute)[0]}
                            options={optionsFor()}
                            onChange={(option) => attributeChangedOn(attribute, option)}
                            menuPosition={"fixed"}
                        >
                        </Select>
                    </div>
                    <div className="col-md-1 ">
                        <button
                            type="button"
                            className="btn btn-round btn-danger-rgba"
                            onClick={() => {
                                remove(attribute)
                            }}
                        >
                            <i className="feather icon-minus"></i>
                        </button>
                    </div>
                </div>
            </div>
        )
    }

    function dataForBackend() {
        return {
            id: productPayload.id,
            productAttributes: attributes.map(function (attribute) {
                return {
                    id: attribute.id,
                    name: attribute.name,
                    property: {
                        id: attribute.propertyId
                    },
                    value: attribute.value
                }
            })
        };
    }

    const router = useRouter();

    async function saveProduct() {
        let status = 204;
        const url = `http://api.pricecheck.my:82/product/${action}`;
        await fetch(url, {
            body: JSON.stringify(dataForBackend()),
            headers: {
                'content-type': "application/json"
            },
            method: "post",
        }).then(function (result) {
            status = result.status;
        })
        if (status === 204) {
            await revalidateProductList()
            router.push("/products")
        }
    }

    return (
        <div className="card-body">
            <div className="row mt-2">
                <div className="col-md-9">
                    <button
                        type="button"
                        className="btn btn-default mr-2"
                        disabled={addButtonDisabled}
                        onClick={add}
                    >
                        <span className="glyphicon glyphicon-screenshot"></span>
                        Добавить аттрибут
                    </button>
                    <button
                        type="button"
                        onClick={saveProduct}
                        className="btn btn-success mr-2">
                        <i className="feather icon-save mr-2"></i>
                        Сохранить
                    </button>
                    <button type="button" className="btn btn-secondary-rgba mr-2"><i
                        className="feather icon-share-2 mr-2"></i> Сохранить шаблон
                    </button>
                </div>
            </div>
            <div className="row ">
                <div className="col-md-12">
                    {attributes.map(
                        function (attribute) {
                            return attributeInput(attribute)
                        }
                    )}
                </div>
            </div>
        </div>
    );
}