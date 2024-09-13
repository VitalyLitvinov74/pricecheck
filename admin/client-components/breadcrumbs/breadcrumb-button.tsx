'use client'
import React from "react";

export default function BreadcrumbButton({onClick, title, className ="btn btn-primary-rgba" , iconClass = 'feather icon-plus mr-2', }){
    return(
        <button onClick={onClick} className={className}><i className={iconClass}></i>{title}
        </button>
    );
}