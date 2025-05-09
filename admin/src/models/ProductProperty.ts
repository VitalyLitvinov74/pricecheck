import {uuid} from "../shared/helpers";

export class ProductProperty {
    id?: number;
    name: string;
    type: string;
    frontendId: string;

    constructor(data) {
        this.id = data.id;
        this.name = data.name;
        this.type = data.type;
        this.frontendId = uuid();
    }
}