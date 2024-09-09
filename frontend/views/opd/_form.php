<?php

use frontend\models\Department;
use frontend\models\OpdSession;
use frontend\models\Religion;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

$options = Yii::$app->params['bs5_floating_label_options'];
$template = Yii::$app->params['bs5_floating_label_template'];

$opdSessions = ArrayHelper::map(OpdSession::find()->asArray()->select('id, name')->where(['is_active' => '1'])->all(), 'id', 'name');
$religions = ArrayHelper::map(Religion::find()->asArray()->select('name')->where(['is_active' => '1'])->orderBy('name')->all(), 'name', 'name');
$departments = ArrayHelper::map(Department::find()->asArray()->select('id, name')->where(['is_active' => '1'])->orderBy('name')->all(), 'id', 'name');
$statues = ['1' => 'Active', '0' => 'Deleted'];

?>

<div class="opd-form">

    <?php $form = ActiveForm::begin(['id' => 'app-form']); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'opd_date')->widget(DatePicker::class, [
                'options' => ['placeholder' => 'OPD date', 'autocomplete' => 'off'],
                'removeButton' => false,
                'pluginOptions' => [
                    'format' => 'mm/dd/yyyy',
                    'autoclose' => true,
                    'todayHighlight' => true,
                ]
            ])->label(false); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'opd_session_id', ['options' => $options, 'template' => $template])->dropDownList($opdSessions, ['prompt' => '- Select OPD session']) ?>            
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'fee_amount', ['options' => $options, 'template' => $template])->textInput(['placeholder' => '']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'abha_id', ['options' => $options, 'template' => $template])->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'patient_name', ['options' => $options, 'template' => $template])->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'care_taker_name', ['options' => $options, 'template' => $template])->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'age', ['options' => $options, 'template' => $template])->textInput(['placeholder' => '']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'gender', ['options' => $options, 'template' => $template])->dropDownList(['Male' => 'Male', 'Female' => 'Female', 'Transgender' => 'Transgender'], ['prompt' => '- Gender -']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'religion_id', ['options' => $options, 'template' => $template])->dropDownList($religions, ['prompt' => '- Select religion -']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'address', ['options' => $options, 'template' => $template])->textarea(['rows' => 3, 'placeholder' => '']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'diagnosis', ['options' => $options, 'template' => $template])->textarea(['rows' => 3, 'placeholder' => '']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'department_id', ['options' => $options, 'template' => $template])->dropDownList($departments, ['prompt' => '- Select department -']) ?>
        </div>
        <?php if (!$model->isNewRecord) { ?>
            <div class="col-md-3">
                <?= $form->field($model, 'is_active', ['options' => $options, 'template' => $template])->dropDownList($statues) ?>
            </div>
        <?php } ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'submit-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
