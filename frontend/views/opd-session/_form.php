<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$options = Yii::$app->params['bs5_floating_label_options'];
$template = Yii::$app->params['bs5_floating_label_template'];

$statuses = ['1' => 'Active', '0' => 'Deleted'];

?>

<div class="session-form">

    <?php $form = ActiveForm::begin(['id' => 'app-form']); ?>

    <?= $form->field($model, 'name', ['options' => $options, 'template' => $template])->textInput(['maxlength' => true, 'placeholder' => '']) ?>

    <?= $form->field($model, 'fee', ['options' => $options, 'template' => $template])->textInput(['type' => 'number', 'placeholder' => '']) ?>

    <?= $form->field($model, 'start_time', ['options' => $options, 'template' => $template])->textInput(['placeholder' => '']) ?>

    <?= $form->field($model, 'current_session', ['options' => $options, 'template' => $template])->dropDownList(['1' => 'Yes', '0' => 'No']) ?>

    <?= $form->field($model, 'is_active', ['options' => $options, 'template' => $template])->dropDownList($statuses) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'submit-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
