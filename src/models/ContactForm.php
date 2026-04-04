<?php

declare(strict_types=1);

namespace app\models;

use yii\base\Model;
use yii\mail\MailerInterface;

/**
 * Represents the contact form model with phone validation, Turnstile CAPTCHA, and email sending.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
class ContactForm extends Model
{
    public string $body = '';
    public string $email = '';
    public string $name = '';
    public string $phone = '';
    public string $subject = '';
    public string $turnstileToken = '';

    /**
     * Sends an email to the specified email address using the information collected by this model.
     */
    public function contact(MailerInterface $mailer, string $email, string $senderEmail, string $senderName): bool
    {
        if ($this->validate()) {
            return $mailer->compose()
                ->setTo($email)
                ->setFrom([$senderEmail => $senderName])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
        }

        return false;
    }

    /**
     * @phpstan-return array<array<mixed>> The validation rules.
     */
    public function rules(): array
    {
        return [
            [
                [
                    'name',
                    'email',
                    'phone',
                    'subject',
                    'body',
                    'turnstileToken',
                ],
                'required',
            ],
            [
                'email',
                'email',
            ],
            [
                'phone',
                'match',
                'pattern' => '/^\(\d{3}\) \d{3}-\d{4}$/',
                'message' => 'Phone number must match (999) 999-9999 format.',
            ],
            [
                'turnstileToken',
                'validateTurnstile',
            ],
        ];
    }

    /**
     * @phpstan-return array<string, string>
     */
    public function attributeLabels(): array
    {
        return [
            'turnstileToken' => 'CAPTCHA verification',
        ];
    }

    /**
     * Validates the Turnstile CAPTCHA token via Cloudflare API.
     */
    public function validateTurnstile(string $attribute, mixed $params): void
    {
        if ($this->hasErrors()) {
            return;
        }

        $secretKey = \Yii::$app->params['turnstile.secretKey'] ?? '';

        if ($secretKey === '') {
            return;
        }

        $response = file_get_contents('https://challenges.cloudflare.com/turnstile/v0/siteverify', false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'timeout' => 5,
                'content' => http_build_query([
                    'secret' => $secretKey,
                    'response' => $this->turnstileToken,
                ]),
            ],
        ]));

        if ($response === false) {
            \Yii::warning('Turnstile verification request failed.', __METHOD__);
            $this->addError($attribute, 'CAPTCHA verification failed. Please try again.');

            return;
        }

        /** @phpstan-var array{success: bool} $result */
        $result = json_decode($response, true);

        if (!$result['success']) {
            $this->addError($attribute, 'CAPTCHA verification failed. Please try again.');
        }
    }
}
