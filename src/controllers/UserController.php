<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResendVerificationEmailForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\User;
use app\models\UserSearch;
use app\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\inertia\web\Controller;
use yii\mail\MailerInterface;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Handles user-related actions: login, logout, signup, password recovery, email verification, and user listing.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
class UserController extends Controller
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
     * Displays user list.
     */
    public function actionIndex(): Response
    {
        $searchModel = new UserSearch();

        /** @phpstan-var array<string, mixed> $queryParams */
        $queryParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($queryParams);

        /** @var User[] $models */
        $models = $dataProvider->getModels();

        $users = array_map(
            static fn(User $model): array => [
                'id' => $model->id,
                'username' => $model->username,
                'email' => $model->email,
                'status' => $model->status,
                'created_at' => $model->created_at,
            ],
            $models,
        );

        $pagination = $dataProvider->getPagination();
        $sort = $dataProvider->getSort();

        return $this->inertia(
            'User/Index',
            [
                'users' => $users,
                'pagination' => [
                    'totalCount' => $dataProvider->getTotalCount(),
                    'pageSize' => $pagination !== false ? $pagination->getPageSize() : 10,
                    'currentPage' => $pagination !== false ? $pagination->getPage() + 1 : 1,
                    'pageCount' => $pagination !== false ? $pagination->getPageCount() : 1,
                ],
                'sort' => [
                    'attributes' => $sort instanceof \yii\data\Sort ? $sort->getAttributeOrders() : [],
                ],
                'filters' => [
                    'username' => $searchModel->username,
                    'email' => $searchModel->email,
                    'status' => $searchModel->status,
                ],
            ],
        );
    }

    /**
     * Login action.
     */
    public function actionLogin(): Response
    {
        $model = new LoginForm();

        /** @phpstan-var array<string, mixed> $post */
        $post = $this->request->post();

        if ($model->load($post) && $model->login()) {
            return $this->goBack();
        }

        if ($this->request->isPost && $model->hasErrors()) {
            Yii::$app->session->setFlash('errors', $model->getErrors());

            return $this->redirect(['user/login']);
        }

        return $this->inertia('User/Login');
    }

    /**
     * Logout action.
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     */
    public function actionRequestPasswordReset(): Response
    {
        $model = new PasswordResetRequestForm();

        /** @phpstan-var array<string, mixed> $post */
        $post = $this->request->post();

        $params = Yii::$app->params;

        if ($model->load($post) && $model->validate()) {
            $sent = $model->sendEmail(
                $this->mailer,
                $params['supportEmail'],
                Yii::$app->name,
            );

            if ($sent) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash(
                'error',
                'Sorry, we are unable to reset password for the provided email address.',
            );

            return $this->redirect(['user/request-password-reset']);
        }

        if ($this->request->isPost && $model->hasErrors()) {
            Yii::$app->session->setFlash('errors', $model->getErrors());

            return $this->redirect(['user/request-password-reset']);
        }

        return $this->inertia('User/RequestPasswordReset');
    }

    /**
     * Resends verification email.
     */
    public function actionResendVerificationEmail(): Response
    {
        $model = new ResendVerificationEmailForm();

        /** @phpstan-var array<string, mixed> $post */
        $post = $this->request->post();

        $params = Yii::$app->params;

        if ($model->load($post) && $model->validate()) {
            $sent = $model->sendEmail(
                $this->mailer,
                $params['supportEmail'],
                Yii::$app->name,
            );

            if ($sent) {
                Yii::$app->session->setFlash(
                    'success',
                    'Check your email for further instructions.',
                );

                return $this->goHome();
            }

            Yii::$app->session->setFlash(
                'error',
                'Sorry, we are unable to resend verification email for the provided email address.',
            );

            return $this->redirect(['user/resend-verification-email']);
        }

        if ($this->request->isPost && $model->hasErrors()) {
            Yii::$app->session->setFlash('errors', $model->getErrors());

            return $this->redirect(['user/resend-verification-email']);
        }

        return $this->inertia('User/ResendVerificationEmail');
    }

    /**
     * Resets password.
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword(string $token): Response
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        /** @phpstan-var array<string, mixed> $post */
        $post = $this->request->post();

        if ($model->load($post) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash(
                'success',
                'New password saved.',
            );

            return $this->goHome();
        }

        if ($this->request->isPost && $model->hasErrors()) {
            Yii::$app->session->setFlash('errors', $model->getErrors());

            return $this->redirect(['user/reset-password', 'token' => $token]);
        }

        return $this->inertia('User/ResetPassword', ['token' => $token]);
    }

    /**
     * Signs user up.
     */
    public function actionSignup(): Response
    {
        $model = new SignupForm();

        /** @phpstan-var array<string, mixed> $post */
        $post = $this->request->post();

        $params = Yii::$app->params;

        $signed = $model->load($post) && $model->signup(
            $this->mailer,
            $params['supportEmail'],
            Yii::$app->name,
        ) === true;

        if ($signed) {
            Yii::$app->session->setFlash(
                'success',
                'Thank you for registration. Please check your inbox for verification email.',
            );

            return $this->goHome();
        }

        if ($this->request->isPost && $model->hasErrors()) {
            Yii::$app->session->setFlash('errors', $model->getErrors());

            return $this->redirect(['user/signup']);
        }

        return $this->inertia('User/Signup');
    }

    /**
     * Verifies email address.
     *
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail(string $token): Response
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->verifyEmail() !== null) {
            Yii::$app->session->setFlash(
                'success',
                'Your email has been confirmed!',
            );

            return $this->goHome();
        }

        Yii::$app->session->setFlash(
            'error',
            'Sorry, we are unable to verify your account with provided token.',
        );

        return $this->goHome();
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'index',
                    'login',
                    'logout',
                    'request-password-reset',
                    'resend-verification-email',
                    'reset-password',
                    'signup',
                    'verify-email',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'login',
                            'request-password-reset',
                            'resend-verification-email',
                            'reset-password',
                            'signup',
                            'verify-email',
                        ],
                        'allow' => true,
                        'roles' => [
                            '?',
                        ],
                    ],
                    [
                        'actions' => [
                            'index',
                        ],
                        'allow' => true,
                        'roles' => [
                            'admin',
                        ],
                    ],
                    [
                        'actions' => [
                            'logout',
                        ],
                        'allow' => true,
                        'roles' => [
                            '@',
                        ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => [
                        'get',
                    ],
                    'logout' => [
                        'post',
                    ],
                ],
            ],
        ];
    }
}
