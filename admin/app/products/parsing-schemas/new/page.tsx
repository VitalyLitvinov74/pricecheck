import React, {useState} from "react";
import {metadata} from "../../../layout";
import ParsingSchemaForm from "../form";
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

    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <ParsingSchemaForm availableProperties={properties}
                                                  exitedSchemaItems={[]}
                            />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}