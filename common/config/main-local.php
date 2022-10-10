<?php

$params = array_merge(require(__DIR__ . '/params-local.php')
);
return [
    'language' => 'it-IT',
    'sourceLanguage' => 'it-IT',
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'mainLayout' => '@app/views/layouts/main.php',
        ]
    ],
    'components' => [
        'apns' => [
            'class' => 'bryglen\apnsgcm\Apns',
            'environment' => \bryglen\apnsgcm\Apns::ENVIRONMENT_SANDBOX,
            'pemFile' => '{pathcertificatopem}',
            'options' => [
                'sendRetryTimes' => 5,
            ]
        ],
        'gcm' => [
            'class' => 'bryglen\apnsgcm\Gcm',
            'apiKey' => '{gcm_key}',
        ],
        'apnsGcm' => [
            'class' => 'bryglen\apnsgcm\ApnsGcm',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'urlManagerMap' => [
            'class' => 'yii\web\urlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => 'https://vm111lnx.ente.regione.emr.it/websor-master/api/web/', // url al modulo map in api/modules/map
        ],
        'urlManagerApi' => [
            'class' => 'yii\web\urlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => 'https://vm111lnx.ente.regione.emr.it/websor-master/backend/web/v1', // url al modulo map in api/modules/v1
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\urlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => 'https://vm111lnx.ente.regione.emr.it/websor-master/frontend/web', // url a frontend/web
        ],
        'urlManagerBackend' => [
            'class' => 'yii\web\urlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => 'https://vm111lnx.ente.regione.emr.it/websor-master/backend/web', // url a backend/web
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache'
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=vm135lnx;port=5432;dbname=websor',
            'username' => 'usrwebsor',
            'password' => 'jriwL8zsakHava',
            'charset' => 'utf8',
            'driverName' => 'pgsql',
            'schemaMap' => [
                'pgsql' => [
                  'class' => 'yii\db\pgsql\Schema',
                  'defaultSchema' => 'public'
                ]
            ], 
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'dbsqlserver' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlsrv:Server={host};Database={Nome DB}',
            'username' => '{user}',
            'password' => '{password}',
            'charset' => 'utf8'
        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://@{host}:{port}/{db}',
            'options' => [
                "username" => "{user}",
                "password" => "{password}",
                "socketTimeoutMS" => 10000
            ]
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mailinglist.regione.emilia-romagna.it',
                'username' => '{user}',
                'password' => '{password}',
                'port' => '25',
                'encryption' => 'tls',
            ],
        ],
        // provider secondario
        'mailer_throwback' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mailinglist.regione.emilia-romagna.it',
                'username' => '{user}',
                'password' => '{password}',
                'port' => '25',
                'encryption' => 'tls',
            ],
        ],
        'formatter' => [
            'defaultTimeZone' => 'Europe/Rome',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
            'timeFormat' => 'php:H:i',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'EUR',
        ],
        'jwt' => [
            'class' => 'sizeg\jwt\Jwt',
            'key'   => $params['secret-key'],
        ],
        'rabbitmq' => [
            'class' => \mikemadisonweb\rabbitmq\Configuration::class,
            'connections' => [
                [
                    'host' => '{host}',
                    'port' => '{port}',
                    'user' => '{username}',
                    'password' => '{password}',
                    'vhost' => '/',
                ]
            ],
            'exchanges' => [
                [
                    'name' => 'MGO_WEBSOR_EXCHANGE',
                    'type' => 'direct'
                ],
                [
                    'name' => 'MAS_EXCHANGE',
                    'type' => 'direct'
                ],
            ],
            'queues' => [
                [
                    'name' => 'MGO_SENT'
                ],
                [
                    'name' => 'MAS_WORK_QUEUE',
                    'nowait' => true
                ]
            ],
            'bindings' => [
                [
                    'queue' => 'MGO_SENT',
                    'exchange' => 'MGO_WEBSOR_EXCHANGE',
                    'routing_keys' => ['FROM_MGO_TO_WEBSOR'],
                ],
                [
                    'queue' => 'MAS_WORK_QUEUE',
                    'exchange' => 'MAS_EXCHANGE',
                    'routing_keys' => ['MAS_ROUTING'],
                ],
            ],
            'producers' => [
                [
                    'name' => 'WEBSOR_SEND_UPDATE',
                ],
                [
                    'name' => 'MAS_SENDER',
                ],
            ],
            'consumers' => [
                [
                    'name' => 'WEBSOR_LISTEN_FROM_MGO',
                    'callbacks' => [
                        'MGO_SENT' => \common\consumers\MGOUpdateConsumer::class,
                    ],
                ],
                [
                    'name' => 'MAS_WORKER',
                    'callbacks' => [
                        'MAS_WORK_QUEUE' => \common\utils\mas\QueueWorker::class,
                    ],
                ],
            ],
        ],
    ],
];
