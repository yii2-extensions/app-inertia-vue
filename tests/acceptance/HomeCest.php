<?php

declare(strict_types=1);

namespace app\tests\acceptance;

use app\tests\support\AcceptanceTester;
use Yii;
use yii\helpers\Url;

/**
 * Acceptance tests for the home page.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
final class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see(Yii::$app->name);

        $I->seeLink('About');
        $I->click('About');

        $I->see('About');
    }
}
