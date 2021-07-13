<?php

namespace platform;

class Plugin extends BasePlugin
{
    protected $version = '1.0';
    public $id = null;

    public function getName()
    {
        return 'Система';
    }

    public function getDescription()
    {
        return 'Платформа продукта';
    }

    public function getNavigation()
    {
        return [
            'rbac' => [
                'label' => 'Пользователи и роли',
                'url' => '#',
                'icon' => 'fa fa-user',
                'items' => [
                    'users' => [
                        'label' => 'Пользователи',
                        'url' => ['/platform/user/index'],
                    ],
                    'roles' => [
                        'label' => 'Роли',
                        'url' => ['/rbac/role']
                    ],
                    'assignments' => [
                        'label' => 'Назначения',
                        'url' => ['/rbac/assignment']
                    ],
                    'permissions' => [
                        'label' => 'Разрешения',
                        'url' => ['/rbac/permission']
                    ],
                ]
            ],
            'settings' => [
                'label' => 'Настройки',
                'items' => [
                    'system' => [
                        'label' => 'Система',
                        'url' => ['/platform/settings/index'],
                    ],                    
                ],
                'url' => '#',
                'icon' => 'fa fa-cog',
            ],
            'license' => [
                'label' => 'Список лицензий',
                'url' => [
                    '/platform/license/index'
                ],
                'icon' => 'fa fa-file-alt'
            ]
        ];
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return [
            'general' => [
                'items' => [
                    'name-from' => [
                        'label' => 'Имя отправителя'
                    ],
                    'email-from' => [
                        'label' => 'Email отправителя',
                    ],
                ],
            ],
            'smtp' => [
                'items' => [
                    'smtp-server' => [
                        'label' => 'SMTP сервер',
                    ],
                    'smtp-port' => [
                        'label' => 'SMTP порт',
                    ],
                    'smtp-secure' => [
                        'label' => 'SMTP шифрование',
                    ],
                    'smtp-user' => [
                        'label' => 'SMTP пользователь',
                    ],
                    'smtp-password' => [
                        'label' => 'SMTP пароль',
                        'type' => 'passwordInput'
                    ],
                    'smtp-degug' => [
                        'label' => 'Режим отладки',
                        'type' => 'checkbox',
                    ],
                ],
            ],
        ];
    }
}
