
"use-client"
import React from "react";

export default function Table({}) {
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
                                <a href="#" className="btn btn-success-rgba"><i
                                    className="feather icon-edit-2"></i></a>
                                <a href="#" className="btn btn-danger-rgba"><i
                                    className="feather icon-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </>
    )
}