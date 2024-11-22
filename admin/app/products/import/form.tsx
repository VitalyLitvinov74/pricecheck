'use client'
import {useState} from "react";

export default function Form() {
    const [file, changeFile] = useState()
    function selectFile(event){
        event.stopPropagation();
        event.preventDefault();
        let file = event.target.files[0];
        console.log(file);
        changeFile(file); /// if you want to upload latter
    }
    return (
        <div className="card-body">
            <div className="ecommerce-upload">
                <div className="dropzone dz-clickable" onClick={e=> selectFile(e)}>
                    <div className="dz-default dz-message">
                        <p className="dash-analytic-icon"><i
                            className="feather icon-plus primary-rgba text-primary"></i></p>
                        <span>Выберите файл в формате xlsx</span>
                    </div>
                </div>
                <img src="/assets/images/dashboard/cloud.svg" className="img-fluid" alt="cloud"/>
            </div>
        </div>
    )
}