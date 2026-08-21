<?php

declare(strict_types=1);

namespace app\tests\acceptance;

use app\tests\support\AcceptanceTester;
use yii\helpers\Url;

/**
 * Acceptance tests for the about page.
 */
final class AboutCest
{
    public function ensureThatAboutWorks(AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/about'));
        $I->seeResponseCodeIs(200);
        $I->seeInSource('"component":"Site\/About"');
    }
}
