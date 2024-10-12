'use client'
import React, {useState} from "react";
import Select from "react-select";
import {v4 as uuidv4} from "uuid";

export default function NewParsingSchemaForm({properties, exitedSchemaItems}) {
    exitedSchemaItems = exitedSchemaItems.map(
        function (item) {
            item.transactionData = {};
            item.isEditable = false;
            return item;
        })
    const [data, changeData] = useState(properties)
    const [schemaItems, changeSchemaItems] = useState(exitedSchemaItems)

    function optionsFor(schemaItem = null) {
        let options: any;
        options = properties
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
        changeData(data.filter(function (item) {
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
        data.forEach(function (item) {
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
        changeData(result)
    }

    function rollback(currentItem) {
        changeData(data
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

    function readebleRow(item) {
        return (
            <tr key={item.id}>
                {/*Если строка то это новый айтем*/}
                <td>{item.name}</td>
                <td>
                    {item.name}
                </td>
                <td>
                    <div className="button-list">
                        <button onClick={() => {
                            update(item)
                        }} className="btn btn-success-rgba">
                            <i className="feather icon-edit-2"></i>
                        </button>
                        <button type="button"
                                onClick={
                                    function () {
                                        removeRow(item)
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

    function addNewRow() {
        const newData = {
            id: uuidv4(),
            name: "",
            isEditable: true,
            transactionData: {
                name: "",
            }
        };
        changeData([newData, ...data]);
    }

    function commit(updatedItem) {
        const list = [];
        data.map(function (item) {
            if (item.id === updatedItem.id) {
                item.name = updatedItem.transactionData.name;
                item.type = updatedItem.transactionData.type;
                item.transactionData = {};
                item.isEditable = false
            }
            list.push(item)
        })
        changeData(list)
    }

    return (
        <>
            <div class="card-body">
                <button type="button" class="btn btn-success mr-2"><i class="feather icon-save mr-2"></i> Сохранить
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <h6 class="card-subtitle">Наименование</h6>
                        <div class="form-group">
                            <input type="text" class="form-control" name="inputPlaceholder" id="inputPlaceholder"
                                   placeholder="Имя схемы парсинга для быстрой ориентации"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h6 class="card-subtitle">Начинать парсить со строки (включительно)</h6>
                        <div class="form-group">
                            <input type="number" class="form-control" name="inputPlaceholder" placeholder=""/>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
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
                        {schemaItems.map(
                            function (schemaItem) {
                                if (schemaItem.isEditable) {
                                    return editableRow(schemaItem)
                                }
                                return readebleRow(schemaItem)
                            })}
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    );
}




