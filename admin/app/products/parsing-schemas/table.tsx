"use client"
import Link from "next/link";
import React, {useState} from "react";

export default function Table({parsingSchemas}) {
    const [schemas, changeSchemas] = useState(parsingSchemas)

    async function remove(id) {
        const url = `http://api.pricecheck.my:82/parsing-schemas/remove?id=${id}`;
        await fetch(url, {
            method: "delete",
            headers: {
                'content-type': "application/json"
            },
            body: JSON.stringify({id: id})
        }).then(function(result){
            if(result.status === 204){
                changeSchemas(schemas.filter(
                    function(schema){
                        return schema.id !== id
                    }
                ))
            }
        })

    }

    return (
        <>
            <div className="table-responsive">
                <table className="table table-borderless">
                    <thead>
                    <tr>
                        <th>Наименование</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    {
                        schemas.map(function (schema) {
                            return (
                                <tr key={schema.id}>
                                    <th scope="row">{schema.name}</th>
                                    <td>
                                        <div className="button-list">
                                            <Link href={`/products/parsing-schemas/update/${schema.id}`}
                                                  className="btn btn-success-rgba">
                                                <i className="feather icon-edit-2"></i>
                                            </Link>
                                            <button onClick={() => remove(schema.id)}
                                                    className="btn btn-danger-rgba">
                                                <i className="feather icon-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            )
                        })
                    }
                    </tbody>
                </table>
            </div>
        </>
    )
}