<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$options = Yii::$app->params['bs5_floating_label_options'];
$template = Yii::$app->params['bs5_floating_label_template'];
?>

<?php $form = ActiveForm::begin(['id' => 'app-form']); ?>

<?= $form->field($model, 'oldPassword', ['options' => $options, 'template' => $template])->passwordInput(['placeholder'=> '']) ?>

<?= $form->field($model, 'newPassword', ['options' => $options, 'template' => $template])->passwordInput(['placeholder'=> '']) ?>

<?= $form->field($model, 'confirmNewPassword', ['options' => $options, 'template' => $template])->passwordInput(['placeholder'=> '']) ?>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
</div>

<?php ActiveForm::end(); ?>
