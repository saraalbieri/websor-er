<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'traceLevel' => 3,
            'targets' => [
                // default
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                    'logFile' => '@console/runtime/logs/common/' . date('Y_m_d') . '.log'
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                    'categories' => ['sync'],
                    'logFile' => '@console/runtime/logs/mgo_sync/' . date('Y_m_d') . '.log',
                    'maxFileSize' => 1024 * 2
                ],
            ],
        ],
    ],
    'params' => $params,
];
