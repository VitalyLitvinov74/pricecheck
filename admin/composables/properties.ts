import {useState} from "#app/composables/state";

export const useProperties = function (){
    const baseUrl = 'http://api.pricecheck.my:82/';
    const list = $fetch(
        baseUrl + 'api/product/all-properties-list',
        {
            method: "GET",
        }
    )


    return {
        list,
    }
}