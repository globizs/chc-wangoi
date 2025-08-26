<?php

use frontend\models\Department;
use frontend\models\OpdSession;
use frontend\models\Religion;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\date\DatePicker;

$options = Yii::$app->params['bs5_floating_label_options'];
$template = Yii::$app->params['bs5_floating_label_template'];

$opdSessionsRaw = OpdSession::find()->asArray()->select('id, name, fee')->where(['is_active' => '1'])->all();

$opdSessions = ArrayHelper::map($opdSessionsRaw, 'id', 'name');
$opdSessionFees = ArrayHelper::map($opdSessionsRaw, 'id', 'fee');

$religions = ArrayHelper::map(Religion::find()->asArray()->select('id, name')->where(['is_active' => '1'])->orderBy('name')->all(), 'id', 'name');
$departments = ArrayHelper::map(Department::find()->asArray()->select('id, name')->where(['is_active' => '1'])->orderBy('name')->all(), 'id', 'name');
$statues = ['1' => 'Active', '0' => 'Deleted'];

$getPatientDetailsFromAbhaUrl = Url::to(['/opd/get-patient-by-abha', 'abha_id' => '']);
$getPatientDetailsFromAadhaarUrl = Url::to(['/opd/get-patient-by-aadhaar', 'aadhaar_no' => '']);
$formatAgeUrl = Url::to(['/opd/format-age', 'date_of_birth' => '']);

?>

<div class="opd-form">

    <?php $form = ActiveForm::begin(['id' => 'app-form']); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'opd_date')->widget(DateTimePicker::class, [
                'options' => ['placeholder' => 'OPD date', 'autocomplete' => 'off'],
                'removeButton' => false,
                'pluginOptions' => [
                    'format' => 'dd/mm/yyyy HH:ii P',
                    'autoclose' => true,
                    'todayHighlight' => true,
                    'showMeridian' => true,
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
            <?= $form->field($model, 'aadhaar_no', ['options' => $options, 'template' => $template])->textInput(['placeholder' => '']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'patient_name', ['options' => $options, 'template' => $template])->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'care_taker_name', ['options' => $options, 'template' => $template])->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'contact_no', ['options' => $options, 'template' => $template])->textInput(['placeholder' => '']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Date of Birth'],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-M-yyyy'
                ]
            ])->label(false) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'age_formatted', ['options' => $options, 'template' => $template])->textInput(['placeholder' => '', 'readonly' => true]) ?>
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

<?php
$opdSessionFees = json_encode($opdSessionFees);

$this->registerJs(<<<JS
var sessionFees = $opdSessionFees;
$("#opd-opd_session_id").change(function() {
    const opdFee = sessionFees[this.value];
    $("#opd-fee_amount").val(opdFee);
});

var gotAbha = false;
var gotAadhaar = false;

$("#opd-abha_id").blur(function() {
    if (gotAadhaar) return false;      // already got from aadhaar

    const abhaId = $(this).val();

    if (abhaId.length === 14) {
        $.get("$getPatientDetailsFromAbhaUrl" + abhaId, function(data) {
            data = JSON.parse(data);
            if (data) {
                $("#opd-aadhaar_no").val(data.aadhaar_no);
                $("#opd-patient_name").val(data.patient_name);
                $("#opd-care_taker_name").val(data.care_taker_name);
                $("#opd-date_of_birth").val(data.date_of_birth);
                $("#opd-contact_no").val(data.contact_no);
                $("#opd-gender").val(data.gender);
                $("#opd-religion_id").val(data.religion_id);
                $("#opd-address").val(data.address);

                gotAbha = true;

                formatAge()
            }
        });
    }
});

$("#opd-aadhaar_no").blur(function() {
    if (gotAbha) return false;          // already got from abha

    const aadhaar_no = $(this).val();

    if (aadhaar_no.length === 12) {
        $.get("$getPatientDetailsFromAadhaarUrl" + aadhaar_no, function(data) {
            data = JSON.parse(data);
            if (data) {
                $("#opd-abha_id").val(data.abha_id);
                $("#opd-patient_name").val(data.patient_name);
                $("#opd-care_taker_name").val(data.care_taker_name);
                $("#opd-date_of_birth").val(data.date_of_birth);
                $("#opd-contact_no").val(data.contact_no);
                $("#opd-gender").val(data.gender);
                $("#opd-religion_id").val(data.religion_id);
                $("#opd-address").val(data.address);

                gotAadhaar = true;

                formatAge();
            }
        });
    }
});

$("#opd-date_of_birth").change(function() {
    formatAge();
});

// get formatted age from dob
function formatAge() {
    const date_of_birth = $("#opd-date_of_birth").val();
    const opd_date = $("#opd-opd_date").val();

    if (!date_of_birth.length) return;

    $.get("$formatAgeUrl" + date_of_birth + "&date=" + opd_date, function(data) {
        data = JSON.parse(data);
        if (data) {
            $("#opd-age_formatted").val(data.age_formatted);
        }
    });
}
JS
);
