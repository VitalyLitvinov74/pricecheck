export const titleByPath = function(path){
    let title = '';
    switch (path){
        case '/product':
            title = 'Список товаров';
            break
        case '/product/properties':
            title = "Свойства товаров"
            break;
    }
    return title;
}