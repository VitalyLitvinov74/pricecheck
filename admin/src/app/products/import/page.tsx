import Form from "./form";
import {loadParsingSchemas} from "../../../../utils/parsing-schemas";

export default async function ImportPage() {
    const parsingSchemas = await loadParsingSchemas()

    return (
        <div className={'contentbar'}>
            <div className={"row"}>
                <Form parsingSchemas={parsingSchemas}/>
            </div>
        </div>
    )
}