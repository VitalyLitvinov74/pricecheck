'use client'
import {useContext, useEffect} from "react";
import {ClientContext} from "../layout";

export default function ProductPage(){
    const {changeBreadcrumbsSettings} = useContext(ClientContext);
    return (
        <div className="contentbar">
            <div className="row">

                <div className="col-lg-12">
                    <div className="card m-b-30">
                        <div className="card-body">
                            <div className="table-responsive">
                                <table className="table table-borderless">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Categories</th>
                                        <th>Tags</th>
                                        <th>Orders</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">#1</th>
                                        <td><img src="assets/images/ecommerce/product_01.svg" className="img-fluid"
                                                 width="35" alt="product"/></td>
                                        <td>Apple MacBook Pro</td>
                                        <td className="text-success">In Stock</td>
                                        <td>$1,95,000</td>
                                        <td>Electronics, Computers</td>
                                        <td><span className="badge badge-secondary-inverse mr-2">Gaming</span><span
                                            className="badge badge-secondary-inverse">Popular</span></td>
                                        <td>205</td>
                                        <td>02/06/2019</td>
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
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}