'use client'
import {usePathname} from "next/navigation";
import {titleByPath} from "../../../../utils/route-titles-map";
import {useState} from "react";
import Link from "next/link";

export default function Breadcrumbs({inputTitle}) {
    const [title, changeTitle] = useState(inputTitle);

    if (title !== titleByPath(usePathname())) {
        const newTitle = titleByPath(usePathname())
        changeTitle(newTitle)
    }
    const map = [
        {
            path: '/products',
            title: 'Список товаров',
            child: [
                {
                    path: '/products/new',
                    title: 'Создать новый товар',
                },
                {
                    path: "/products/table-settings",
                    title: "Настройка таблицы"
                },
                {
                    path: '/products/update',
                    title: 'Обновляем товар',
                },
                {
                    path: '/products/properties',
                    title: "Свойства товаров"
                },
                {
                    path: '/products/import',
                    title: "Импорт"
                },
                {
                    path: '/products/parsing-schemas',
                    title: "Схемы парсинга",
                    child: [
                        {
                            path: '/products/parsing-schemas/new',
                            title: "Создать схему парсинга"
                        },
                        {
                            path: '/products/parsing-schemas/update',
                            title: "Обновляем схему"
                        }
                    ]
                }
            ]
        }
    ];
    const currentPath = usePathname();

    function buildBreadcrumbMap(map, builtMap) {
        for (let i = 0; i < map.length; i++) {
            if (map[i].path === currentPath) {
                builtMap.push({
                    path: map[i].path,
                    title: map[i].title
                })
                return builtMap;
            }
            if (map[i].hasOwnProperty('child')) {
                builtMap = buildBreadcrumbMap(map[i].child, builtMap)
                if(builtMap !== []){
                    builtMap = [
                        {
                            path: map[i].path,
                            title: map[i].title
                        },
                        ...builtMap
                    ]
                }
            }
        }
        return builtMap;
    }

    const breadcrumbPath = buildBreadcrumbMap(map, []);
    function link(path, title){
        return (
            <li key={path} className={`breadcrumb-item`}>
                <Link href={path}>{title}</Link>
            </li>
        )
    }
    function notLink(path, title){
        return (
            <li key={path} className={`breadcrumb-item active`}>
                {title}
            </li>
        )
    }

    // const style = {
    //     marginTop: "30px"
    // }

    return (
        <div className="breadcrumbbar">
            <div className="row align-items-center">
                <div className="col-md-8 col-lg-8">
                    <h4 className="page-title">{title}</h4>
                    <div className="breadcrumb-list">
                        <ol className="breadcrumb">
                            {
                                breadcrumbPath.map(
                                    function(breadcrumb){
                                        if(breadcrumb.path === currentPath){
                                             return notLink(breadcrumb.path, breadcrumb.title)
                                        }
                                        return link(breadcrumb.path, breadcrumb.title)
                                    }
                                )
                            }

                        </ol>
                    </div>
                </div>
            </div>
        </div>
    );
}