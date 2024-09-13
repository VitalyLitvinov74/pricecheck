'use client'
import {func} from "prop-types";
import {useContext, useEffect, useState} from "react";
import {ClientContext} from "../../nested-client-page";

export default function ProductPropertiesClient({propertiesData}){
    const {buttonFunction, setButtonFunction} = useContext(ClientContext);
    const [propertiesData1, setPropertiesData] = useState(propertiesData)
    useEffect(
        function () {
            setButtonFunction(function(){
                return function(){
                    setPropertiesData(function(prevState){
                        return [{
                            id: 222,
                            name: "Тест",
                            type: "striing",
                        }].concat(prevState)
                    });
                }
            })
        },
        []
    )

    return (
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
                                        {propertiesData1.map(function (property, key) {
                                            return (
                                                <tr>
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
    )
}