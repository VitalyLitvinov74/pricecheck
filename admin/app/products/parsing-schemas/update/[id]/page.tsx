import ParsingSchemaForm from "../../form";
import React from "react";
import {loadProperties} from "../../../../../utils/product-properties";
import {loadParsingSchema} from "../../../../../utils/parsing-schemas";
import {notFound} from "next/navigation";

export default async function UpdatePage({params}: { id: string }) {
    let properties = [];
    await loadProperties().then(
        function (data) {
            properties = data;
        }
    );

    let parsingSchema = null;
    await loadParsingSchema(params.id).then(
        function (data) {
            parsingSchema = data;
        });

    if (!parsingSchema) {
        return notFound()
    }
    return (
        <div className="contentbar">
            <div className="row">
                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <ParsingSchemaForm availableProperties={properties}
                                               exitedSchemaItems={[]}
                                               parsingSchema={parsingSchema}
                            >
                            </ParsingSchemaForm>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}