<?php

declare(strict_types=1);

namespace app\models;

use yii\base\Model;
use yii\mail\MailerInterface;

/**
 * Handles password reset request via email.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
final class PasswordResetRequestForm extends Model
{
    public string $email = '';

    /**
     * @return array Validation rules for the model properties.
     *
     * @phpstan-return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            [
                'email',
                'trim',
            ],
            [
                'email',
                'required',
            ],
            [
                'email',
                'email',
            ],
            [
                'email',
                'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.',
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @param MailerInterface $mailer Mailer component used to send the email.
     * @param string $supportEmail Support email address to use as the sender.
     *
     * @return bool Whether the email was sent successfully.
     */
    public function sendEmail(MailerInterface $mailer, string $supportEmail, string $appName): bool
    {
        $user = User::findOne(
            [
                'status' => User::STATUS_ACTIVE,
                'email' => $this->email,
            ],
        );

        if ($user === null) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();

            if (!$user->save()) {
                return false;
            }
        }

        return $mailer
            ->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
            ->setFrom([$supportEmail => "{$appName} robot"])
            ->setTo($this->email)
            ->setSubject("Password reset for {$appName}")
            ->send();
    }
}
