<?php

use frontend\models\Department;
use yii\helpers\Url;

$departmentName = Department::find()->asArray()->select('name')->where(['id' => $model->department_id])->one();
$departmentName = $departmentName ? $departmentName['name'] : null;

$baseUrl = Url::base(true);
?>

<!-- Page -->
<div class="flex flex-col gap-3 h-full">

  <!-- Organization start -->
  <div class="flex flex-col">
    <div class="flex">
      <div>
        <img class="nhm-logo" src="<?= $baseUrl ?>/images/nhm-logo.png">
      </div>
      <div class="flex-1 text-center">
        <div class="text-center">
          <img class="mayek" src="/images/mayek.jpg">
        </div>
        <b class="text-2xl"><?= $receiptHeading ?></b>
      </div>
      <div class="text-end flex flex-col gap-3">
        <div class="flex justify-between">
          <div>&nbsp;</div>
          <div class="bordered rounded-1 fee-pad text-xl">&#8377; <?= $model->fee_amount ?> /-</div>
        </div>
      </div>
    </div>
    <div class="flex">
      <div style="flex-basis: 33%;" class="flex items-center"><b>Sl. No.: <?= $model->serial_no ?></b></div>
      <div style="flex-basis: 33%;" class="text-center bordered rounded-1 p-1"><b class=" text-xl"><?= $model->opdSession->name ?></b></div>
      <div style="flex-basis: 33%;" class="text-end flex items-center justify-end"><b>Date:&nbsp;</b><?= date('d/m/Y', strtotime($model->opd_date)) ?>&nbsp;<b>Time:&nbsp;</b><?= date('h:i a', strtotime($model->opd_date)) ?></div>
    </div>
  </div>
  <!-- Organization end -->

  <!-- Patient details start -->
  <div class="flex flex-col gap-1 border-top pt-3">
    <div class="flex justify-between">
      <div><b>O.P.D. Regn. No.: </b><?= $model->opd_registration_no . '/' . $model->serial_no; ?></div>
      <div><b><?= $model->getAttributelabel('aadhaar_no') ?>: </b><?= substr($model->aadhaar_no, 0, 4) . ' ' . substr($model->aadhaar_no, 4, 4) . ' ' . substr($model->aadhaar_no, 8, 4); ?></div>
      <div><b><?= $model->getAttributelabel('abha_id') ?>: </b><?= substr($model->abha_id, 0, 2) . '-' . substr($model->abha_id, 2, 4) . '-' . substr($model->abha_id, 6, 4) . '-' . substr($model->abha_id, 10, 4); ?></div>
    </div>
    <div class="flex justify-between">
      <div><b><?= $model->getAttributelabel('patient_name') ?>: </b><?= $model->patient_name ?></div>
      <div><b><?= $model->getAttributelabel('care_taker_name') ?>: </b><?= $model->care_taker_name ?></div>
    </div>
    <div class="flex">
      <div style="flex-basis: 35%;"><b><?= $model->getAttributelabel('contact_no') ?>: </b><?= $model->contact_no ?></div>
      <div style="flex-basis: 35%;"><b><?= $model->getAttributelabel('age') ?>: </b><?= $model->convertDaysToAge($model->age) ?></div>
      <div style="flex-basis: 10%;"><b><?= $model->getAttributelabel('gender')?>: </b><?= $model->gender ?></div>
      <div style="flex-basis: 20%;" class="text-end"><b><?= $model->getAttributelabel('religion')?>: </b><?= $model->religion ? $model->religion->name : null ?></div>
    </div>
    <div class="flex justify-between">
      <div><b><?= $model->getAttributelabel('address')?>: </b><?= $model->address ?></div>
      <div><b><?= $model->getattributelabel('department_id')?>: </b><?= $departmentName ?></div>
    </div>
  </div>
  <!-- Patient details end -->

  <!-- Treatment block start -->
  <div class="flex flex-1 bordered">
    <!-- Treatment box layout start -->
    <div class="flex flex-col flex-1">
      <!-- Diagnosis -->
      <div class="border-bottom px-1-5 p-1"><b>Diagnosis/Prov. Diagnosis: </b></div>

      <!-- Bottom row start -->
      <div class="flex flex-1">
        <!-- Left column start -->
        <div class="flex flex-col border-right" style="flex-basis: 25%;">
          <div class="flex flex-col flex-1 gap-1">
            <div class="flex flex-col gap-1 px-1-5 pt-1"><?= $vitalSigns ?></div>

            <div class="flex flex-col gap-1">
              <div class="border-y p-1-5"><b>General Physical Examination</b></div>
              <div class="flex flex-col gap-1 px-1-5"><?= $physicalExamination ?></div>
            </div>

            <div class="flex flex-col gap-1">
              <div class="border-y p-1-5"><b>Systemic Examination</b></div>
              <div class="flex flex-col gap-1 px-1-5 pb-1"><?= $systemicExamination ?></div>
            </div>
          </div>
          <div class="flex justify-between items-center border-top p-1-5">
            <div>Pregnant: </div>
            <div class="flex gap-1">
              <div class="flex items-center">
                <input type="checkbox"><span>Yes</span>
              </div>
              <div class="flex items-center">
                <input type="checkbox"><span>No</span>
              </div>
            </div>
          </div>
          <div class="flex justify-between items-center border-top p-1-5">
            <div>Breastfeeding: </div>
            <div class="flex gap-1">
              <div class="flex items-center">
                <input type="checkbox"><span>Yes</span>
              </div>
              <div class="flex items-center">
                <input type="checkbox"><span>No</span>
              </div>
            </div>
          </div>
        </div>
        <!-- Left column end -->

        <!-- Middle column start -->
        <div class="flex flex-col gap-1 border-right basis-50">
          <div class="flex flex-col flex-1 p-1-5">
            <div class="flex-1"><?= $chiefComplaints ?></div>

            <div class="flex justify-end">
              <div class="flex flex-col gap-1" style="flex-basis: 45%;">
                <div>Signature of Doctor</div>
                <div style="margin-bottom: 8px;">Name & Regd. No.:</div>
              </div>
            </div>
          </div>
          <!-- Footer start -->
          <div class="text-center border-top p-1-5">
            <?= $receiptFooter ?>
          </div>
          <!-- Footer end -->
        </div>
        <!-- Middle column end -->

        <!-- Right column start -->
        <div class="flex flex-col gap-1" style="flex-basis: 25%;">
          <div class="border-bottom p-1-5"><b>Comorbidities</b></div>
          <div class="flex flex-col gap-1 px-1-5">
            <?= $comorbidities ?>
          </div>
          <div class="border-top p-1-5"><b>Food/Drug Allergy</b>:<br><br><br></div>
          <div class="border-top p-1-5"><b>Investigation</b>:<div><?= $investigation ?></div></div>
          <div class="border-top p-1-5"><b>Advice/Nutrition:</b><br><br></div>
          <div class="px-1-5">Do's:<br><br><br></div>
          <div class="px-1-5">Don'ts:<br><br><br></div>
          <div class="p-1-5 border-top"><b>Follow up</b>:</div>
        </div>
        <!-- Right column end -->
      </div>
      <!-- Bottom row end -->
    </div>
    <!-- Treatment box layout end -->
  </div>
  <!-- Treatment block -->
  <div class="text-end">Entry by: <?= $model->createByUserId->username ?></div>
</div>


<!-- <img class="watermark" src="<?= $baseUrl ?>/images/nhm-logo.png"> -->

<style>
html, body {
  margin: 0;
}
body {
  padding: 1rem 0;
  font-size: 12px;
  font-family: Arial, Helvetica, sans-serif;
}
.nhm-logo {
  height: 50px;
}
.mayek {
  height: 16px;
}
.watermark {
  position: absolute;
  left: 50%;
  top: 50%;
  opacity: 0.02;
  height: 30rem;
  transform: translate(-50%, -50%);

}
.bordered {
  border: 1px solid #181C14;
}
.border-top {
  border-top: 1px solid #181C14;
}
.border-bottom {
  border-bottom: 1px solid #181C14;
}
.border-right {
  border-right: 1px solid #181C14;
}
.border-y {
  border-top: 1px solid #181C14;
  border-bottom: 1px solid #181C14;
}
.text-center {
  text-align: center;
}
.text-end {
  text-align: right;
}
.flex {
  display: flex;
}
.flex-1 {
  flex: 1 0 0;
}
.flex-col {
  flex-direction: column;
}
.justify-between {
  justify-content: space-between;
}
.justify-end {
  justify-content: end;
}
.items-center {
  align-items: center;
}
.basis-50 {
  flex-basis: 50%;
}
.text-xl {
  font-size: 16px;
}
.text-2xl {
  font-size: 18px;
}
.p-1-5 {
  padding: 0.3rem;
}
.p-1 {
  padding: 0.5rem;
}
.pt-1 {
  padding-top: 0.5rem;
}
.pb-1-5 {
  padding-bottom: 0.3rem;
}
.pb-1 {
  padding-bottom: 0.5rem;
}
.px-1-5 {
  padding-left: 0.3rem;
  padding-right: 0.3rem;
}
.px-1 {
  padding-left: 0.5rem;
  padding-right: 0.5rem;
}
.pt-3 {
  padding-top: 1rem;
}
.mt-3 {
  margin-top: 1rem;
}
.rounded-1 {
  border-radius: 0.5rem;
}
.fee-pad {
  padding: 0.5rem 1rem;
  font-weight: bold;
}
.gap-1 {
  gap: 0.5rem;
}
.gap-3 {
  gap: 1rem;
}
.h-full {
  height: 100%;
}
</style>

<script>
setTimeout(function() {
  window.print();
}, 500);
</script>
