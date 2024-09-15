'use client'
import React, {Component, createContext, useEffect} from "react";
import Breadcrumbs from "./breadcrumbs/Breadcrumbs";

export const LayoutContext = createContext({
    metadata: [],
    changeData: function(newData){}
});

export default class Layout extends Component<any, any> {
    static contextType = LayoutContext;
    private children;

    constructor(props) {
        super(props);
        this.children = props.children;
        this.state = {
            metadata: props.serverMetadata,
        }
        this.setState = this.setState.bind(this)
    }

    render() {
        return <LayoutContext.Provider value={{
            metadata: this.state.metadata,
            changeData: this.setState
        }}>
            <Breadcrumbs/>
            {this.children}
        </LayoutContext.Provider>
    }
}