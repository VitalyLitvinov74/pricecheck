import React, {Component} from "react";
import Select from "react-select";

export default class PropertiesTable extends Component<any, any> {
    constructor(props) {
        super(props);
        this.state = {
            draftRows: [],
            data: this.props.data
        }
        this.addNewRow = this.addNewRow.bind(this)
        this.removeRow = this.removeRow.bind(this)
        this.update = this.update.bind(this)
        this.commitRow = this.commitRow.bind(this)
    }

    addNewRow() {
        const newData = {
            name: "Тест",
            type: "striing",
        };
        this.setState({
            data: [newData, ...this.props.data]
        })
    }

    removeRow(item) {
        this.setState({
            data: this.state.data.filter(function (oldProp) {
                return oldProp.id !== item.id
            })
        })

        const url = `http://api.pricecheck.my:82/product-property/remove`;
        let status = 0;
        fetch(url, {
            body: JSON.stringify({
                id: item.id
            }),
            headers: {
                'content-type': "application/json"
            },
            method: "post",
        }).then(function (result) {
            status = result.status;
        })
    }

    update(item) {
        const result = this.state.draftRows.find(function (activedItem) {
            return activedItem.id === item.id
        })
        if (result !== undefined) {
            return;
        }
        this.setState({
            draftRows: [item, ...this.state.draftRows]
        })
    }

    propertyIsDraft(item) {
        const result = this.state.draftRows.find(
            function (activeItem) {
                return activeItem.id === item.id
            }
        )
        return result === undefined ? false : true;
    }

    options() {
        let options: any;
        options = this.props.availableTypes.map(function (type, key) {
            return {value: type, label: type}
        });
        return options;
    }

    optionByName(name) {
        return this.options().find(function (option) {
            return option.value === name;
        })
    }

    test() {
        console.log('hello')
    }

    draftRowByIdItem(id) {
        return this.state.draftRows.find(
            function (draftRow) {
                return draftRow.id === id
            }
        )
    }

    commitRow(draftItem) {
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

    editableRow(item, key) {
        const options = this.options();
        const self = this;
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
                        options={options}
                        defaultValue={function () {
                            return self.optionByName(item.type)
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
                        <button type={"submit"} onClick={() => self.commitRow(item)} className="btn btn-primary-rgba">
                            <i className="feather icon-save"></i>
                        </button>
                    </div>
                </td>
            </tr>
        );
    }

    readebleRow(item, key) {
        const self = this;
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
                            this.update(item)
                        }} className="btn btn-success-rgba">
                            <i className="feather icon-edit-2"></i>
                        </button>
                        <button type="button"
                                onClick={
                                    function () {
                                        self.removeRow(item)
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

    render() {
        const self = this;
        const data = this.state.data
        return (
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
                        if (self.propertyIsDraft(property)) {
                            return self.editableRow(
                                self.draftRowByIdItem(property.id),
                                key
                            )
                        }
                        return self.readebleRow(property, key)
                    })}
                </tbody>
            </table>
        )
    }
}