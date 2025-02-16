'use client'
import React, {useState} from "react";
import Select from "react-select";
import {uuid} from "../../../utils/helpers"
import {useRouter} from "next/navigation";
import revalidateParsingSchemaData from "../../actions/RevalidateParsingSchema";

export default function ParsingSchemaForm({availableProperties, parsingSchema, isUpdate}) {
    const startPairs = parsingSchema.parsingSchemaProperties.map(
        function (pairData) {
            return {
                id: pairData.id,
                propertyId: pairData.property_id,
                externalColumnName: pairData.external_column_name
            }
        })
    const [pairs, changePairs] = useState(startPairs)
    const [name, changeName] = useState(parsingSchema.name)
    const [startWithRowNum, changeRowNum] = useState(parsingSchema.start_with_row_num)
    const {push} = useRouter()

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
            externalColumnName: null
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

    function changePair(pair, optionForProperty = null, externalColumnName = null){
        const newPairs = pairs.slice()
            .map(function (existedPair) {
                if(existedPair.id !== pair.id){
                    return existedPair
                }
                if(optionForProperty !== null){
                    existedPair.propertyId = optionForProperty.value
                }
                if(externalColumnName !== null){
                    existedPair.externalColumnName = externalColumnName
                }
                return existedPair
            });
        changePairs(newPairs)
    }

    function dataForBackend() {
        return {
            id: parsingSchema.id,
            name: name,
            startWithRowNum: startWithRowNum,
            map: pairs.map(function (pair) {
                return {
                    id: pair.id,
                    productProperty: {
                        id: pair.propertyId
                    },
                    externalFieldName: pair.externalColumnName
                }
            })
        }
    }

    const router = useRouter()
    async function upsert(action){
        let status = 204;
        const url = `http://api.pricecheck.my:82/parsing-schemas/${action}`;
        await fetch(url, {
            body: JSON.stringify(dataForBackend()),
            headers: {
                'content-type': "application/json"
            },
            method: "post",
        }).then(function (result) {
            status = result.status;
        })
        if(status === 204){
            await revalidateParsingSchemaData(parsingSchema.id)
            router.push("/products/parsing-schemas")
        }
    }

    function editableRow(pair) {
        return (
            <tr key={pair.id}>
                <td className="tabledit-edit-mode">
                    <Select
                        name="map"
                        options={optionsFor(pair)}
                        defaultValue={optionsFor(pair)[0]}
                        isSearchable={true}
                        onChange={(option) => {
                            changePair(pair, option)
                        }}
                       menuPosition={"fixed"}
                    />
                </td>
                <td className="tabledit-edit-mode">
                    <input
                        className="tabledit-input form-control input-sm"
                        type="text"
                        name="tableCollumnName"
                        defaultValue={pair.externalColumnName}
                        onBlur={(e) => {
                            changePair(pair, null, e.target.value)
                        }}
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
                <button
                    type="button"
                    className="btn btn-success mr-2"
                    onClick={() => {
                        isUpdate ? upsert('update') : upsert('create')
                    }}
                >
                    <i className="feather icon-save mr-2"></i>
                    {isUpdate ? "Сохранить" : "Создать"}
                </button>
            </div>
            <div className="card-body">
                <div className="row">
                    <div className="col-md-3">
                        <h6 className="card-subtitle">Наименование</h6>
                        <div className="form-group">
                            <input type="text"
                                   className="form-control"
                                   name="name" id="inputPlaceholder"
                                   placeholder="Имя схемы парсинга для быстрой ориентации"
                                   defaultValue={name}
                                   onChange={(e) => {
                                       changeName(e.target.value)
                                   }}
                            />
                        </div>
                    </div>
                    <div className="col-md-3">
                        <h6 className="card-subtitle">Начинать парсить со строки (включительно)</h6>
                        <div className="form-group">
                            <input
                                type="number"
                                className="form-control"
                                name="startWithRowNum"
                                placeholder=""
                                defaultValue={startWithRowNum}
                                onChange={(e) => {
                                    changeRowNum(e.target.value)
                                }}
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




