"use client"

import React from "react";
import {EntityType, ProductPropertyPayload, SettingType, UserSettingPayload,} from "../../../shared/types";
import {Row} from "./Row";
import {ProductProperty} from "../../../models/ProductProperty";

export function ProductsTableSettings({productProperties}: {
    productProperties: ProductPropertyPayload[]
}) {
    productProperties = productProperties.map(function (item) {
        return new ProductProperty(item)
    })

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

    function columnsSettings(): { type: SettingType, word: string }[] {
        return Object.values(SettingType)
            .filter(function (settingType) {
                return typeof settingType !== "string"
            })
            .map(function (settingType: SettingType) {
                switch (settingType) {
                    case SettingType.ColumnNumber:
                        return {
                            type: SettingType.ColumnNumber,
                            word: "Номер колонки"
                        };
                    case SettingType.IsEnabled:
                        return {
                            type: SettingType.IsEnabled,
                            word: "Включено"
                        }
                }
            })
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
                                        {columnsSettings().map(function (data) {
                                            return <th key={data.type} width="5%">{data.word}</th>
                                        })}
                                        <th width="15%"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {productProperties.map(
                                        function (productProperty: ProductProperty) {
                                            return (<tr key={productProperty.id}>
                                                <Row productProperty={productProperty}
                                                     headerColumns={columnsSettings()}
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