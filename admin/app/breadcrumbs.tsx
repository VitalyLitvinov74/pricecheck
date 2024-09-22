'use client'
import React, {useContext} from "react";
import {LayoutContext} from "./client-layout";

export default class Breadcrumbs extends React.Component<any, any> {
    constructor(props) {
        super(props);
        this.state = {
            title: props.title
        }
        Breadcrumbs.contextType = LayoutContext
    }

    render(){
        return (
                <div className="breadcrumbbar">
                    <div className="row align-items-center">
                        <div className="col-md-8 col-lg-8">
                            <h4 className="page-title">{this.context.metadata.title}</h4>
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
}