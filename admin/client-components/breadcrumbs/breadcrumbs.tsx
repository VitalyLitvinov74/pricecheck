'use client'
import React, {useContext, useState} from "react";
import Link from "next/link";
export default function Breadcrumbs({path, title, children: buttons }){
    return (
        <div className="breadcrumbbar">
            <div className="row align-items-center">
                <div className="col-md-8 col-lg-8">
                    <h4 className="page-title">{title}</h4>
                    <div className="breadcrumb-list">
                        <ol className="breadcrumb">
                            {path.map(function(itemPath, key){
                                if(itemPath.isCurrent){
                                    return (
                                        <li key={key} className="breadcrumb-item" aria-current="page"><a>{itemPath.title}</a></li>
                                    )
                                }
                                return (
                                    <li key={key} className="breadcrumb-item">
                                        <Link href={itemPath.link}>{itemPath.title}</Link>
                                    </li>
                                );
                            })}
                        </ol>
                    </div>
                </div>
                <div className='col-md-4 col-lg-4'>
                    <div className="widgetbar">
                        {buttons}
                    </div>
                </div>
            </div>
        </div>
    )
}