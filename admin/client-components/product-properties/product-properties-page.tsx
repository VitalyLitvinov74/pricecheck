'use client'
import React from "react";

export default class ProductPropertiesPage extends React.Component<any, any> {
    constructor({data, title, breadcrumbs}) {
        super({data, title});
        this.state = {
            propertiesData: data,
        }
        this.test = this.test.bind(this)
        breadcrumbs.changeTitle(title);
    }

    test() {
        const newData = {
            id: 222,
            name: "Тест",
            type: "striing",
        };
        this.setState({
            propertiesData: [newData, ...this.state.propertiesData]
        })
    }

    render() {
        return (
            <div className="contentbar">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="card m-b-30">
                            <div className="card-body">
                                <div className="btn-toolbar">
                                    <div className="btn-group focus-btn-group">
                                        <button onClick={this.test} type="button" className="btn btn-default"><span
                                            className="glyphicon glyphicon-screenshot"></span>
                                            Focus
                                        </button>
                                    </div>
                                </div>
                                <div className="table-responsive">
                                    <table className="table table-borderless table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Название</th>
                                            <th>Тип</th>
                                            <th>Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {this.state.propertiesData.map(function (property, key) {
                                            return (
                                                <tr key={key}>
                                                    <td>#{key + 1}</td>
                                                    <td>{property.name}</td>
                                                    <td>
                                                    <span
                                                        className="badge badge-secondary-inverse mr-2">{property.type}</span>
                                                    </td>
                                                    <td>
                                                        <div className="button-list">
                                                            <a href="#" className="btn btn-success-rgba"><i
                                                                className="feather icon-edit-2"></i></a>
                                                            <a href="#" className="btn btn-danger-rgba"><i
                                                                className="feather icon-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            )
                                        })}
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
}

// export default function ProductPropertiesPage({data, title}) {
//     const {metadata, setMetadata} = useContext(ClientContext);
//     const [propertiesData, setPropertiesData] = useState(data)
//
//     const newMetadata = {title: title}
//
//     useEffect(
//         function () {
//             setMetadata(newMetadata)
//         },
//         []
//     )
//
//     function addNewRowToTable() {
//         setPropertiesData(function (prevState) {
//             return [{
//                 id: 222,
//                 name: "Тест",
//                 type: "striing",
//             }].concat(prevState)
//         });
//     }
//
//     return (
//         <div className="contentbar">
//             <div className="row">
//                 <div className="col-lg-12">
//                     <div className="card m-b-30">
//                         <div className="card-body">
//                             <div className="table-responsive">
//                                 <table className="table table-borderless table-hover">
//                                     <thead>
//                                     <tr>
//                                         <th>ID</th>
//                                         <th>Название</th>
//                                         <th>Тип</th>
//                                         <th>Действия</th>
//                                     </tr>
//                                     </thead>
//                                     <tbody>
//                                     {propertiesData.map(function (property, key) {
//                                         return (
//                                             <tr key={key}>
//                                                 <td>#{key + 1}</td>
//                                                 <td>{property.name}</td>
//                                                 <td>
//                                                     <span
//                                                         className="badge badge-secondary-inverse mr-2">{property.type}</span>
//                                                 </td>
//                                                 <td>
//                                                     <div className="button-list">
//                                                         <a href="#" className="btn btn-success-rgba"><i
//                                                             className="feather icon-edit-2"></i></a>
//                                                         <a href="#" className="btn btn-danger-rgba"><i
//                                                             className="feather icon-trash"></i></a>
//                                                     </div>
//                                                 </td>
//                                             </tr>
//                                         )
//                                     })}
//                                     </tbody>
//                                 </table>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//
//             </div>
//         </div>
//     )
// }