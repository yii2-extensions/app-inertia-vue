<?php

declare(strict_types=1);

namespace app\tests\unit;

use app\commands\HelloController;
use Codeception\Test\Unit;
use yii\base\InvalidRouteException;
use yii\console\{Application, Exception, ExitCode};

use function ob_get_clean;
use function ob_start;

/**
 * Unit tests for {@see HelloController} output behavior.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
final class HelloControllerTest extends Unit
{
    /**
     * @throws Exception if an unexpected error occurs during execution.
     * @throws InvalidRouteException if the action route is invalid.
     */
    public function testIndexActionOutputsCustomMessage(): void
    {
        $application = new Application(['id' => 'test', 'basePath' => dirname(__DIR__, 2)]);
        $helloController = new HelloController('hello', $application);

        ob_start();
        $exitCode = $helloController->runAction('index', ['custom message']);
        $result = ob_get_clean();

        self::assertSame(
            "custom message\n",
            $result,
            'Output should match the custom message provided as an argument.',
        );
        self::assertSame(
            ExitCode::OK,
            $exitCode,
            'Exit code should be OK.',
        );
    }

    /**
     * @throws Exception if an unexpected error occurs during execution.
     * @throws InvalidRouteException if the action route is invalid.
     */
    public function testIndexActionOutputsDefaultMessage(): void
    {
        $application = new Application(['id' => 'test', 'basePath' => dirname(__DIR__, 2)]);
        $helloController = new HelloController('hello', $application);

        ob_start();
        $exitCode = $helloController->runAction('index');
        $result = ob_get_clean();

        self::assertSame(
            "hello world\n",
            $result,
            'Output should match the default message.',
        );
        self::assertSame(
            ExitCode::OK,
            $exitCode,
            'Exit code should be OK.',
        );
    }
}
