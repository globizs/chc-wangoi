<div class="text-center">
  <b><?= $receiptHeading ?></b>
</div>
<br>
<table>
  <tr>
    <td><b>O.P.D. Regn. No.: </b><?= $model->opd_registration_no ?></td>
    <td><b>O.P.D.</b></td>
    <td class="text-end"><b><?= $model->opdSession->name ?></b></td>
  </tr>
</table>
<br>
<table>
  <tr>
    <td colspan="3"><b><?= $model->getAttributelabel('patient_name') ?>: </b><?= $model->patient_name ?></td>
  </tr>
  <tr>
    <td colspan="3"><b><?= $model->getAttributelabel('care_taker_name') ?>: </b><?= $model->care_taker_name ?></td>
  </tr>
  <tr>
    <td style="width: 33%;"><b><?= $model->getAttributelabel('age') ?>: </b><?= $model->age ?></td>
    <td style="width: 33%;"><b><?= $model->getAttributelabel('gender')?>: </b><?= $model->gender ?></td>
    <td><b><?= $model->getAttributelabel('religion')?>: </b><?= $model->religion ? $model->religion->name : null ?></td>
  </tr>
  <tr>
    <td colspan="3"><b><?= $model->getAttributelabel('address')?>: </b><?= $model->address ?></td>
  </tr>
  <tr>
    <td colspan="3"><b><?= $model->getAttributelabel('diagnosis')?>: </b><?= $model->diagnosis ?></td>
  </tr>
</table>
<br>


<style>
table {
  width: 100%;
  border-collapse: collapse;
}
td {
  padding: 3px;
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
</style>
