<?php

declare(strict_types=1);

namespace app\tests\support\Fixtures;

use app\models\User;
use yii\test\ActiveFixture;

/**
 * Provides user fixture data for authentication tests.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}
