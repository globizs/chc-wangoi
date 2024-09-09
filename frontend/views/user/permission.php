<?php

use mdm\admin\AnimateAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;

AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'items' => $model->getItems(),
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_permission.js'));     // script has been modded to show only permissions. For original, see Mdm Soft src
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<div class="text-center"><small><i>Press Ctrl + Click to select multiple</i></small></div>
<div class="row">
    <div class="col-sm-5">
        <div class="text-warning"><b>Available Permissions</b></div>
        <input type="hidden" class="form-control search" data-target="available">
        <select multiple size="20" class="form-control list" data-target="available"></select>
    </div>
    <div class="col-sm-2 text-center">
        <br><br><br><br><br><br><br><br>
        <?=Html::a('<i class="fas fa-chevron-right"></i>' . $animateIcon, ['assign', 'id' => (string) $model->id], [
            'class' => 'btn btn-primary btn-assign',
            'data-target' => 'available',
            'title' => 'Assign',
        ]) ?>
        <br><br>
        <?=Html::a('<i class="fas fa-chevron-left"></i>' . $animateIcon, ['revoke', 'id' => (string) $model->id], [
            'class' => 'btn btn-danger btn-assign',
            'data-target' => 'assigned',
            'title' => 'Remove',
        ]) ?>
    </div>
    <div class="col-sm-5">
        <div class="text-primary"><b>Assigned to <?= $model->username ?></b></div>
        <input type="hidden" class="form-control search" data-target="assigned">
        <select multiple size="20" class="form-control list" data-target="assigned"></select>
    </div>
</div>
