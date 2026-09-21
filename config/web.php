<?php

declare(strict_types=1);

use app\models\User;
use PHPForge\Vite\Configuration\{DevelopmentConfiguration, ProductionConfiguration};
use PHPForge\Vite\Debug\{ViteCollector, VitePanel};
use PHPForge\Vite\Vite;
use yii\caching\FileCache;
use yii\debug\Module as DebugModule;
use yii\inertia\{Bootstrap, Manager};
use yii\inertia\web\Request as InertiaRequest;
use yii\log\FileTarget;
use yii\mail\MailerInterface;
use yii\rbac\PhpManager;
use yii\symfonymailer\Mailer;
use yii\web\JsonParser;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$debugAllowedIPs = ['127.0.0.1', '::1'];

$config = [
    'id' => 'app-inertia-vue',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => dirname(__DIR__) . '/node_modules',
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        Bootstrap::class,
    ],
    'components' => [
        'authManager' => [
            'class' => PhpManager::class,
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'db' => $db,
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'inertia' => [
            'class' => Manager::class,
            'rootView' => '@app/resources/views/app.php',
            'shared' => [
                'auth' => static function (): array {
                    $user = Yii::$app->user;
                    $identity = $user->identity;

                    return [
                        'canViewUsers' => !$user->isGuest && $user->can('viewUsers'),
                        'isGuest' => $user->isGuest,
                        'user' => $identity instanceof User ? [
                            'id' => $identity->id,
                            'username' => $identity->username,
                            'email' => $identity->email,
                        ] : null,
                    ];
                },
                'appName' => static fn(): string => Yii::$app->name,
                'canAccessDebug' => static fn(): bool => YII_DEBUG && in_array(
                    Yii::$app->request->getUserIP(),
                    $debugAllowedIPs,
                    true,
                ),
            ],
            'version' => static function (): string {
                $path = Yii::getAlias('@webroot/build/.vite/manifest.json');

                return is_file($path) ? (string) filemtime($path) : '';
            },
        ],
        'inertiaVue' => [
            'class' => Vite::class,
            '__construct()' => [
                'configuration' => YII_ENV === 'dev'
                    ? DevelopmentConfiguration::create(
                        devServerUrl: 'http://localhost:5174',
                    )
                    : ProductionConfiguration::create(
                        manifestPath: dirname(__DIR__) . '/public/build/.vite/manifest.json',
                        assetBaseUrl: '/build',
                    ),
                'entrypoints' => ['resources/js/app.js'],
            ],
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
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
        'mailer' => MailerInterface::class,
        'request' => [
            'class' => InertiaRequest::class,
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
            'parsers' => [
                'application/json' => JsonParser::class,
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                'about' => 'site/about',
                'login' => 'user/login',
                'logout' => 'user/logout',
                'signup' => 'user/signup',
                'users' => 'user/index',
                'password-reset/<token:[\\w\\-]+>' => 'user/reset-password',
                'verify-email/<token:[\\w\\-]+>' => 'user/verify-email',
                '<controller:[\\w\\-]+>/<action:[\\w\\-]+>' => '<controller>/<action>',
            ],
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'loginUrl' => [
                'user/login',
            ],
        ],
    ],
    'container' => [
        'singletons' => [
            MailerInterface::class => [
                'class' => Mailer::class,
                // send all mails to a file by default.
                'useFileTransport' => true,
                'viewPath' => '@app/resources/mail',
            ],
        ],
    ],
    'controllerNamespace' => 'app\\controllers',
    'modules' => [],
    'params' => $params,
];

if (YII_DEBUG) {
    $viteCollector = new ViteCollector();

    $config['bootstrap'][] = 'debug';
    $config['components']['inertiaVue']['__construct()']['eventDispatcher'] = $viteCollector;
    $config['modules']['debug'] = [
        'class' => DebugModule::class,
        'allowedIPs' => $debugAllowedIPs,
        'collectors' => [
            'vite' => $viteCollector,
        ],
        'panels' => [
            'vite' => new VitePanel(),
        ],
    ];
}

return $config;
