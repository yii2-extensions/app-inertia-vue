<?php

declare(strict_types=1);

use yii\rbac\Item;

return [
    'admin' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => [
            'viewUsers',
        ],
    ],
    'viewUsers' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'View the users grid',
    ],
];
