"use server"
import {revalidatePath} from "next/cache";

export default async function revalidateProductList(){
    revalidatePath(`/products`)
}