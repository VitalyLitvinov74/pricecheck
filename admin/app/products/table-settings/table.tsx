'use client'
import React, {useState} from "react";
import Select from "react-select";

export default function Table({data, availableProperties}) {

    const [propertySettings, changePropertySettings] = useState(data)
    function removeOnBackend(itemForRemove) {
        // const url = `http://api.pricecheck.my:82/properties/remove`;
        // let status = 0;
        // fetch(url, {
        //     body: JSON.stringify({
        //         id: itemForRemove.id
        //     }),
        //     headers: {
        //         'content-type': "application/json"
        //     },
        //     method: "delete",
        // }).then(function (result) {
        //     status = result.status;
        // })
        removeRow(itemForRemove)
    }

    function removeRow(settingForRemove) {
        changePropertySettings(propertySettings
            .filter(function (existedSetting) {
                return settingForRemove.property_id !== existedSetting.property_id;

            })
        )
    }

    function addNewRow() {
        const property = availableForAddingProperties()[0]
        const newData = {
            property_id: property.id,
            setting_type_id: 1,
            property: property,
            isEditable: true
        }
        changePropertySettings([newData, ...propertySettings])
    }

    function availableForAddingProperties(){
        return availableProperties.filter(function(loadedProperty){
            const setting = propertySettings.find(function(setting){
                return setting.property_id == loadedProperty.id
            })
            if(setting){
                return false;
            }
            return true;
        })
    }

    function propertyById(id) {
        return availableProperties.find(function (property) {
            return property.id == id;
        })
    }

    function optionsFor(setting) {
        return availableForAddingProperties().map(function(property){
            return {
                value: property.id,
                label: property.name
            }
        })
    }

    function buildOptionBy(setting) {
        // console.log(id,options())
        return {
            value: setting.property_id,
            label: propertyById(setting.property_id).name
        }
    }

    function commit(updatedItem) {
        // const list = [];
        // propertySettings.map(function (item) {
        //     console.log(item)
        //     if (item.property_id === updatedItem.property_id) {
        //         item.property_id = updatedItem.transactionData.property_id;
        //         item.setting_type_id = updatedItem.transactionData.setting_type_id;
        //         item.property = updatedItem.property
        //         item.transactionData = {};
        //         item.isEditable = false
        //
        //     }
        //     list.push(item)
        // })
        // changePropertySettings(list)
        // let status = 0;
        // let url = '';
        // let dataForUpsert = {};
        // if (Number.isInteger(updatedItem.id)) {
        //     url = `http://api.pricecheck.my:82/properties/change`;
        //     dataForUpsert = data.find(function (property) {
        //         return property.id === updatedItem.id
        //     })
        // } else {
        //     url = `http://api.pricecheck.my:82/properties/create`;
        //     dataForUpsert = {
        //         properties: data.filter(function (property) {
        //             return property.id === updatedItem.id
        //         })
        //     }
        // }
        // console.log(url, dataForUpsert)
        //
        // fetch(url, {
        //     body: JSON.stringify(dataForUpsert),
        //     headers: {
        //         'content-type': "application/json"
        //     },
        //     method: "POST",
        // }).then(function (result) {
        //     status = result.status;
        // })
    }

    function changeSetting(newOptionData, settingChanged) {
        const list = propertySettings.map(function(setting){
            if(setting.property_id==settingChanged.property_id){
                setting.property_id = newOptionData.value
                setting.property = propertyById(newOptionData.value)
            }
            return setting;
        })
        changePropertySettings(list);
    }

    function editableRow(setting) {
        return (
            <tr key={setting.property_id}>
                <td className="tabledit-edit-mode">
                    <Select
                        options={optionsFor(setting)}
                        defaultValue={buildOptionBy(setting)}
                        onChange={function(option){changeSetting(option, setting)}}
                        menuPosition={"fixed"}
                    >
                    </Select>
                </td>
                <td>
                    <div className="button-list">
                        <button type={"submit"} onClick={() => commit(setting)} className="btn btn-primary-rgba">
                            <i className="feather icon-save"></i>
                        </button>
                        <button type={"submit"} onClick={() => removeRow(setting)} className="btn btn-danger-rgba">
                            <i className={setting.id === parseInt(setting.id)
                                ? "feather icon-slash"
                                : "feather icon-trash"}>
                            </i>
                        </button>
                    </div>
                </td>
            </tr>
        );
    }

    function readebleRow(item) {
        return (
            <tr key={item.property_id}>
                <td>{item.property.name}</td>
                <td>
                    <div className="button-list">
                        <button type="button"
                                onClick={
                                    function () {
                                        removeOnBackend(item)
                                    }
                                }
                                className="btn btn-danger-rgba">
                            <i className="feather icon-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        )
    }

    return (
        <>
            <div className="btn-toolbar">
                <div className="btn-group focus-btn-group">
                    <button
                        onClick={addNewRow}
                        type="button"
                        className="btn btn-default">
                        <span className="glyphicon glyphicon-screenshot"></span>
                        Добавить
                    </button>
                </div>
            </div>
            <div className="table-responsive">
                <table className="table table-borderless table-hover">
                    <thead>
                    <tr>
                        <th width="5%">Название</th>
                        <th width="15%">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    {propertySettings.map(
                        function (setting) {
                            if (setting.isEditable) {
                                return editableRow(setting)
                            }
                            return readebleRow(setting)
                        })}
                    </tbody>
                </table>
            </div>
        </>
    );
}