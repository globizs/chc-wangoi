<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'OPD Sessions';
$this->params['breadcrumbs'][] = $this->title;

$statuses = ['1' => 'Active', '0' => 'Deleted'];

?>
<div class="session-index">

    <p>
        <?= Html::a('Create OPD Session', ['create'], ['class' => 'btn btn-success openModal', 'size' => 'sm', 'header' => 'Create OPD Session']) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-sm table-striped'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'name',
                        [
                            'attribute' => 'fee',
                            'value' => function($model) {
                                return '&#8377;' . $model->fee;
                            },
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'current_session',
                            'value' => function($model) {
                                return $model->current_session == '1' ? '<i class="fas fa-check text-success"></i>' : '';
                            },
                            'format' => 'raw'
                        ],
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
                                    return Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'openModal', 'size' => 'sm', 'header' => 'Update OPD Session']);
                                }
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
