'use client'
import React from "react";

export default class Breadcrumbs extends React.Component<any, any> {
    constructor(props) {
        super(props);
        this.state = {
            title: props.title
        }
    }

    changeTitleTo(newTitle){

        if(this.hasTitle(newTitle)){
            return;
        }
        this.setState({
            title: newTitle
        })
    }

    hasTitle(title){
        return this.state.title == title;
    }

    render() {
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