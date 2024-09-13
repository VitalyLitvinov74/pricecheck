'use client'
import {func} from "prop-types";
import React, {useContext, useEffect, useState} from "react";
import {ClientContext} from "../layout";
import Breadcrumbs from "../breadcrumbs/breadcrumbs";
import BreadcrumbButton from "../breadcrumbs/breadcrumb-button";

export default function ProductPropertiesPage({data, title, path}){
    const {} = useContext(ClientContext);
    const [propertiesData, setPropertiesData] = useState(data)
    function addNewRowToTable(){
        setPropertiesData(function(prevState){
            return [{
                id: 222,
                name: "Тест",
                type: "striing",
            }].concat(prevState)
        });
    }

    return (
        <>
            <Breadcrumbs path={path} title={title}>
                <BreadcrumbButton title={'Добавить'} onClick={addNewRowToTable}/>
            </Breadcrumbs>
            <div className="contentbar">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="card m-b-30">
                            <div className="card-body">
                                <div className="table-responsive">
                                    <table className="table table-borderless table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Название</th>
                                            <th>Тип</th>
                                            <th>Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {propertiesData.map(function (property, key) {
                                            return (
                                                <tr key={key}>
                                                    <td>#{key+1}</td>
                                                    <td>{property.name}</td>
                                                    <td>
                                                        <span className="badge badge-secondary-inverse mr-2">{property.type}</span>
                                                    </td>
                                                    <td>
                                                        <div className="button-list">
                                                            <a href="#" className="btn btn-success-rgba"><i
                                                                className="feather icon-edit-2"></i></a>
                                                            <a href="#" className="btn btn-danger-rgba"><i
                                                                className="feather icon-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            )
                                        })}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </>
    )
}