"use client"

import React, {createContext, Fragment, useContext, useState} from "react";
import {Property, SettingType} from "../../../shared/types";
import {Row} from "./Row";
import {useUserContext} from "../../../shared/user-context/UserContext";

const Context = createContext<{
    settingsTypesForProperties: SettingType[],
}>({} as any);

export function ProductsTableSettings({productPropertiesPayload}: {
    productPropertiesPayload: Property[]
}) {
    const userSettings = useUserContext();
    const [properties, setProperties] = useState(productPropertiesPayload)

    const settingTypes = [
        SettingType.IsEnabled,
        SettingType.ColumnNumber,
    ];

    return (
        <Context.Provider value={{
            settingsTypesForProperties: settingTypes
        }}>
            <div className="contentbar">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="card m-b-30">
                            <div className="card-body">
                                <div className="table-responsive">
                                    <table className="table table-borderless table-hover">
                                        <thead>
                                        <tr>
                                            <th width="5%">Наименование колонки</th>
                                            {settingTypes.map(function (type) {
                                                return <th key={type} width="5%">{
                                                    userSettings.settingLabelByType(type)
                                                }</th>
                                            })}
                                            <th width="15%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {properties.map(
                                            function (property: Property) {
                                                return (<Fragment key={property.id}>
                                                    <Row property={property}/>
                                                </Fragment>)
                                            })
                                        }
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </Context.Provider>
    )
}

export const useTableSettingsPageContext = () => useContext(Context)