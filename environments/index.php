<?php
/**
 * The manifest of files that are local to specific environment.
 * This file returns a list of environments that the application
 * may be installed under. The returned data must be in the following
 * format:
 *
 * ```php
 * return [
 *     'environment name' => [
 *         'path' => 'directory storing the local files',
 *         'skipFiles'  => [
 *             // list of files that should only copied once and skipped if they already exist
 *         ],
 *         'setWritable' => [
 *             // list of directories that should be set writable
 *         ],
 *         'setExecutable' => [
 *             // list of files that should be set executable
 *         ],
 *         'setCookieValidationKey' => [
 *             // list of config files that need to be inserted with automatically generated cookie validation keys
 *         ],
 *         'createSymlink' => [
 *             // list of symlinks to be created. Keys are symlinks, and values are the targets.
 *         ],
 *     ],
 * ];
 * ```
 */
return [
    'Development configuration' => [
        'path' => 'dev',
        'setWritable' => [
            'configs',
            'runtime',
            'web/static',
            'web/static/uploads',
            'web/static/assets',
        ],
        'setExecutable' => [
            'yii',
        ],
        'setCookieValidationKey' => [
            'configs/backend/main-local.php',
            'configs/frontend/main-local.php',
        ],
        'setAliases' => [
            '@frontendUrl' => [
                'title' => 'Frontend application url',
                'default' => 'http://project.local',
                'file' => 'configs/main-local.php',
            ],
            '@backendUrl' => [
                'title' => 'Backend application url',
                'default' => function ($aliases) {
                    if (filter_var($aliases['@frontendUrl'], FILTER_VALIDATE_URL) !== false) {
                        $parts = parse_url($aliases['@frontendUrl']);
                        return sprintf('%s://%s%s%s', $parts['scheme'], $parts['host'], isset($parts['path']) ? $parts['path'] : '', '/backend');
                    }

                    return 'http://project.local/backend';
                },
                'file' => 'configs/main-local.php',
            ],
            '@staticUrl' => [
                'title' => 'Url for static files such as styles, scripts, images',
                'default' => function ($aliases) {
                    if (filter_var($aliases['@frontendUrl'], FILTER_VALIDATE_URL) !== false) {
                        $parts = parse_url($aliases['@frontendUrl']);
                        return sprintf('%s://%s%s%s', $parts['scheme'], $parts['host'], isset($parts['path']) ? $parts['path'] : '', '/static');
                    }

                    return 'http://project.local/static';
                },
                'file' => 'configs/main-local.php',
            ],
        ],
        'setDbConnection' => [
            'file' => 'configs/main-local.php',
            'options' => [
                'prefix' => [
                    'title' => 'Enter prefix, e.g mysql or pgsql',
                    'default' => 'mysql'
                ],
                'host' => [
                    'title' => 'Enter host',
                    'default' => 'localhost'
                ],
                'port' => [
                    'title' => 'Enter port',
                    'default' => ''
                ],
                'dbname' => [
                    'title' => 'Enter database name',
                    'default' => 'yupe'
                ],
                'username' => [
                    'title' => 'Enter username',
                    'default' => 'root'
                ],
                'password' => [
                    'title' => 'Enter password',
                    'default' => ''
                ]
            ]
        ]
    ],
];
