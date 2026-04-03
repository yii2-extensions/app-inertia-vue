<?php

declare(strict_types=1);

namespace app\tests\acceptance;

use app\tests\support\AcceptanceTester;
use yii\helpers\Url;

/**
 * Acceptance tests for the contact page.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
final class ContactCest
{
    public function contactPageWorks(AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/contact'));
        $I->see('Contact');
    }
}
