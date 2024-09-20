'use client'
import React from "react";
import {LayoutContext} from "../layout";
import PropertiesTable from "./properties-table";

export default class ProductPropertiesPage extends React.Component<any, any> {

    private tableRef;
    constructor(props) {
        super(props);
        ProductPropertiesPage.contextType = LayoutContext;
        this.addTableRow = this.addTableRow.bind(this)
        this.state = {
            rowsAdded: 0
        }
        this.tableRef = React.createRef();
    }

    componentDidMount() {
        if(this.context.metadata.title !== this.props.title){
            this.context.changeData(
                {
                    metadata: {
                        title: this.props.title
                    }
                }
            )
        }
    }

    addTableRow(){
       console.log(this.tableRef.current.addNewRow())
    }


    render() {
        return (
            <div className="contentbar">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="card m-b-30">
                            <div className="card-body">
                                <div className="btn-toolbar">
                                    <div className="btn-group focus-btn-group">
                                        <button
                                            onClick={this.addTableRow}
                                            type="button"
                                            className="btn btn-default">
                                            <span className="glyphicon glyphicon-screenshot"></span>
                                            Добавить
                                        </button>
                                    </div>
                                </div>
                                <div className="table-responsive">
                                    <PropertiesTable data={this.props.data}
                                                     availableTypes={this.props.availableTypes}
                                                     ref={this.tableRef}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        );
    }
}