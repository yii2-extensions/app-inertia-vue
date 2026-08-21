<?php

declare(strict_types=1);

namespace app\tests\support\Fixtures;

use app\models\User;
use yii\test\ActiveFixture;

/**
 * Provides user fixture data for authentication tests.
 */
class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}
