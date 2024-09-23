import {availableTypes, loadProperties} from "../../../utils/product-properties";
import ProductPropertiesPage from "../../../client-components/product-properties/product-properties-page";
import {metadata} from "../../layout";
import PropertiesTable from "./properties-table";
import React from "react";

export default async function ProductProperties() {

    metadata.title = "Свойства товаров"

    let properties = [];
    await loadProperties().then(
        function (data) {
            properties = data;
        }
    );

    let types = [];
    await availableTypes().then(
        function (data) {
            types = data;
        }
    );

    return (
            <div className="contentbar">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="card m-b-30">
                            <div className="card-body">
                                    <PropertiesTable data={properties}
                                                     availableTypes={types}
                                                     metadata={metadata}
                                    />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    );
}