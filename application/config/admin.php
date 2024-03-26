<?php

/*
 * Конфигурационный файл панели управления сайтом
 */

return [

    'infoblocks' => [
        'navigation' => 'Инфоблоки',
        'table' => 'th-list',
        'icon' => 'doc-text',
        'addOnly' => true, // удаление записей запрещено
        'view' => [
            'fields' => [
                'title' => [
                    'title' => 'Название'
                ],
                'pagename' => [
                    'title' => 'ЧПУ'
                ],
                'visible' => [
                    'title' => 'Выводить',
                    'type' => 'checkbox',
                ]
            ],
            'fieldnames' => [
                'Название', 'ЧПУ', 'Отображать'
            ],
            'fieldstype' => [ // тип полей задается, только если отличаются от дефолтных (text)
                'visible' => 'check'
            ],
            'order' => 'ord',
        ],
        'edit' => [
            'fields' => [
                'title' => [
                    'title' => 'Название'
                ],
                'pagename' => [
                    'title' => 'ЧПУ страницы (уникальный идентификатор, только латиница в одно слово)',
                    'disabled' => true, // запрещено последующее редактирование
                ],
                'content' => [
                    'title' => 'Текст',
                    'type' => 'tiny',
                ],
                'ord' => [
                    'title' => 'Приоритет (чем меньше значение, тем раньше выводится)',
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
                    'resize' => [400, 1000], // две версии изображения - портрет и альбом
                    'crop' => [600, 500],
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
                    'title' => 'Алиас'
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