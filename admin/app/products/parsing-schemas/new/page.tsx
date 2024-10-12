import React, {useState} from "react";
import {metadata} from "../../../layout";
import NewParsingSchemaForm from "./form";
import {availableTypes, loadProperties} from "../../../../utils/product-properties";

export default async function NewParsingSchema() {

    metadata.title = "Создать схему парсинга"
    // console.log(metadata)

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
                            <NewParsingSchemaForm datas={properties}
                                             availableTypes={types}
                            />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}