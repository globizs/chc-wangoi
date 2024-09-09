<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Opd $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Opds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="opd-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'receipt_no',
            'abha_id',
            'patient_name',
            'care_taker_name',
            'age',
            'gender',
            'religion_id',
            'address:ntext',
            'diagnosis:ntext',
            'fee_amount',
            'opd_date',
            'opd_session_id',
            'department_id',
            'created_by_user_id',
            'created_at',
            'updated_at',
            'is_active',
        ],
    ]) ?>

</div>
