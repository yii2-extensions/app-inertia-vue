<?php

declare(strict_types=1);

defined('YII_ENV') || define('YII_ENV', getenv('YII_ENV') ?: 'prod');
defined('YII_DEBUG') || define('YII_DEBUG', YII_ENV !== 'prod');

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
