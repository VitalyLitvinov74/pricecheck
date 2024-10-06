"use client"
import Select from "react-select";
import React, {useState} from "react";

export default function Form({properties}) {

    const [attributes, changeAttributes] = useState([defaultAttribute()])

    function defaultAttribute(){
        return {
            value: '',
            name: options()[0].label,
            propertyId: options()[0].value
        }
    }

    function options() {
        let options: any;
        options = properties.map(function (property, key) {
            return {value: property.id, label: property.name}
        });
        return options;
    }

    function add(){
        changeAttributes([defaultAttribute(), ...attributes])
    }

    function remove(attribute){
        changeAttributes(attributes.filter(function(validateAttribute){
            if(validateAttribute.propertyId === attribute.propertyId){
                return false;
            }
            return true;
        }))
    }

    function attributeInput(attribute){
        return (
            <>
                <div className="row mt-4">
                    <div className="col-md-6">
                        <label htmlFor="validationServer03">{attribute.name}</label>

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
                        <input type="text" className="form-control is-invalid" id="validationServer03" required=""/>
                    </div>
                    <div className="col-md-3">
                        <Select
                            id="validationServer04"
                            options={options()}
                            defaultValue={options()[0]}
                        >
                        </Select>
                    </div>
                    <div className="col-md-1 ">
                        <button
                            type="button"
                            className="btn btn-round btn-danger-rgba"
                            onClick={()=>{remove(attribute)}}
                        >
                            <i className="feather icon-minus"></i>
                        </button>
                    </div>
                </div>
            </>
        )
    }

    return (
        <div>
            <div className="row mt-2">
                <div className="col-md-9">
                    <button
                        type="button"
                        className="btn btn-default mr-2"
                        onClick={add}
                    >
                        <span className="glyphicon glyphicon-screenshot"></span>
                        Добавить аттрибут
                    </button>
                    <button type="button" className="btn btn-success mr-2"><i
                        className="feather icon-save mr-2"></i> Сохранить
                    </button>
                    <button type="button" className="btn btn-secondary-rgba mr-2"><i
                        className="feather icon-share-2 mr-2"></i> Сохранить шаблон
                    </button>
                </div>
            </div>
            {attributes.map(
                function(attribute){
                    return attributeInput(attribute)
                }
            )}
        </div>
    );
}