'use client'
import React, {useState} from "react";
import Select from "react-select";

export default function PropertiesTable({datas, availableTypes}) {
    datas = datas.map(function (item) {
        item.transactionData = {};
        item.isEditable = false;
        return item;
    })
    const [data, changeData] = useState(datas)

    function removeRow(itemForRemove) {
        changeData(data.filter(function (item) {
            return itemForRemove.id !== item.id
        }))
        if (itemForRemove.id === null) {
            return;
        }
        const url = `http://api.pricecheck.my:82/properties/remove`;
        let status = 0;
        fetch(url, {
            body: JSON.stringify({
                id: itemForRemove.id
            }),
            headers: {
                'content-type': "application/json"
            },
            method: "delete",
        }).then(function (result) {
            status = result.status;
        })
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
                if(currentItem.id === parseInt(currentItem.id)){
                    return true; //Оставляем только прежде добавленные
                }
                return currentItem.id !== item.id;
            })
        )
    }

    function editableRow(item) {
        return (
            <tr key={item.id}>
                <td className="tabledit-edit-mode"><input
                    className="tabledit-input form-control input-sm" type="text"
                    readOnly={true} value={item.id === parseInt(item.id) ? '#' + item.id : '##'}/></td>
                <td className="tabledit-edit-mode">
                    <input
                        className="tabledit-input form-control input-sm"
                        type="text"
                        name="name"
                        onBlur={function (elem) {
                            item.transactionData.name = elem.target.value
                        }}
                        defaultValue={item.name}
                    />
                </td>
                <td className="tabledit-edit-mode">
                    <Select
                        options={options()}
                        defaultValue={function () {
                            return optionByName(item.type)
                        }}
                        onChange={
                            function (option) {
                                item.transactionData.type = option.value
                            }
                        }
                    >
                    </Select>
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
                <td>#{item.id === parseInt(item.id) ? item.id : '#'}</td>
                <td>{item.name}</td>
                <td>
                    <span className="badge badge-secondary-inverse mr-2">
                        {item.type}
                    </span>
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
            id: "_" + Date.now(),
            name: "Тест",
            type: availableTypes[0],
            isEditable: true,
            transactionData: {
                name: "Тест",
                type: availableTypes[0],
            }
        };
        changeData([newData, ...data]);
    }

    function options() {
        let options: any;
        options = availableTypes.map(function (type, key) {
            return {value: type, label: type}
        });
        return options;
    }

    function optionByName(name) {
        return options().find(function (option) {
            return option.value === name;
        })
    }

    function commit(updatedItem) {
        const list = [];
        data.map(function(item){
            if (item.id === updatedItem.id) {
                item.name = updatedItem.transactionData.name;
                item.type = updatedItem.transactionData.type;
                item.transactionData = {};
                item.isEditable = false
            }
            list.push(item)
        })
        changeData(list)
        let status = 0;
        let url = '';
        let dataForUpsert = {};
        if(Number.isInteger(updatedItem.id)){
            url = `http://api.pricecheck.my:82/properties/change`;
            dataForUpsert = data.find(function(property){
                return property.id === updatedItem.id
            })
        }else{
            url = `http://api.pricecheck.my:82/properties/create`;
            dataForUpsert = {
                properties: data.filter(function(property){
                    return property.id === updatedItem.id
                })
            }
        }
        console.log(url, dataForUpsert)

        fetch(url, {
            body: JSON.stringify(dataForUpsert),
            headers: {
                'content-type': "application/json"
            },
            method: "POST",
        }).then(function (result) {
            status = result.status;
        })
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
                        <th width="5%">ID</th>
                        <th width="20%">Название</th>
                        <th width="10%">Тип</th>
                        <th width="15%">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    {data.map(
                        function (property) {
                            if (property.isEditable) {
                                return editableRow(property)
                            }
                            return readebleRow(property)
                        })}
                    </tbody>
                </table>
            </div>
        </>
    );
}




