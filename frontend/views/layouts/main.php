<?php
use yii\helpers\Html;

\frontend\assets\AppAsset::register($this);
\frontend\assets\AdminAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower/startbootstrap-sb-admin-2');

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title>CHC Wangoi - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body id="page-top">

<?php $this->beginBody() ?>

<div id="wrapper" class="modalblur">

    <?= $this->render('sidebar.php') ?>

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">
            <?= $this->render('header.php', [
                'directoryAsset' => $directoryAsset
            ]) ?>

            <?= $this->render('content.php', [
                'content' => $content, 'directoryAsset' => $directoryAsset
            ]) ?>
        </div>

        <?= $this->render('footer.php', [
            'content' => $content, 'directoryAsset' => $directoryAsset
        ]) ?>
    </div>
</div>

<div id="mainloader"></div>

<div class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex justify-content-between align-items-center">
        <div class="toast-body"></div>
        <button type="button" class="btn-close btn-close-white me-3" onclick="$(this).parent().parent().hide()" aria-label="Close"></button>
    </div>
</div>

<?= $this->render('modal') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
