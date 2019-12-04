<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'assetManager' => [
            'basePath' => '@webroot/frontend/web/assets',
            'baseUrl' => '@web/frontend/web/assets'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
             'enablePrettyUrl' => true,
             'showScriptName' => false,
             'rules' => [
                '/' => 'site/index',
                '/<aid:\d+><suffix:.html|.htm>' => 'site/view',
                '/salon' => 'site/salon',
                '/about' => 'site/about',
                '/achieve' => 'site/achieve',
                '/crawl' => 'site/crawl',
             ],
         ],
         'devicedetect' => [
            'class' => 'common\helpers\DeviceDetect'
        ]
    ],
    'bootstrap' => ['devicedetect'],
    'params' => $params,
    'as crawBehavior' => [
        'class' => 'frontend\components\CrawBehavior'
    ],
];
