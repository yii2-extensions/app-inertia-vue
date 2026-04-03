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
        $this->delete('{{%user}}', ['username' => 'admin']);

        return true;
    }

    public function safeUp(): bool
    {
        $time = time();

        $this->insert(
            '{{%user}}',
            [
                'username' => 'admin',
                'auth_key' => 'admin-auth-key-seed-value-ok32',
                'password_hash' => \Yii::$app->security->generatePasswordHash('admin'),
                'email' => 'admin@example.com',
                'status' => User::STATUS_ACTIVE,
                'created_at' => $time,
                'updated_at' => $time,
            ],
        );

        return true;
    }
}
