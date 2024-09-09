<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Departments';
$this->params['breadcrumbs'][] = $this->title;

$statuses = ['1' => 'Active', '0' => 'Deleted'];
?>
<div class="department-index">

        <?= Html::a('Create Department', ['create'], ['class' => 'btn btn-success openModal', 'size' => 'sm', 'header' => 'Create Department']) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-sm table-striped'],
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'name',
                        [
                            'attribute' => 'is_active',
                            'value' => function($model) use($statuses) {
                                return $statuses[$model->is_active];
                            },
                            'filterInputOptions' => ['class' => 'form-select'],
                            'filter' => $statuses
                        ],
                        [
                            'class' => ActionColumn::class,
                            'template' => '{update}',
                            'buttons' => [
                                'update' => function($url, $model) {
                                    return Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'openModal', 'size' => 'sm', 'header' => 'Update Department']);
                                }
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
