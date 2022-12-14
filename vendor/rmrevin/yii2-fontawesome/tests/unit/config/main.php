<?php
/**
 * main.php
 * @author Roman Revin http://phptime.ru
 */

$baseDir = realpath(__DIR__ . '/..');

return [
    'id' => 'testapp',
    'basePath' => $baseDir,
    'aliases' => [
        '@web' => '/',
        '@webroot' => $baseDir . '/runtime',
        '@vendor' => realpath($baseDir . '/../../vendor'),
        '@bower' => realpath($baseDir . '/../../vendor/bower'),
        '@sibilino/yii2/openlayers' => realpath($baseDir . '/../../vendor/sibilino/yii2-openlayers/widget'),
    ]
];