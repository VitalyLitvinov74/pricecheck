'use client'
import React, {useState} from "react";
import Select from "react-select";
import {uuid} from "../../../utils/helpers";

export default function ParsingSchemaForm({availableProperties, parsingSchema}) {
    console.log(availableProperties)
    const startPairs = parsingSchema.parsingSchemaProperties.map(
        function (pairData) {
            return {
                id: pairData.id,
                propertyId: pairData.property_id,
                externalColumnName: pairData.external_column_name
            }
        })
    const [pairs, changePairs] = useState(startPairs)
    function optionsFor(schemaItem = null) {
        let options: any;
        options = availableProperties
            .filter(function (property) {
                let needShow = true
                schemaItems.forEach(function (createdAttribute) {
                    if (createdAttribute.propertyId === property.id) {
                        needShow = false
                    }
                })
                return needShow
            })
            .map(function (property, key) {
                return {
                    value: property.id,
                    label: property.name
                }
            });
        if (attribute !== null) {
            options = [{
                value: attribute.propertyId,
                label: attribute.name
            }, ...options]
        }
        return options;
    }

    function removeRow(itemForRemove) {
        changePairs(pairs.filter(function (item) {
            return itemForRemove.id !== item.id
        }))
        if (itemForRemove.id === null) {
            return;
        }
    }

    function update(updatingItem) {
        if (updatingItem.isEditable) {
            return;
        }
        const result = [];
        pairs.forEach(function (item) {
            if (item.id === updatingItem.id) {
                result.push({
                    ...item, ...{
                        isEditable: true,
                        transactionData: {
                            name: updatingItem.name,
                            type: updatingItem.type
                        }
                    }
                })
                return;
            }
            result.push(item)
        })
        changePairs(result)
    }

    function rollback(currentItem) {
        changePairs(pairs
            .map(function (item) {
                if (item.id === currentItem.id) {
                    item.transactionData = {}
                    item.isEditable = false;
                }
                return item;
            })
            .filter(function (item) {
                if (currentItem.id === parseInt(currentItem.id)) {
                    return true; //Оставляем только прежде добавленные
                }
                return currentItem.id !== item.id;
            })
        )
    }

    function addNewRow() {
        changePairs([emptyPair(), ...pairs]);
        console.log(pairs)
    }

    function emptyPair() {
        return {
            id: uuid(),
            propertyId: availableForAddingProperties()[0].id,
            tableColumnName: null
        };
    }

    function availableForAddingProperties(){
        return availableProperties.filter(function(property){
            let alreadyExist = false;
            pairs.forEach(function(pair){
                alreadyExist = pair.propertyId === property.id
            })
            return !alreadyExist;
        })
    }

    function propertyById(id){
        return availableProperties.find(function(property){
            return property.id === id;
        })
    }


    function commit(updatedItem) {
        const list = [];
        pairs.map(function (item) {
            if (item.id === updatedItem.id) {
                item.name = updatedItem.transactionData.name;
                item.type = updatedItem.transactionData.type;
                item.transactionData = {};
                item.isEditable = false
            }
            list.push(item)
        })
        changePairs(list)
    }

    function editableRow(item) {
        return (
            <tr key={item.id}>
                <td className="tabledit-edit-mode">
                    <Select>

                    </Select>
                </td>
                <td className="tabledit-edit-mode">
                    <input
                        className="tabledit-input form-control input-sm"
                        type="text"
                        name="tableCollumnName"
                        onBlur={function (elem) {
                            item.transactionData.name = elem.target.value
                        }}
                        defaultValue={item.name}
                        placeholder="Например BA или А"
                    />
                </td>
                <td>
                    <div className="button-list">
                        <button type={"submit"} onClick={() => commit(item)} className="btn btn-primary-rgba">
                            <i className="feather icon-save"></i>
                        </button>

                        <button type={"submit"} onClick={() => rollback(item)} className="btn btn-danger-rgba">
                            <i className={item.id === parseInt(item.id)
                                ? "feather icon-slash"
                                : "feather icon-trash"}>
                            </i>
                        </button>
                    </div>
                </td>
            </tr>
        );
    }

    function readebleRow(pair) {
        return (
            <tr key={pair.id}>
                <td>{propertyById(pair.propertyId).name}</td>
                <td>
                    {pair.externalColumnName}
                </td>
                <td>
                    <div className="button-list">
                        <button onClick={() => {
                            update(pair)
                        }} className="btn btn-success-rgba">
                            <i className="feather icon-edit-2"></i>
                        </button>
                        <button type="button"
                                onClick={
                                    function () {
                                        removeRow(pair)
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
            <div className="card-body">
                <button type="button" className="btn btn-success mr-2"><i
                    className="feather icon-save mr-2"></i> Сохранить
                </button>
            </div>
            <div className="card-body">
                <div className="row">
                    <div className="col-md-3">
                        <h6 className="card-subtitle">Наименование</h6>
                        <div className="form-group">
                            <input type="text"
                                   className="form-control"
                                   name="inputPlaceholder" id="inputPlaceholder"
                                   placeholder="Имя схемы парсинга для быстрой ориентации"
                                   value={parsingSchema.name}
                            />
                        </div>
                    </div>
                    <div className="col-md-3">
                        <h6 className="card-subtitle">Начинать парсить со строки (включительно)</h6>
                        <div className="form-group">
                            <input
                                type="number"
                                className="form-control"
                                name="inputPlaceholder"
                                placeholder=""
                                value={parsingSchema.start_with_row_num}
                            />
                        </div>
                    </div>
                </div>

            </div>
            <div className="card-body">
                <div className="btn-toolbar">
                    <div className="btn-group focus-btn-group">
                        <button
                            onClick={addNewRow}
                            type="button"
                            className="btn btn-default mr-2">
                            <i className="feather icon-plus mr-2"></i>
                            Добавить связку
                        </button>

                    </div>
                </div>
                <div className="table-responsive">
                    <table className="table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th width="10%">Свойство</th>
                            <th width="10%">Столбец в таблце</th>
                            <th width="15%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        {pairs.map(
                            function (schemaPair) {
                                if (schemaPair.isEditable) {
                                    return editableRow(schemaPair)
                                }
                                return readebleRow(schemaPair)
                            })}
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    );
}




