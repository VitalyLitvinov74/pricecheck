import ParsingSchemaForm from "../../form";
import React from "react";
import {loadProperties} from "../../../../../src/shared/product-properties";
import {loadParsingSchema} from "../../../../../src/shared/parsing-schemas";
import {notFound} from "next/navigation";
import {metadata} from "../../../../layout";

export default async function UpdatePage({params}: { id: string }) {
    metadata.title= `Обновляем схему ${params.id}`
    const availableProperties = await loadProperties();

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
                            <ParsingSchemaForm availableProperties={availableProperties}
                                               parsingSchema={parsingSchema}
                                               isUpdate={true}
                            />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}