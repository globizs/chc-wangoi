<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$options = Yii::$app->params['bs5_floating_label_options'];
$template = Yii::$app->params['bs5_floating_label_template'];
?>
<div class="site-login">
    <br>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'app-form']); ?>

                <?= $form->field($model, 'username', ['options' => $options, 'template' => $template])->textInput(['autofocus' => true, 'placeholder' => '']) ?>

                <?= $form->field($model, 'password', ['options' => $options, 'template' => $template])->passwordInput(['placeholder' => '']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
