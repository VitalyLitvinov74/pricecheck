'use client'
import React from "react";
import {LayoutContext} from "../layout";

export default class ProductPropertiesPage extends React.Component<any, any> {

    constructor(props) {
        super(props);
        this.state = {
            propertiesData: props.data,
        }
        this.addNewRow = this.addNewRow.bind(this)
        this.remove = this.remove.bind(this)
        ProductPropertiesPage.contextType = LayoutContext;
    }

   componentDidMount() {
       this.context.changeData(
           {
               metadata: {
                   title: this.props.title
               }
           }
       )
   }

    addNewRow() {
        const newData = {
            name: "Тест",
            type: "striing",
        };
        this.setState({
            propertiesData: [newData, ...this.state.propertiesData]
        })
    }

    remove(item){
        this.setState({
            propertiesData: this.state.propertiesData.filter(function(oldProp){
                return oldProp.id !== item.id
            })
        })
    }

    render() {
        let self = this;
        return (
            <div className="contentbar">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="card m-b-30">
                            <div className="card-body">
                                <div className="btn-toolbar">
                                    <div className="btn-group focus-btn-group">
                                        <button onClick={this.addNewRow} type="button" className="btn btn-default"><span
                                            className="glyphicon glyphicon-screenshot"></span>
                                            Focus
                                        </button>
                                    </div>
                                </div>
                                <div className="table-responsive">
                                    <table className="table table-borderless table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Название</th>
                                            <th>Тип</th>
                                            <th>Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {
                                            this.state.propertiesData.map(function (property, key) {
                                            return (
                                                <tr key={key}>
                                                    <td>#{property.id ? property.id : '#'}</td>
                                                    <td>{property.name}</td>
                                                    <td>
                                                    <span
                                                        className="badge badge-secondary-inverse mr-2">{property.type}</span>
                                                    </td>
                                                    <td>
                                                        <div className="button-list">
                                                            <a href="#" className="btn btn-success-rgba"><i
                                                                className="feather icon-edit-2"></i></a>
                                                            <button onClick={()=>self.remove(property)} type="button" className="btn btn-danger-rgba"><i
                                                                className="feather icon-trash"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            )
                                        })}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        );
    }
}