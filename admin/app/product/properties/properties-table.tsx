'use client'
import React, {useState} from "react";
import Select from "react-select";

export default function PropertiesTable({datas, availableTypes}) {

    const [draftedRows, addDraftRow] = useState([])
    const [data, changeData] = useState(datas)

    function propertyIsDraft(item)
    {
        const result = draftedRows.find(
            function (activeItem) {
                return activeItem.id === item.id
            }
        )
        return result === undefined ? false : true;
    }

    function removeRow(item)
    {
        changeData(data.filter(function (oldProp) {
            return oldProp.id !== item.id
        }))

        // const url = `http://api.pricecheck.my:82/product-property/remove`;
        // let status = 0;
        // fetch(url, {
        //     body: JSON.stringify({
        //         id: item.id
        //     }),
        //     headers: {
        //         'content-type': "application/json"
        //     },
        //     method: "post",
        // }).then(function (result) {
        //     status = result.status;
        // })
    }

    function update(item)
    {
        if(propertyIsDraft(item)){
            return;
        }
        addDraftRow([item, ...draftedRows])
    }

    function editableRow(item, key)
    {
        return (
            <tr key={key}>
                <td className="tabledit-edit-mode"><input
                    className="tabledit-input form-control input-sm" type="text"
                    readOnly={true} value={item.id}/></td>
                <td className="tabledit-edit-mode">
                    <input
                        className="tabledit-input form-control input-sm"
                        type="text"
                        name="name"
                        onBlur={function (elem) {
                            item.name = elem.target.value
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
                                item.type = option.value
                            }
                        }
                    >
                    </Select>
                </td>
                <td>
                    <div className="button-list">
                        <button type={"submit"} onClick={() => commitRow(item)} className="btn btn-primary-rgba">
                            <i className="feather icon-save"></i>
                        </button>
                    </div>
                </td>
            </tr>
        );
    }

    function readebleRow(item, key)
    {
        return (
            <tr key={key}>
                <td>#{item.id ? item.id : '#'}</td>
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

    function addNewRow () {
        const newData = {
            name: "Тест",
            type: "striing",
        };
        changeData([newData, ...data])
    }

    function options()
    {
        let options: any;
        options = availableTypes.map(function (type, key) {
            return {value: type, label: type}
        });
        return options;
    }

    function optionByName(name)
    {
        return options().find(function (option) {
            return option.value === name;
        })
    }

    function test()
    {
        console.log('hello')
    }

    function draftRowByIdItem(id)
    {
        return draftedRows.find(
            function (draftRow) {
                return draftRow.id === id
            }
        )
    }

    function commitRow(draftItem)
    {
        const draftRows = this.state.draftRows;
        let keyForRemoveRow = null;
        draftRows.forEach(function (draftRow, key) {
            if (draftRow.id === draftItem.id) {
                keyForRemoveRow = key;
            }
        })
        draftRows.splice(keyForRemoveRow, 1)
        this.setState({
            draftRows: draftRows
        })
        this.props.data.forEach(function (property) {
            if (property.id === draftItem.id) {
                property.name = draftItem.name;
                property.type = draftItem.type;
            }
        })
        let status = 0;
        const url = `http://api.pricecheck.my:82/product-property/create-list`;
        fetch(url, {
            body: JSON.stringify({
                properties: [draftItem]
            }),
            headers: {
                'content-type': "application/json"
            },
            method: "post",
        }).then(function (result) {
            status = result.status;
        })
        this.setState({data: this.props.data})
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
                        function (property, key) {
                            if (propertyIsDraft(property)) {
                                return editableRow(
                                    draftRowByIdItem(property.id),
                                    key
                                )
                            }
                            return readebleRow(property, key)
                        })}
                    </tbody>
                </table>
            </div>
        </>
    );
}




