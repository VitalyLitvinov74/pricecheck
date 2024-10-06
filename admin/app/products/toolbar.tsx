"use client"
import Link from "next/link";
import React from "react";
import {useNavigate} from "react-router";

export default function Toolbar(){

    return (
        <div className="row">
            <div className="col-lg-6 btn-toolbar">
                <div className="btn-group focus-btn-group">
                    <Link to="/home" href="/products/new">
                        <button

                            type="button"
                            className="btn btn-default mb-2">
                            <i className="feather icon-plus mr-2"></i>
                            Добавить
                        </button>
                    </Link>
                    
                </div>
                <div className="btn-group focus-btn-group ml-4 mb-2">
                    <button
                        type="button"
                        className="btn btn-primary-rgba">
                        <i className="feather icon-settings mr-2"></i>
                        Настройки таблицы
                    </button>
                </div>
                <div className="btn-group focus-btn-group ml-4 mb-2">
                    <button
                        type="button"
                        className="btn btn-secondary-rgba">
                        <i className="feather icon-share-2 mr-2"></i>
                        Шаблоны товаров
                    </button>
                </div>
            </div>
            <div className="col-lg-6 ">
                <div className="form-inline d-flex justify-content-end">
                    <div className="form-group mx-sm-3 mb-2">
                        <input type="text" className="form-control" id="inputPassword2" placeholder="Ищем по всем полям" />
                    </div>
                    <button type="submit" className="btn btn-info mb-2">
                        <i className="feather icon-search"></i>
                       </button>
                </div>
            </div>
        </div>
    );
}