"use client"

import React, {useState} from "react";
import {EntityType, ProductPropertyPayload,} from "../../../shared/types";
import {Row} from "./Row";
import {ProductProperty} from "../../../models/ProductProperty";
import {useUserContext} from "../../../shared/user-context/UserContext";
import {UserSetting} from "../../../models/UserSetting";

export function ProductsTableSettings({productPropertiesPayload}: {
    productPropertiesPayload: ProductPropertyPayload[]
}) {
    const userSettings = useUserContext();
    const [productProperties, setProductProperties] = useState(
        productPropertiesPayload.map(function (item) {
            return new ProductProperty({
                ...item,
                userSettings: userSettings.findByTypeAndEntityId(
                    EntityType.ProductProperty,
                    item.id
                )
            })
        })
    )

    function setProperty(property: ProductProperty): void {
        // console.log(property.userSettings())
        setProductProperties(productProperties
            .map(function (item) {
                if (item.frontendId === property.frontendId) {
                    return property
                }
                return item
            })
        )
    }

    // const [productProperties, setProductProperties] = useState(existedColumns)

    // function removeOnBackend(itemForRemove: TableSetting) {
    //     const url = `http://api.pricecheck.my:82/properties/dis-attach-setting`;
    //     let status = 0;
    //     fetch(url, {
    //         body: JSON.stringify({
    //             settingTypeId: itemForRemove.setting_type_id,
    //             property: itemForRemove.property
    //         }),
    //         headers: {
    //             'content-type': "application/json"
    //         },
    //         method: "delete",
    //     }).then(function (result) {
    //         status = result.status;
    //     })
    //     removeRow(itemForRemove)
    // }
    //
    // function removeRow(settingForRemove) {
    //     setTableSettings(tableSettings
    //         .filter(function (existedSetting) {
    //             return settingForRemove.property_id !== existedSetting.property_id;
    //
    //         })
    //     )
    // }
    //
    // function addNewRow() {
    //     const property = productProperties.find(function (properties) {
    //         const setting = tableSettings.find(function (setting) {
    //             return setting.property_id == properties.id
    //         })
    //         if (setting) {
    //             return false;
    //         }
    //         return true;
    //     })
    //
    //     if(!property){
    //         return;
    //     }
    //
    //     const setting: TableSetting = {
    //         property_id: property.id,
    //         type: SettingType.IsEnabled,
    //         value: 1,
    //     }
    //
    //     setTableSettings(function(prev){
    //         return [
    //             setting,
    //             ...prev
    //         ]
    //     })
    // }
    //
    // function propertyById(id) {
    //     return availableProperties.find(function (property) {
    //         return property.id == id;
    //     })
    // }
    //
    // function buildOptionBy(setting) {
    //     // console.log(id,options())
    //     return {
    //         value: setting.property_id,
    //         label: propertyById(setting.property_id).name
    //     }
    // }
    //
    // async function commit(updatedItem: TableSetting) {
    //     const list = [];
    //     tableSettings.map(function (item) {
    //         if (item.property_id === updatedItem.property_id) {
    //             item.property = updatedItem.property
    //             item.isEditable = false
    //             item.committed = true;
    //             item.settingTypeId = item.setting_type_id
    //         }
    //         list.push(item)
    //     })
    //     setTableSettings(list)
    //     let status = 0;
    //     const url = `http://api.pricecheck.my:82/properties/attach-setting`;
    //     const dataForUpsert = [updatedItem]
    //     await fetch(url, {
    //         body: JSON.stringify(dataForUpsert),
    //         headers: {
    //             'content-type': "application/json"
    //         },
    //         method: "POST",
    //     }).then(function (result) {
    //         status = result.status;
    //     })
    //     if (status === 204) {
    //         await revalidateProductList()
    //     }
    // }
    //
    // function changeSetting(newOptionData, settingChanged: TableSetting) {
    //     const list = tableSettings.map(function (setting) {
    //         if (setting.property_id == settingChanged.property_id) {
    //             setting.property_id = newOptionData.value
    //             setting.property = propertyById(newOptionData.value)
    //         }
    //         return setting;
    //     })
    //     setTableSettings(list);
    // }

    function settings(): UserSetting[] {
        return productProperties[0].userSettings()
    }

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
                                        <th width="5%">Наименование колонки</th>
                                        {settings().map(function (data) {
                                            return <th key={data.type} width="5%">{data.label()}</th>
                                        })}
                                        <th width="15%"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {productProperties.map(
                                        function (productProperty: ProductProperty) {
                                            return (<tr key={productProperty.frontendId}>
                                                <Row
                                                    productProperty={productProperty}
                                                    setProductProperty={setProperty}
                                                />
                                            </tr>)
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
    )
}