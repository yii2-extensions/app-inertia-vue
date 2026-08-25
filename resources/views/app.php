<?php

declare(strict_types=1);

use PHPForge\Inertia\Page;
use PHPForge\Vite\Html\HtmlRenderer;
use PHPForge\Vite\Vite;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * @var string $id Unique ID for the root element.
 * @var Page $page Page data.
 * @var string $pageJson JSON-encoded page data.
 * @var Vite $vite Vite asset manager instance.
 */
$vite = Yii::$app->get('inertiaVue');
$ogImageUrl = rtrim(Yii::$app->request->getHostInfo(), '/') . '/og.png';

if (!$vite instanceof Vite) {
    throw new InvalidConfigException(
        "The 'inertiaVue' application component must be an instance of " . Vite::class . '.',
    );
}

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Html::encode(Yii::$app->language) ?>" class="h-full scroll-smooth">
<head>
    <meta charset="<?= Html::encode(Yii::$app->charset) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title data-inertia>Yii 22.0 Preview — Modern PHP, familiar Yii</title>
    <meta data-inertia="description" name="description" content="Explore the Yii 22.0 development line with PHP 8.3, Inertia 3, Vue 3, and Vite 8.">
    <meta name="theme-color" content="#f6fbfd" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#071820" media="(prefers-color-scheme: dark)">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Yii 22.0 Preview — Modern PHP, familiar Yii">
    <meta property="og:description" content="A working Yii 22, Inertia, Vue, and Vite reference application.">
    <meta property="og:image" content="<?= Html::encode($ogImageUrl) ?>">
    <meta property="og:image:width" content="1731">
    <meta property="og:image:height" content="909">
    <meta property="og:image:alt" content="Yii 22.0 Preview — Modern PHP, familiar Yii">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Yii 22.0 Preview — Modern PHP, familiar Yii">
    <meta name="twitter:description" content="A working Yii 22, Inertia, Vue, and Vite reference application.">
    <meta name="twitter:image" content="<?= Html::encode($ogImageUrl) ?>">
    <meta name="twitter:image:alt" content="Yii 22.0 Preview — Modern PHP, familiar Yii">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Manrope:wght@400..800&family=Space+Grotesk:wght@400..700&display=swap" rel="stylesheet">
    <script>
    (function(){
        var t = localStorage.getItem('theme');
        if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    })();
    </script>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head(); ?>
    <?= HtmlRenderer::create()->render($vite->resolve()) ?>
</head>
<body class="flex flex-col h-full bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-sans antialiased">
<?php $this->beginBody(); ?>
<div id="<?= Html::encode($id) ?>">
    <script type="application/json"><?= $pageJson ?></script>
</div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
