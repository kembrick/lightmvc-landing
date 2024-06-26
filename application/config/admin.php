<?php

/*
 * Конфигурационный файл панели управления сайтом
 * ver 0.2
 */

return [

    'slider' => [
        'navigation' => 'Слайдер',
        'table' => 'front_slider',
        'icon' => 'video',
        'view' => [
            'fields' => [
                'title' => [
                    'title' => 'Название'
                ],
                'img_lnd' => [
                    'title' => 'Миниатюра',
                    'type' => 'image',
                ],
                'visible' => [
                    'title' => 'Отображать',
                    'type' => 'checkbox',
                ],
            ],
            'order' => 'ord',
        ],
        'edit' => [
            'fields' => [
                'title' => [
                    'title' => 'Название',
                ],
                'url' => [
                    'title' => 'Ссылка'
                ],
                'img_lnd' => [
                    'title' => 'Изображение',
                    'type' => 'image',
                    'resize' => [1200, 400], // две версии изображения - альбом и портрет (для адаптивной карусели)
                    'crop' => [675, 650],
                ],
            ],
        ]
    ],

    'buttons' => [
        'navigation' => 'Кнопки',
        'table' => 'front_buttons',
        'icon' => 'menu',
        'addOnly' => true, // удаление записей запрещено
        'view' => [
            'fields' => [
                'title' => [
                    'title' => 'Текст'
                ],
                'url' => [
                    'title' => 'Ссылка'
                ],
            ],
            'order' => 'ord',
        ],
        'edit' => [
            'fields' => [
                'title' => [
                    'title' => 'Текст'
                ],
                'url' => [
                    'title' => 'Ссылка',
                ],
                'ord' => [
                    'title' => 'Приоритет (чем меньше значение, тем раньше выводится)',
                    'type' => 'number',
                    'default' => '1'
                ],
            ],
        ]
    ],

    'infoblocks' => [
        'navigation' => 'Инфоблоки',
        'table' => 'front_infoblocks',
        'icon' => 'columns',
        'addOnly' => true, // удаление записей запрещено
        'view' => [
            'fields' => [
                'title' => [
                    'title' => 'Название'
                ],
                'name' => [
                    'title' => 'Системное имя'
                ],
                'visible' => [
                    'title' => 'Выводить',
                    'type' => 'checkbox',
                ]
            ],
            'order' => 'ord',
        ],
        'edit' => [
            'fields' => [
                'title' => [
                    'title' => 'Название'
                ],
                'name' => [
                    'title' => 'Системное имя',
                    'disabled' => true, // запрещено последующее редактирование
                ],
                'content' => [
                    'title' => 'Текст',
                    'type' => 'tiny',
                ],
                'img' => [
                    'title' => 'Изображение',
                    'type' => 'image',
                    'resize' => [800],
                ],
                'visible' => [
                    'title' => 'Выводить',
                    'type' => 'checkbox',
                    'default' => '1'
                ],
            ],
        ]
    ],

    'settings' => [
        'navigation' => 'Настройки сайта',
        'table' => 'front_settings',
        'icon' => 'cog-alt',
        'addOnly' => true,
        'nav_break' => true,
        'view' => [
            'fields' => [
                'title' => [
                    'title' => 'Название'
                ],
                'name' => [
                    'title' => 'Системное имя'
                ],
                'val' => [
                    'title' => 'Значение'
                ],
            ],
        ],
        'edit' => [
            'fields' => [
                'title' => [
                    'title' => 'Название',
                ],
                'name' => [
                    'title' => 'Системное имя',
                    'pattern' => '^[a-zA-Z0-9_\/\-]+$',
                    'required' => true,
                    'disabled' => true,
                ],
                'val' => [
                    'title' => 'Значение',
                ],
            ],
        ]
    ],

    'demo1' => [
        'navigation' => 'Демо (группировка)',
        'table' => 'front_demo',
        'icon' => 'sliders',
        'view' => [
            'fields' => [
                'MIN(front_demo.name)' => [
                    'title' => 'Название'
                ],
                'MIN(front_demo.pagename)' => [
                    'title' => 'ЧПУ'
                ],
                'MIN(front_demo.img)' => [
                    'title' => 'Изображение',
                    'type'  => 'image',
                ],
                'MIN(dt)' => [
                    'title' => 'Дата',
                    'type'  => 'date',
                ],
                'MIN(visible)' => [
                    'title' => 'Выводить',
                    'type'  => 'checkbox',
                ],
                'GROUP_CONCAT(g.name SEPARATOR " | ")' => [  // перечисление категорий
                    'title' => 'Категории',
                ],
            ],
            'join' => 'LEFT JOIN front_demo_groups ON front_demo_groups.id = front_demo.id LEFT JOIN front_settings g ON g.id = front_demo_groups.group_id',
            'group' => 'front_demo.id',
        ],
        'edit' => [
            'fields' => [
                'name' => [
                    'title' => 'Название',
                    'translit' => 'pagename', // автоматическое заполнение указанного текстового поля транслитом, если в нем пусто
                ],
                'pagename' => [
                    'title' => 'ЧПУ (только латиница и разделители: "-" и "_")',
                    'pattern' => '^[a-zA-Z0-9_\/\-]+$',
                    'required' => true,
                    'disabled' => true,
                ],
                // group_id и images - фиктивные поля, в основной таблице их реально не существует
                'group_id' => [
                    'title' => 'Категория',
                    'type' => 'multiselect',
                    'sourceTable' => 'front_settings',
                    'targetTable' => 'front_demo_groups',
                ],
                'img' => [
                    'title' => 'Основное изображение (дополняется полями до квадрата)',
                    'type' => 'image',
                    'resize' => [600],
                    'fill' => [600]
                ],
                'images' => [
                    'title' => 'Дополнительные изображения (обрезаются до квадрата)',
                    'type' => 'multiImage',
                    'targetTable' => 'front_demo_images',
                    'resize' => [400],
                    'crop' => [400],
                ],
                'content' => [
                    'title' => 'Описание',
                    'type' => 'tiny',
                ],
                'radio' => [
                    'title' => 'Опция',
                    'type' => 'radio', // можно сохранять значение в enum-полях
                    'radio' => [1 => 'Test1', 2 => 'Test2'],
                ],
                'dt' => [
                    'title' => 'Дата',
                    'type' => 'date',
                ],
                'ord' => [
                    'title' => 'Приоритет',
                    'type' => 'number',
                    'default' => '1'
                ],
                'visible' => [
                    'title' => 'Выводить',
                    'type' => 'checkbox',
                    'default' => '1'
                ],
            ],
        ]
    ],

    'demo2' => [
        'navigation' => 'Демо (дерево)',
        'table' => 'front_demo',
        'icon' => 'tree',
        'view' => [
            'fields' => [
                'name' => ['title' => 'Название'],
            ],
            'tree' => true,
        ],
        'edit' => [
            'fields' => [
                'name' => [
                    'title' => 'Название',
                    'translit' => 'pagename', // автоматическое заполнение указанного текстового поля транслитом, если в нем пусто
                ],
                'parent_id' => [
                    'title' => 'Родительская категория',
                    'type' => 'select',
                    'targetTable' => 'front_demo',
                    'selectSQL' => [
                        'table' => 'front_demo',
                        'fields' => ['id', 'name'],
                        'where' => 'parent_id = 0', // Выбрать категории верхнего уровня
                        'excludeId' => true, // Исключить id текущей записи из селекта
                        'order' => 'name',
                    ],
                ],
            ],
        ]
    ],


    'demo3' => [
        'navigation' => 'Демо (джойн)',
        'table' => 'front_demo',
        'icon' => 'toggle-off',
        'view' => [
            'fields' => [
                'front_demo_name' => [
                    'title' => 'Название',
                    // заполняется, если в другой таблице есть поле с этим же названием, индекс поля становится его алиасом
                    'column' => 'front_demo.name'
                ],
                'category_name' => [
                    'title' => 'Категория',
                    'column' => 'front_settings.name'
                ],
            ],
            'join' => 'LEFT JOIN front_settings ON front_settings.id = cat_id',
        ],
        'edit' => [
            'fields' => [
                'name' => [
                    'title' => 'Название',
                ],
                'cat_id' => [
                    'title' => 'Товарная категория',
                    'type' => 'select',
                    'selectSQL' => [
                        'table' => 'front_settings',
                        'fields' => ['id', 'name'],
                        'order' => 'name',
                    ],
                ],
            ],
        ]
    ],

];