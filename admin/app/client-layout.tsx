'use client'
import React, {Component, createContext} from "react";
import Breadcrumbs from "./breadcrumbs";

export const LayoutContext = createContext({})

export default class ClientLayout extends Component<any, any> {

    _breadcrumbsRef;

    constructor(props) {
        super(props);
        this._breadcrumbsRef = React.createRef();
    }

    render() {
        return (
            <LayoutContext.Provider
                value={{
                    breadcrumbs: this._breadcrumbsRef
                }}>
                <Breadcrumbs title={this.props.metadata.title} ref={this._breadcrumbsRef}/>
                {this.props.children}
            </LayoutContext.Provider>
        )
    }

}