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
    }
    return title;
}