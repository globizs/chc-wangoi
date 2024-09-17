<?php

use frontend\models\Department;
use yii\helpers\Url;

$departmentName = Department::find()->asArray()->select('name')->where(['id' => $model->department_id])->one();
$departmentName = $departmentName ? $departmentName['name'] : null;

$baseUrl = Url::base(true);
?>

<div class="flex flex-col gap-3 h-full">
  <div class="flex flex-col">
    <div class="flex">
      <div>
        <img class="nhm-logo" src="<?= $baseUrl ?>/images/nhm-logo.png">
      </div>
      <div class="flex-1 text-center">
        <b class="text-2xl"><?= $receiptHeading ?></b>
      </div>
      <div class="text-end flex flex-col gap-3">
        <div class="flex justify-between">
          <div>&nbsp;</div>
          <div class="bordered rounded-1 fee-pad text-xl">&#8377;<?= $model->fee_amount ?>/-</div>
        </div>
      </div>
    </div>
    <div class="flex">
      <div style="flex-basis: 33%;"></div>
      <div style="flex-basis: 33%;" class="text-center"><b><u><?= $model->opdSession->name ?></u></b></div>
      <div style="flex-basis: 33%;" class="text-end">Date: <?= date('d/m/Y', strtotime($model->opd_date)) ?> Time:</div>
    </div>
  </div>

  <div class="flex flex-col gap-1 border-top pt-1">
    <div class="flex justify-between">
      <div><b>O.P.D. Regn. No.: </b><?= $model->opd_registration_no ?></div>
      <div><b><?= $model->getAttributelabel('abha_id') ?>: </b><?= $model->abha_id ?></div>
    </div>
    <div><b><?= $model->getAttributelabel('patient_name') ?>: </b><?= $model->patient_name ?></div>
    <div><b><?= $model->getAttributelabel('care_taker_name') ?>: </b><?= $model->care_taker_name ?></div>
    <div class="flex">
      <div style="flex-basis: 33%;"><b><?= $model->getAttributelabel('age') ?>: </b><?= $model->age ?></div>
      <div style="flex-basis: 33%;"><b><?= $model->getAttributelabel('gender')?>: </b><?= $model->gender ?></div>
      <div style="flex-basis: 33%;"><b><?= $model->getAttributelabel('religion')?>: </b><?= $model->religion ? $model->religion->name : null ?></div>
    </div>
    <div class="flex justify-between">
      <div><b><?= $model->getAttributelabel('address')?>: </b><?= $model->address ?></div>
      <div><b><?= $model->getattributelabel('department_id')?>: </b><?= $departmentName ?></div>
    </div>
  </div>

  <div class="flex flex-1 bordered">
    <div class="flex flex-col" style="flex-basis: 74%;">
      <div class="border-bottom border-right p-1"><b><?= $model->getAttributelabel('diagnosis')?>: </b><?= $model->diagnosis ?></div>
      <div class="flex flex-1 border-right">
        <div class="flex flex-col border-right" style="flex-basis: 35.14%;">
          <div class="flex flex-col gap-3 flex-1">
            <div class="flex flex-col gap-1 px-1 pt-1"><?= $vitalSigns ?></div>

            <div class="flex flex-col gap-1">
              <div class="border-y p-1"><b>General Physical Examination</b></div>
              <div class="flex flex-col gap-1 p-1"><?= $physicalExamination ?></div>
            </div>

            <div class="flex flex-col gap-1">
              <div class="border-y p-1"><b>Systemic Examination</b></div>
              <div class="flex flex-col gap-1 p-1"><?= $systemicExamination ?></div>
            </div>
          </div>
          <div>
            <div class="border-y p-1">Pregnant: Yes / No</div>
            <div class="p-1">Breastfeeding: Yes / No</div>
          </div>
        </div>
        <div class="flex flex-col flex-1 gap-3">
          <div class="flex flex-col flex-1 p-1">
            <div class="flex-1"><?= $chiefComplaints ?></div>

            <div>
              <div class="text-end">Full Signature of Doctor&emsp;</div>
              <div style="font-size: 8px;">&nbsp;</div>
              <div class="text-end">Regd. No.: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;</div>
            </div>
          </div>
          <div class="text-center">
            <?= $receiptFooter ?>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-col gap-1 flex-1">
      <div class="border-bottom p-1"><b>Comorbidities</b></div>
      <div class="flex flex-col gap-1 px-1">
        <?= $comorbidities ?>
      </div>
      <div class="border-y p-1"><b>Food/Drug Allergy</b>:<br><br><br></div>
      <div class="border-bottom p-1"><b>Investigation</b>:<br><br><br></div>
      <div class="border-bottom p-1"><b>Advice/Nutrition</b><br><br><br></div>
      <div>Do's:<br><br><br></div>
      <div>Don'ts:<br><br><br></div>
      <div><b>Follow up</b>:<br><br><br></div>
    </div>
  </div>
</div>

<style>
html, body {
  margin: 0;
}
body {
  padding: 1rem 0;
  font-size: 12px;
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
.nhm-logo {
  height: 50px;
}
.text-xl {
  font-size: 16px;
}
.text-2xl {
  font-size: 18px;
}
.p-1 {
  padding: 0.5rem;
}
.pt-1 {
  padding-top: 0.5rem;
}
.pb-1 {
  padding-bottom: 0.5rem;
}
.px-1 {
  padding-left: 0.5rem;
  padding-right: 0.5rem;
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
