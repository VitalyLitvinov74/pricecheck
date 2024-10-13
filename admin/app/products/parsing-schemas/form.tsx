'use client'
import React, {useState} from "react";
import Select from "react-select";
import {uuid} from "../../../utils/helpers";

export default function ParsingSchemaForm({availableProperties, parsingSchema}) {
    const startPairs = parsingSchema.parsingSchemaProperties.map(
        function (pairData) {
            return {
                id: pairData.id,
                propertyId: pairData.property_id,
                externalColumnName: pairData.external_column_name
            }
        })
    const [pairs, changePairs] = useState(startPairs)

    function removeRow(itemForRemove) {
        changePairs(pairs.filter(function (item) {
            return itemForRemove.id !== item.id
        }))
        if (itemForRemove.id === null) {
            return;
        }
    }

    function addNewRow() {
        changePairs([emptyPair(), ...pairs]);
    }

    function emptyPair() {
        return {
            id: uuid(),
            propertyId: availableForAddingProperties()[0].id,
            tableColumnName: null
        };
    }

    function availableForAddingProperties() {
        return availableProperties.filter(function (property) {
            let alreadyExist = false;
            for (let i = 0; i < pairs.length; i++) {
                if (pairs[i].propertyId === property.id) {
                    alreadyExist = true;
                    break;
                }
            }
            return !alreadyExist;
        })
    }

    function propertyById(id) {
        return availableProperties.find(function (property) {
            return property.id === id;
        })
    }

    function optionsFor(pair) {
        const availableOptions = availableForAddingProperties()
            .map(function (property) {
                return {
                    value: property.id,
                    label: property.name
                }
            })
        const currentOptions = {
            value: pair.propertyId,
            label: propertyById(pair.propertyId).name
        }
        return [currentOptions, ...availableOptions];
    }

    function propertyChanged(pair, option) {
        pair.propertyId = option.value;
        changePairs(pairs.slice())
    }

    function editableRow(pair) {
        return (
            <tr key={pair.id}>
                <td className="tabledit-edit-mode">
                    <Select
                        options={optionsFor(pair)}
                        defaultValue={optionsFor(pair)[0]}
                        isSearchable={true}
                        onChange={(option)=>{
                            propertyChanged(pair, option)
                        }}
                    />
                </td>
                <td className="tabledit-edit-mode">
                    <input
                        className="tabledit-input form-control input-sm"
                        type="text"
                        name="tableCollumnName"
                        defaultValue={pair.name}
                        placeholder="Например BA или А"
                    />
                </td>
                <td>
                    <div className="button-list">
                        <button type={"submit"} onClick={() => removeRow(pair)} className="btn btn-danger-rgba">
                            <i className="feather icon-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        );
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
                                   defaultValue={parsingSchema.name}
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
                                defaultValue={parsingSchema.start_with_row_num}
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
                            className="btn btn-default mr-2"
                            disabled={availableForAddingProperties().length < 1}
                        >
                            <i className="feather icon-plus mr-2"></i>
                            Добавить связку
                        </button>

                    </div>
                </div>
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
                            return editableRow(schemaPair)
                        })}
                    </tbody>
                </table>
            </div>
        </>
    );
}




