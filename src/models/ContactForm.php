<?php

declare(strict_types=1);

namespace app\models;

use yii\base\Model;
use yii\mail\MailerInterface;

/**
 * Represents the contact form model with phone validation and email sending.
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
        ];
    }
}
