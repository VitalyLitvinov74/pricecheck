'use client'
import React from "react";
import {LayoutContext} from "../layout";
import PropertiesTable from "./properties-table";

export default class ProductPropertiesPage extends React.Component<any, any> {

    constructor(props) {
        super(props);
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


    render() {
        return (
            <div className="contentbar">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="card m-b-30">
                            <div className="card-body">
                                <div className="btn-toolbar">
                                    <div className="btn-group focus-btn-group">
                                        <button type="button" className="btn btn-default"><span
                                            className="glyphicon glyphicon-screenshot"></span>
                                            Focus
                                        </button>
                                    </div>
                                </div>
                                <div className="table-responsive">
                                    <PropertiesTable data={this.props.data}
                                                     availableTypes={this.props.availableTypes}
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