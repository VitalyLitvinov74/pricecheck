"use client"
import Select from "react-select";
import React from "react";

export default function Form({properties}) {

    function options() {
        let options: any;
        options = properties.map(function (property, key) {
            return {value: property.id, label: property.name}
        });
        return options;
    }

    return (
        <div>
            <div className="row">
                <div className="col-md-6">
                    <label htmlFor="validationServer03">City</label>

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
                    <input type="text" className="form-control is-invalid" id="validationServer03"
                           required=""/>
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

                    <button type="button" className="btn btn-round btn-danger-rgba"><i className="feather icon-minus"></i></button>
                </div>
            </div>
            <div className="row mt-2">
                <div className="col-md-9">
                    <button type="button" className="btn btn-success-rgba mr-2"><i
                        className="feather icon-plus mr-2"></i> Создать
                    </button>
                    <button type="button" className="btn btn-secondary-rgba mr-2"><i
                        className="feather icon-save mr-2"></i> Сохранить как шаблон
                    </button>
                </div>
                <div className="col-md-1">
                    <button type="button" className="btn btn-round btn-success-rgba"><i className="feather icon-plus"></i></button>
                </div>
            </div>
        </div>
    );
}