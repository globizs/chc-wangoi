<?php

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title>R.K.S. CHC Wangoi - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/images/nhm-logo.png" style="height: 2rem; margin-right: 1rem;">R.K.S. CHC Wangoi',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-light bg-light fixed-top',
        ],
    ]);

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer bg-dark mt-auto py-3 text-muted">
    <div class="container my-auto d-flex justify-content-between align-items-center" style="font-size: 12px;">
        <div>&copy; R.K.S. CHC Wangoi 2024</div>
        <div title="Technical support number">Tech. support: 844 844 7720</div>
        <div class="d-flex align-items-center">Powered by <a class="d-flex align-items-center" href="https://globizs.com" target="_blank"><img src="/images/globizs.png" style="height: 1rem;"></a></div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
