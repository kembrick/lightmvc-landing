<?php

/*
 * Конфигурационный файл панели управления сайтом
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
        'icon' => 'tasks',
        'addOnly' => true, // удаление записей запрещено
        'view' => [
            'fields' => [
                'title' => [
                    'title' => 'Название'
                ],
                'sysname' => [
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
                'sysname' => [
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
        'view' => [
            'fields' => [
                'title' => [
                    'title' => 'Название'
                ],
                'sysname' => [
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
                'sysname' => [
                    'title' => 'Алиас',
                    'pattern' => '^[a-zA-Z0-9_\/\-]+$',
                    'required' => true,
                    'disabled' => true,
                ],
                'val' => [
                    'title' => 'Значение',
                ],
            ],
            'fieldnames' => [
                'Название', 'Системное имя', 'Контент'
            ],
            'fieldstype' => [
                'sysname' => 'locked',
                'val' => 'textarea'
            ],
        ]
    ],

];