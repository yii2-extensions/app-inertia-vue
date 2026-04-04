<?php

declare(strict_types=1);

namespace app\migrations;

use app\models\User;
use yii\db\Migration;

/**
 * Seeds the default administrator user.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
class M260403000000CreateAdminUser extends Migration
{
    public function safeDown(): bool
    {
        /** @phpstan-var string $username */
        $username = \Yii::$app->params['admin.username'] ?? 'admin';

        $this->delete('{{%user}}', ['username' => $username]);

        return true;
    }

    public function safeUp(): bool
    {
        /** @phpstan-var string $username */
        $username = \Yii::$app->params['admin.username'] ?? 'admin';

        /** @phpstan-var string $password */
        $password = \Yii::$app->params['admin.password'] ?? 'admin';

        /** @phpstan-var string $email */
        $email = \Yii::$app->params['admin.email'] ?? 'admin@example.com';

        $time = time();

        $this->insert(
            '{{%user}}',
            [
                'username' => $username,
                'auth_key' => \Yii::$app->security->generateRandomString(),
                'password_hash' => \Yii::$app->security->generatePasswordHash($password),
                'email' => $email,
                'status' => User::STATUS_ACTIVE,
                'created_at' => $time,
                'updated_at' => $time,
            ],
        );

        return true;
    }
}
