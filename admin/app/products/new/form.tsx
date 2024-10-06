"use client"
import Select from "react-select";
import React from "react";

export default function Form() {
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
                        options={[]}
                    >
                    </Select>
                </div>
                <div className="col-md-1 ">

                    <button type="button" className="btn btn-round btn-danger-rgba"><i className="feather icon-minus"></i></button>
                </div>
            </div>
            <div className="row mt-2">
                <div className="col-md-9"></div>
                <div className="col-md-1">
                    <button type="button" className="btn btn-round btn-success-rgba"><i className="feather icon-plus"></i></button>
                </div>
            </div>
        </div>
    );
}