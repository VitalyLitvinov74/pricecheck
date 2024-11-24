'use client'
import React, {useRef, useState} from "react";
import Select from "react-select";
import {ParsingSchema, ParsingSchemaProperty} from "../../../utils/types";

export default function Form({parsingSchemas}: {
    parsingSchemas: ParsingSchema[]
}) {
    console.log(parsingSchemas)
    const [file, changeFile] = useState(null)
    const [fileTitle, changeTitle] = useState('В формате xlsx')
    const [parsingSchema, changeParsingSchema] = useState<ParsingSchema | undefined>(undefined)

    const inputFileRef = useRef(null)

    function selectFile(event) {
        let file = event.target.files[0];
        changeFile(file);
        changeTitle(file.name)
    }

    function options() {
        return parsingSchemas.map(function (schema) {
            return {
                value: schema.id,
                label: schema.name
            }
        })
    }

    function parsingSchemaById(id): ParsingSchema | undefined {
        return parsingSchemas.find(function (schema) {
            return schema.id === id;
        })
    }

    function startImport() {

    }

    function renderRowOfSchema(parsingSchemaProperty: ParsingSchemaProperty) {
        return (
            <tr key={parsingSchemaProperty.id}>
                <td>
                    {parsingSchemaProperty.external_column_name}
                </td>
                <td>
                    {parsingSchemaProperty.property.name}
                </td>
            </tr>
        )
    }

    return (
        <>
            <div className={'col-lg-4'}>
                <div className="card m-b-30">
                    <div className="card-header">
                        Настраиваем импорт
                    </div>
                    <div className="card-body">
                        <div className="ecommerce-upload" role={'button'} onClick={() => {
                            inputFileRef.current.click()
                        }}>
                            <div className="dropzone dz-clickable">
                                <div className="dz-default dz-message">
                                    <p className="dash-analytic-icon"><i
                                        className="feather icon-plus primary-rgba text-primary"></i></p>
                                    <span>{fileTitle}</span>
                                </div>
                            </div>
                            <img src="/assets/images/dashboard/cloud.svg" className="img-fluid" alt="cloud"/>
                        </div>
                        <input type={'file'}
                               ref={inputFileRef}
                               className={'d-none'}
                               accept={".xlsx, .xls"}
                               onChange={selectFile}
                        />
                        <p>Обязательно выберите схему парсинга товаров с загружаемым файлом</p>
                        <Select
                            options={options()}
                            menuPosition={'fixed'}
                            onChange={
                                function (option) {
                                    changeParsingSchema(parsingSchemaById(option.value))
                                }
                            }
                            isDisabled={parsingSchemas.length < 1}
                            placeholder={parsingSchemas.length < 1
                                ? "У вас нет схем парсинга, импорт не возможен"
                                : "Выберите схему парсинга"
                            }
                        >
                        </Select>
                        <button
                            type="button"
                            className="btn btn-default mt-4"
                            disabled={!file}
                            onClick={startImport}
                        >
                            <span className="glyphicon glyphicon-screenshot"></span>
                            Начать импорт
                        </button>
                    </div>
                </div>
            </div>
            <div className={`col-lg-4 ${parsingSchema ? "" : "d-none"}`}>
                <div className="card m-b-30">
                    <div className="card-header">
                        Колонка в xlsx соотносится с полем товара
                    </div>
                    <div className="card-body">
                        <table className={"table table-borderless"}>
                            <thead>
                            <tr>
                                <th>Колонка в xlsx</th>
                                <th>Поле товара</th>
                            </tr>
                            </thead>
                            <tbody>
                            {
                                parsingSchema?.parsingSchemaProperties.map(function (parsingProperty) {
                                    return renderRowOfSchema(parsingProperty)
                                })
                            }
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </>
    )
}