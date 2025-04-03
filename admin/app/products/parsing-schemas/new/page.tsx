import React, {useState} from "react";
import {metadata} from "../../../layout";
import ParsingSchemaForm from "../form";
import {availableTypes, loadProperties} from "../../../../src/shared/product-properties";
import {randomUUID} from "crypto";

export default async function NewParsingSchema() {

    metadata.title = "Создать схему парсинга"

    const properties = await loadProperties();

    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <ParsingSchemaForm availableProperties={properties}
                                               parsingSchema={{
                                                   id: randomUUID(),
                                                   name: null,
                                                   start_with_row_num: 1,
                                                   parsingSchemaProperties: []
                                               }}
                                               isUpdate={false}
                            />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}