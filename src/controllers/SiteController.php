<?php

declare(strict_types=1);

namespace app\controllers;

use PHPForge\Inertia\Prop\{ScrollMetadata, ScrollProp};
use Throwable;
use Yii;
use yii\inertia\Inertia;
use yii\inertia\web\Controller;
use yii\web\{HttpException, Response};

/**
 * Handles site pages: home, about, and error actions.
 */
final class SiteController extends Controller
{
    private const int PROTOCOL_PAGE_SIZE = 3;

    private const array PROTOCOL_TRACE = [
        [
            'id' => 1,
            'layer' => 'YII ADAPTER',
            'title' => 'Yii receives the visit.',
            'detail' => 'The adapter translates the incoming request into a framework-neutral context.',
            'accent' => 'blue',
        ],
        [
            'id' => 2,
            'layer' => 'PHP CORE',
            'title' => 'One page contract is shaped.',
            'detail' => 'Component, props, URL, version, and protocol metadata stay together.',
            'accent' => 'green',
        ],
        [
            'id' => 3,
            'layer' => 'SCROLL PROP',
            'title' => 'The next page is declared.',
            'detail' => 'Scroll metadata names the query key and the adjacent page identifiers.',
            'accent' => 'orange',
        ],
        [
            'id' => 4,
            'layer' => 'OBSERVER',
            'title' => 'The boundary enters view.',
            'detail' => 'The client detects the edge of this contained scroll window.',
            'accent' => 'blue',
        ],
        [
            'id' => 5,
            'layer' => 'PARTIAL RELOAD',
            'title' => 'Only one prop travels.',
            'detail' => 'Inertia requests protocolFeed instead of rebuilding the complete page.',
            'accent' => 'green',
        ],
        [
            'id' => 6,
            'layer' => 'MERGE INTENT',
            'title' => 'The next slice is appended.',
            'detail' => 'The protocol marks protocolFeed.data as the merge path.',
            'accent' => 'orange',
        ],
        [
            'id' => 7,
            'layer' => 'INTERFACE',
            'title' => 'Existing entries remain.',
            'detail' => 'Vue extends the list without remounting the surrounding evaluation.',
            'accent' => 'blue',
        ],
        [
            'id' => 8,
            'layer' => 'HISTORY',
            'title' => 'The visible page follows.',
            'detail' => 'The query string tracks the page with the largest visible share.',
            'accent' => 'green',
        ],
        [
            'id' => 9,
            'layer' => 'COMPLETE',
            'title' => 'The final cursor resolves.',
            'detail' => 'A null next page stops requests at the last protocol boundary.',
            'accent' => 'orange',
        ],
    ];

    /**
     * Displays about page.
     *
     * @return Response Response object containing the rendered about page.
     */
    public function actionAbout(): Response
    {
        return $this->inertia(
            'Site/About',
        );
    }

    /**
     * Displays error page.
     *
     * @return Response Response object containing the rendered error page.
     */
    public function actionError(): Response
    {
        $exception = Yii::$app->errorHandler->exception;

        $statusCode = $exception instanceof HttpException ? $exception->statusCode : 500;
        $message = (YII_DEBUG && $exception instanceof Throwable)
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
     *
     * @return Response Response object containing the rendered homepage.
     */
    public function actionIndex(): Response
    {
        return $this->inertia(
            'Site/Index',
            [
                'protocolFeed' => $this->createProtocolFeed(),
                'runtime' => [
                    'framework' => Yii::getVersion(),
                    'php' => PHP_VERSION,
                    'requestId' => strtoupper(
                        substr(
                            hash('sha256', sprintf('%.6F', microtime(true))),
                            0,
                            8,
                        ),
                    ),
                    'servedAt' => gmdate('H:i:s') . ' UTC',
                ],
            ],
        );
    }

    /**
     * Builds the deterministic pages used by the live Inertia scroll demonstration.
     */
    private function createProtocolFeed(): ScrollProp
    {
        $total = count(self::PROTOCOL_TRACE);
        $totalPages = intdiv($total + self::PROTOCOL_PAGE_SIZE - 1, self::PROTOCOL_PAGE_SIZE);
        $requestedPage = filter_var(
            $this->request->getQueryParam('protocol', 1),
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]],
        );
        $page = is_int($requestedPage) ? min($requestedPage, $totalPages) : 1;

        return Inertia::scroll(
            [
                'data' => array_slice(
                    self::PROTOCOL_TRACE,
                    ($page - 1) * self::PROTOCOL_PAGE_SIZE,
                    self::PROTOCOL_PAGE_SIZE,
                ),
                'page' => $page,
                'pages' => $totalPages,
                'total' => $total,
            ],
            new ScrollMetadata(
                pageName: 'protocol',
                previousPage: $page > 1 ? $page - 1 : null,
                nextPage: $page < $totalPages ? $page + 1 : null,
                currentPage: $page,
            ),
        );
    }
}
