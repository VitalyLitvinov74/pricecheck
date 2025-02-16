"use client"
import Link from "next/link";
import React from "react";
import {useNavigate} from "react-router";

export default function Toolbar(){

    return (
        <div className="row">
            <div className="col-lg-12 btn-toolbar">
                <div className="btn-group focus-btn-group">
                    <Link to="/home" href="/products/parsing-schemas/new">
                        <button

                            type="button"
                            className="btn btn-default mb-2">
                            <i className="feather icon-plus mr-2"></i>
                            Создать
                        </button>
                    </Link>
                    
                </div>
            </div>
        </div>
    );
}