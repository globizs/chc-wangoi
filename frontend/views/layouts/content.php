<?php
use yii\bootstrap5\Breadcrumbs;
use common\widgets\Alert;

?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-1">

        <h3 id="page-title"><?= $this->title ?></h3>

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>    

    <div class="row">
        <div class="col-md-12">
        <?= Alert::widget([
            'closeButton' => ['class' => 'btn-close', 'data-bs-dismiss' => 'alert']     // bootstrap 5 compatibility
        ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $content ?>
        </div>
    </div>
</div>
