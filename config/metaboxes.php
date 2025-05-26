<?php

return [
    'internal' => [
        'id'         => 'openpub_metadata',
        'title'      => __('Internal', 'persberichten'),
        'post_types' => ['press-item'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            'internal'   => [
                'internal_info' => [
                    'name' => __('Internal info', 'persberichten'),
                    'desc' => __('Internal info is only included in the newsletter. Please make sure to select the correct internal mailing list.', 'persberichten'),
                    'id'   => 'press_mailing_internal_info',
                    'type' => 'textarea',
                ]
            ],
        ],
    ],
    'subtitle' => [
        'id'         => 'openpub_subtitle',
        'title'      => __('Subtitle', 'persberichten'),
        'post_types' => ['press-item'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            'subtitle'   => [
                'subtitle' => [
                    'name' => __('Subtitle', 'persberichten'),
                    'id'   => 'press_mailing_subtitle',
                    'type' => 'text',
                ]
            ],
        ]
    ],
    'spokesperson' => [
        'id'         => 'openpub_spokesperson',
        'title'      => __('Spokesperson', 'persberichten'),
        'post_types' => ['press-item'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            'spokesperson' => [
                'spokesperson_name' => [
                    'name' => __('Name', 'persberichten'),
                    'id'   => 'press_mailing_spokesperson_name',
                    'type' => 'text',
                ],
                'spokesperson_url' => [
                    'name' => __('URL', 'persberichten'),
                    'id'   => 'press_mailing_spokesperson_url',
                    'type' => 'url',
                ],
            ]
        ]
    ]
];
