import {Column} from "../types";

export const loadColumns = async function (): Promise<Column[]> {
    const url = `${process.env.URL}/table-settings/default/list-settings`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    return await data.json();
}