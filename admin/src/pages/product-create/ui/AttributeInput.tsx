import {Attribute, Option} from "../../../shared/types";
import {useProductFormContext} from "./Form";
import Select from "react-select";

export function AttributeInput({attribute}: {
    attribute: Attribute
}) {
    const form = useProductFormContext();

    function changeValue(event: Event) {
        form.changeAttribute({...attribute, value: event.target.value.toString()})
    }

    function changeProperty(option: Option){
        form.changeAttribute({...attribute, property_id: option.value, property_name: option.label})
    }

    return (<>
        <div key={attribute.id}>
            <div className="row mt-4">
                <div className="col-md-6">
                    <label htmlFor={attribute.id.toString()}>{attribute.property_name}</label>

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
                    <input type="text"
                           className="form-control"
                           required=""
                           onBlur={changeValue}
                           defaultValue={attribute.value}
                    />
                </div>
                <div className="col-md-3">
                    <Select
                        defaultValue={form.buildOptionsByAttribute(attribute)[0]}
                        options={form.buildOptionsByAttribute(attribute)}
                        onChange={(option) => changeProperty(option)}
                        menuPosition={"fixed"}
                    >
                    </Select>
                </div>
                <div className="col-md-1 ">
                    <button
                        type="button"
                        className="btn btn-round btn-danger-rgba"
                        onClick={() => {
                            form.removeAttribute(attribute)
                        }}
                    >
                        <i className="feather icon-minus"></i>
                    </button>
                </div>
            </div>
        </div>
    </>)
}