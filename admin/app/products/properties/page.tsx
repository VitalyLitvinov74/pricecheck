import {availableTypes} from "../../../src/shared/product-properties";
import {metadata} from "../../layout";
import React, {useState} from "react";
import PropertiesTable from "./properties-table";
import {loadGeneralProperties} from "../../../src/shared/api/products-api";

export default async function ProductProperties() {

    metadata.title = "Свойства товаров"
    // console.log(metadata)

    const properties = await loadGeneralProperties();

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
                            <PropertiesTable datas={properties}
                                             availableTypes={types}
                            />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}