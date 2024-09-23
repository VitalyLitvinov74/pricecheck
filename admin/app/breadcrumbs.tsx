'use client'
import {usePathname} from "next/navigation";
import {titleByPath} from "../utils/route-titles-map";
import {useState} from "react";

export default function Breadcrumbs({titlee}){
    const [title, changeTitle] = useState(titlee);

    if(title !== titleByPath(usePathname())){
        const newTitle = titleByPath(usePathname())
        changeTitle(newTitle)
    }

    return (
        <div className="breadcrumbbar">
            <div className="row align-items-center">
                <div className="col-md-8 col-lg-8">
                    <h4 className="page-title">{title}</h4>
                    <div className="breadcrumb-list">
                        {/*<ol className="breadcrumb">*/}
                        {/*    {breadcrumbsSettings.path.map(function(itemPath, key){*/}
                        {/*        if(itemPath.isCurrent){*/}
                        {/*            return (*/}
                        {/*                <li key={key} className="breadcrumb-item" aria-current="page"><a>{itemPath.title}</a></li>*/}
                        {/*            )*/}
                        {/*        }*/}
                        {/*        return (*/}
                        {/*            <li key={key} className="breadcrumb-item">*/}
                        {/*                <Link href={itemPath.link}>{itemPath.title}</Link>*/}
                        {/*            </li>*/}
                        {/*        );*/}
                        {/*    })}*/}
                        {/*</ol>*/}
                    </div>
                </div>
            </div>
        </div>
    );
}