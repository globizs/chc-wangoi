<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\editors\Summernote;

$this->title = 'Edit ' . $model->friendly_name;
$this->params['breadcrumbs'][] = ['label' => 'General Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(['id' => 'app-form']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'submit-btn']) ?>
    </div>

    <?php if ($model->input_type == 'richtext') { ?>
        <?= $form->field($model, 'value')->widget(Summernote::class, [
            'useKrajeePresets' => true,
        ])->label(false) ?>
    <?php } else { ?>
        <div class="row">
            <div class="col-md-4">
                <?php
                if ($model->options) {
                    $options = explode(',', $model->options);
                    $options = array_combine($options, $options);
                ?>
                    <?= $form->field($model, 'value')->dropDownList($options) ?>
                <?php } else { ?>
                    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
                <?php }?>
            </div>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<style>
.note-editor.note-frame.card {
    margin: -1rem;
}
.note-editor.note-frame.card.fullscreen {
    margin: 0;
}
</style>
