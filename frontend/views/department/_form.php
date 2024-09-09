<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$statuses = ['1' => 'Active', '0' => 'Deleted'];

?>

<div class="department-form">

    <?php $form = ActiveForm::begin(['id' => 'app-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->dropDownList($statuses) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'submit-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
