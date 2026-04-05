<?php

declare(strict_types=1);

use yii\db\Connection;

return [
    'class' => Connection::class,
    'dsn' => 'sqlite:' . dirname(__DIR__) . '/runtime/db.sqlite',
];
