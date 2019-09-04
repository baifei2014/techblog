<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'Amqp' => [
            'class' => 'Longhao\Amqp\Amqp'
        ]
    ],
];
