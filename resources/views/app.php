<?php

declare(strict_types=1);

use yii\helpers\Html;
use yii\inertia\Page;
use yii\inertia\vue\Vite;
use yii\web\View;

/**
 * @var Page $page
 * @var string $id
 * @var string $pageJson
 * @var View $this
 * @phpstan-var Vite $vite
 */
$vite = Yii::$app->inertiaVue;

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Html::encode(Yii::$app->language) ?>" class="h-100" data-bs-theme="light">
<head>
    <meta charset="<?= Html::encode(Yii::$app->charset) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title data-inertia><?= Html::encode(Yii::$app->name) ?></title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head(); ?>
    <?= $vite->renderTags() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody(); ?>
<div id="<?= Html::encode($id) ?>">
    <script type="application/json"><?= $pageJson ?></script>
</div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
