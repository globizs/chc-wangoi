<?php

use yii\widgets\DetailView;

$this->title = 'OPD Registration no. ' . $model->opd_registration_no;
$this->params['breadcrumbs'][] = ['label' => 'OPD Registration', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="opd-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'abha_id',
            'patient_name',
            'care_taker_name',
            'age',
            'gender',
            [
                'attribute' => 'religion_id',
                'value' => function($model) {
                    $religion = $model->religion;
                    return $religion ? $religion->name : null;
                },
            ],
            'address:ntext',
            'diagnosis:ntext',
            [
                'attribute' => 'fee_amount',
                'value' => function($model) {
                    return '&#8377;' . $model->fee_amount;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'opd_date',
                'value' => function($model) {
                    return date('d/m/Y', strtotime($model->opd_date));
                }
            ],
            [
                'attribute' => 'opd_session_id',
                'value' => function($model) {
                    $opdSession = $model->opdSession;
                    return $opdSession ? $opdSession->name : null;
                },
            ],
            [
                'attribute' => 'department_id',
                'value' => function($model) {
                    $department = $model->department;
                    return $department ? $department->name : null;
                },
            ],
            [
                'attribute' => 'created_by_user_id',
                'value' => function($model) {
                    $user = $model->createByUserId;
                    return $user ? $user->username : null;
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model) {
                    return date('d/m/Y h:i a', strtotime($model->created_at));
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model) {
                    return $model->updated_at ? date('d/m/Y h:i a', strtotime($model->updated_at)) : null;
                }
            ],
            [
                'attribute' => 'is_active',
                'value' => function($model) {
                    return $model->is_active == '1' ? 'Active' : '<b class="text-danger">Deleted</b>';
                },
                'format' => 'raw'
            ],
        ],
    ]) ?>

</div>
