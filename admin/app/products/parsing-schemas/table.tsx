"use client"
import Link from "next/link";
import React from "react";

export default function Table({}) {
    function remove(id){
        console.log('send request to remove')
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
                    <tr>
                        <th scope="row">#1</th>
                        <td>
                            <div className="button-list">
                                <Link href="/products/parsing-schemas/update" className="btn btn-success-rgba">
                                    <i className="feather icon-edit-2"></i>
                                </Link>
                                <button onClick={ () => remove(2) }
                                        className="btn btn-danger-rgba">
                                    <i className="feather icon-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </>
    )
}