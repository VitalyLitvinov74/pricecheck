import Form from "./form";

export default async function ImportPage() {
    return (
        <div className={'contentbar'}>
            <div className={"row"}>
                <div className={"col-lg-4"}>
                    <div className="card m-b-30">
                        <div className="card-header">
                        </div>
                            <Form/>
                    </div>
                </div>
            </div>
        </div>
    )
}