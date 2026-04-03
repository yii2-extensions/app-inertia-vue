<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\ContactForm;
use Yii;
use yii\inertia\web\Controller;
use yii\mail\MailerInterface;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Handles site pages: home, about, contact, and error actions.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
class SiteController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly MailerInterface $mailer,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * Displays about page.
     */
    public function actionAbout(): Response
    {
        return $this->inertia('Site/About');
    }

    /**
     * Displays contact page.
     */
    public function actionContact(): Response
    {
        $model = new ContactForm();

        /** @phpstan-var array<string, mixed> $post */
        $post = $this->request->post();

        /** @phpstan-var array{adminEmail: string, senderEmail: string, senderName: string} $params */
        $params = Yii::$app->params;

        $contact = $model->load($post) && $model->contact(
            $this->mailer,
            $params['adminEmail'],
            $params['senderEmail'],
            $params['senderName'],
        );

        if ($contact) {
            Yii::$app->session->setFlash(
                'success',
                'Thank you for contacting us. We will respond to you as soon as possible.',
            );

            return $this->redirect(['site/contact']);
        }

        if ($this->request->isPost && $model->hasErrors()) {
            Yii::$app->session->setFlash('errors', $model->getErrors());

            return $this->redirect(['site/contact']);
        }

        return $this->inertia('Site/Contact');
    }

    /**
     * Displays error page.
     */
    public function actionError(): Response
    {
        $exception = Yii::$app->errorHandler->exception;

        $statusCode = $exception instanceof HttpException ? $exception->statusCode : 500;
        $message = $exception instanceof \Throwable
            ? $exception->getMessage()
            : 'An internal server error occurred.';

        return $this->inertia(
            'Site/Error',
            [
                'status' => $statusCode,
                'message' => $message,
            ],
        );
    }

    /**
     * Displays homepage.
     */
    public function actionIndex(): Response
    {
        return $this->inertia('Site/Index');
    }
}
