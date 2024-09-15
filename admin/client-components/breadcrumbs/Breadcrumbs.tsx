'use client'
import React, {useContext} from "react";
import {ClientContext} from "../layout";

export default class Breadcrumbs extends React.Component<any, any> {
    constructor({title}) {
        super({});
        this.state = {
            title: title
        }
        this.changeTitle = this.changeTitle.bind(this)
    }

    changeTitle(newTitle :string){
        this.setState({
            title: newTitle
        })
    }

    render(){
        return (
            <div className="breadcrumbbar">
                <div className="row align-items-center">
                    <div className="col-md-8 col-lg-8">
                        <h4 className="page-title">{this.state.title}</h4>
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