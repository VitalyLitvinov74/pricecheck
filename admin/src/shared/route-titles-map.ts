export const titleByPath = function(path){
    let title = '';
    switch (path){
        case '/products':
            title = 'Список товаров';
            break
        case '/products/new':
            title = 'Создать новый товар';
            break
        case '/products/properties':
            title = "Свойства товаров"
            break;
        case '/products/parsing-schemas':
            title = "Схемы парсинга"
            break;
        case '/products/parsing-schemas/new':
            title = "Создать схему парсинга"
            break
    }
    return title;
}

export const breadcrumbMap = function (){
    return
}