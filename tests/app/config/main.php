<?php
$config = [
    'id' => 'yii2-notification-app',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)).'/vendor',
    'runtimePath' => dirname(dirname(__DIR__)).'/_data/runtime',
    'bootstrap' => [
    ],
    'components' => [

        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlite:@tests/_data/db.sq3',
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
            'messageConfig' => [
                'charset' => 'UTF-8',
            ],
        ],

        'session' => ['class' => 'yii\web\Session'],

    ],
    'modules' => [

        // Notification by providers (Система нотификаций: email, sms, push, web, итд)
        'notification' => [
            'class' => 'hossein142001\notification\Module',
            'storeNotificationStatus' => true,
            'providers' => [

                // notify
                'notify' => [
                    'class' => 'hossein142001\notification\providers\notify',
                    'enabled' => true,
                ],

                // Web notify
                'web' => [
                    'class' => 'hossein142001\notification\providers\web',
                    'enabled' => true,
                ],

                // E-mail
                'email' => [
                    'class' => 'hossein142001\notification\providers\email',
                    'enabled' => true,
                    'emailViewPath' => '@app/mail',
                ],

            ]
        ],

    ],
    'params' => [
        'noreplyEmail' => 'noreply@localhost',
    ],
];

return $config;