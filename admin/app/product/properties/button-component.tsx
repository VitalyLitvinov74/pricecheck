'use client'

import React, {useContext, useState} from "react";
import {ClientContext} from "../../nested-client-page";
export default function Breadcrumbs({title}){
    let buttonFunction = ClientContext.buttonFunction
    const test = function(){
        ClientContext.buttonFunction()
    }
    return (
        <div className="breadcrumbbar">
            <div className="row align-items-center">
                <div className="col-md-8 col-lg-8">
                    <h4 className="page-title">{title}</h4>
                    <div className="breadcrumb-list">
                        <ol className="breadcrumb">
                            <li className="breadcrumb-item"><a >Home</a></li>
                            <li className="breadcrumb-item"><a href="#">Forms</a></li>
                            <li className="breadcrumb-item active" aria-current="page">{title}</li>
                        </ol>
                    </div>
                </div>
                <div className={`col-md-4 col-lg-4`}>
                    <div className="widgetbar">
                        <button onClick={test} className="btn btn-primary-rgba"><i className="feather icon-plus mr-2"></i>Actions
                        </button>
                    </div>
                </div>
            </div>
        </div>
    )
}