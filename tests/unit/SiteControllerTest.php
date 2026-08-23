<?php

declare(strict_types=1);

namespace app\tests\unit;

use app\controllers\SiteController;
use Yii;
use yii\web\{HttpException, Response};

/**
 * Unit tests for {@see SiteController} all actions.
 *
 * @since 0.1
 */
final class SiteControllerTest extends \Codeception\Test\Unit
{
    public function testActionAbout(): void
    {
        $_SERVER['REQUEST_URI'] = '/site/about';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $controller = new SiteController('site', Yii::$app);

        Yii::$app->controller = $controller;
        $response = $controller->actionAbout();

        self::assertInstanceOf(
            Response::class,
            $response,
            "Expected 'actionAbout' to return an instance of Response.",
        );
    }

    public function testActionErrorWithGenericException(): void
    {
        $_SERVER['REQUEST_URI'] = '/site/error';
        $_SERVER['SERVER_NAME'] = 'localhost';

        $controller = new SiteController('site', Yii::$app);

        Yii::$app->controller = $controller;
        Yii::$app->errorHandler->exception = new \RuntimeException('Something went wrong');
        $response = $controller->actionError();

        self::assertInstanceOf(
            Response::class,
            $response,
            "Expected 'actionError' to return an instance of Response for generic exception.",
        );
    }

    public function testActionErrorWithHttpException(): void
    {
        $_SERVER['REQUEST_URI'] = '/site/error';
        $_SERVER['SERVER_NAME'] = 'localhost';

        $controller = new SiteController('site', Yii::$app);

        Yii::$app->controller = $controller;
        Yii::$app->errorHandler->exception = new HttpException(404, 'Page not found');
        $response = $controller->actionError();

        self::assertInstanceOf(
            Response::class,
            $response,
            "Expected 'actionError' to return an instance of Response for HTTP exception.",
        );
    }

    public function testActionErrorWithNullException(): void
    {
        $_SERVER['REQUEST_URI'] = '/site/error';
        $_SERVER['SERVER_NAME'] = 'localhost';

        $controller = new SiteController('site', Yii::$app);

        Yii::$app->controller = $controller;
        Yii::$app->errorHandler->exception = null;
        $response = $controller->actionError();

        self::assertInstanceOf(
            Response::class,
            $response,
            "Expected 'actionError' to return a generic error Response when exception is null.",
        );
    }

    public function testActionIndex(): void
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['SERVER_NAME'] = 'localhost';

        $controller = new SiteController('site', Yii::$app);

        Yii::$app->controller = $controller;
        $response = $controller->actionIndex();

        self::assertInstanceOf(
            Response::class,
            $response,
            "Expected 'actionIndex' to return an instance of Response.",
        );
    }
}
