"use server"
import {revalidatePath, revalidateTag} from "next/cache";

export default async function revalidateParsingSchemaData(schemaId) {
    if(Number.isInteger(schemaId)){
        revalidatePath(`/products/parsing-schemas/update/${schemaId}`)
    }
    revalidatePath(`/products/parsing-schemas`)
}