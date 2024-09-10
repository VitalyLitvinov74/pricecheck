import {useState} from "#app/composables/state";

export const useBreadcrumbs = function (){
    let name = useState('name', ()=>'');
    let pageTitle = useState('pageTitle', ()=>'');
    function renameButton (newName: string){
        name.value = newName;
    }

    function changePageTitle(newTitle: string){
        pageTitle.value = newTitle
    }

    return {
        name,
        pageTitle,
        renameButton,
        changePageTitle
    }
}