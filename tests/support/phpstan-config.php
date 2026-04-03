<?php

declare(strict_types=1);

use app\models\User;
use yii\caching\FileCache;
use yii\inertia\Manager;
use yii\inertia\vue\Vite;
use yii\log\FileTarget;
use yii\symfonymailer\Mailer;
use yii\web\Application;
use yii\web\Request;
use yii\web\UrlManager;

return [
    'phpstan' => [
        'application_type' => Application::class,
    ],
    'id' => 'app-inertia-vue-phpstan',
    'basePath' => dirname(__DIR__, 2),
    'controllerNamespace' => 'app\\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => dirname(__DIR__, 2) . '/node_modules',
    ],
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'inertia' => [
            'class' => Manager::class,
        ],
        'inertiaVue' => [
            'class' => Vite::class,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => [
                        'error',
                        'warning',
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => Mailer::class,
            'useFileTransport' => true,
        ],
        'request' => [
            'class' => Request::class,
        ],
        'urlManager' => [
            'class' => UrlManager::class,
        ],
        'user' => [
            'identityClass' => User::class,
        ],
    ],
    'params' => [
        'adminEmail' => 'admin@example.com',
        'senderEmail' => 'noreply@example.com',
        'senderName' => 'Example.com mailer',
        'supportEmail' => 'support@example.com',
    ],
];
