<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\daterange\DateRangePicker;

$genders = ['Male' => 'Male', 'Female' => 'Female', 'Transgender' => 'Transgender'];

?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'opd_registration_no')->textInput(['placeholder' => $model->getAttributeLabel('opd_registration_no'), 'class' => 'form-control form-control-sm'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'abha_id')->textInput(['placeholder' => $model->getAttributeLabel('abha_id'), 'class' => 'form-control form-control-sm'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'patient_name')->textInput(['placeholder' => $model->getAttributeLabel('patient_name'), 'class' => 'form-control form-control-sm'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'care_taker_name')->textInput(['placeholder' => $model->getAttributeLabel('care_taker_name'), 'class' => 'form-control form-control-sm'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'gender')->dropDownList($genders, ['prompt' => '- Gender -', 'class' => 'form-select form-select-sm'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'religion_id')->dropDownList($religions, ['prompt' => '- Religion -', 'class' => 'form-select form-select-sm'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= DateRangePicker::widget([
            'model'=>$model,
            'attribute'=>'opd_date',
            'options' => ['class' => 'form-control form-control-sm', 'placeholder' => 'OPD date range'],
            'convertFormat'=>true,
            'pluginOptions'=>[
                'locale'=>[
                    'format'=>'d-M-Y'
                ]
            ]
        ]) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'opd_session_id')->dropDownList($religions, ['prompt' => '- OPD Session -', 'class' => 'form-select form-select-sm'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'department_id')->dropDownList($departments, ['prompt' => '- Department -', 'class' => 'form-select form-select-sm'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'created_by_user_id')->dropDownList($users, ['prompt' => '- Entry by -', 'class' => 'form-select form-select-sm'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'is_active')->dropDownList($statuses, ['class' => 'form-select form-select-sm'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-outline-primary btn-sm']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
