'use client'
import {Component, createContext} from "react";

export const LayoutContext = createContext({})

export default class ClientLayout extends Component<any, any>{
    constructor(props) {
        super(props);
    }

    render() {
        return <LayoutContext.Provider value={{
            metadata: this.props.metadata,
            changeData: this.setState
        }}>
            {this.props.children}
        </LayoutContext.Provider>
    }

}