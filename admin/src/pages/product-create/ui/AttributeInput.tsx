import Select from "react-select";
import {ProductAttribute} from "../../../models/ProductAttribute";

export function AttributeInput({attribute}: {
    attribute: ProductAttribute
}){
    return (<>
        <div key={attribute.id}>
            <div className="row mt-4">
                <div className="col-md-6">
                    <label htmlFor={attribute.id}>{attribute.name}</label>

                    {/*<div className="invalid-feedback">*/}
                    {/*    Please provide a valid city.*/}
                    {/*</div>*/}

                </div>
                {/*<div className="col-md-3">*/}
                {/*    <label htmlFor="validationServer04">City</label>*/}
                {/*</div>*/}

            </div>
            <div className="row">
                <div className="col-md-6">
                    {/*<input type="text"*/}
                    {/*       className="form-control is-invalid"*/}
                    {/*       id={attribute.id} required=""*/}
                    {/*       onBlur={(e) => {*/}
                    {/*           attributeChangedOn(attribute, null, e.target.value)*/}
                    {/*       }}*/}
                    {/*       defaultValue={attribute.value}*/}
                    {/*/>*/}
                </div>
                <div className="col-md-3">
                    {/*<Select*/}
                    {/*    defaultValue={optionsFor(attribute)[0]}*/}
                    {/*    options={optionsFor()}*/}
                    {/*    onChange={(option) => attributeChangedOn(attribute, option)}*/}
                    {/*    menuPosition={"fixed"}*/}
                    {/*>*/}
                    {/*</Select>*/}
                </div>
                <div className="col-md-1 ">
                    <button
                        type="button"
                        className="btn btn-round btn-danger-rgba"
                        onClick={() => {
                            // remove(attribute)
                        }}
                    >
                        <i className="feather icon-minus"></i>
                    </button>
                </div>
            </div>
        </div>
    </>)
}