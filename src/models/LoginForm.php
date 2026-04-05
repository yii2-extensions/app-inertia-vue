<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Represents the login form model with username/password authentication.
 *
 * @property User|null $user
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
class LoginForm extends Model
{
    public string $password = '';
    public bool $rememberMe = true;
    public string $username = '';

    private User|null $user = null;

    /**
     * Finds user by [[username]].
     *
     * @return User|null User `object`, or `null` if not found.
     */
    public function getUser(): User|null
    {
        if ($this->user === null) {
            $this->user = User::findByUsername($this->username);
        }

        return $this->user;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool Whether the user is logged in successfully.
     */
    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();

        if ($user === null) {
            return false;
        }

        return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    /**
     * @return array Validation rules for the model properties.
     *
     * @phpstan-return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            [
                [
                    'username',
                    'password',
                ],
                'required',
            ],
            [
                'rememberMe',
                'boolean',
            ],
            [
                'password',
                'validatePassword',
            ],
        ];
    }

    /**
     * Validates the password.
     *
     * This method serves as the inline validation for password.
     */
    public function validatePassword(string $attribute, mixed $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if ($user === null || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
}
