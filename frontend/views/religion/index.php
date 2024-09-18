<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Religions';
$this->params['breadcrumbs'][] = $this->title;

$statuses = ['1' => 'Active', '0' => 'Deleted'];

?>
<div class="religion-index">

    <p>
        <?= Html::a('Create Religion', ['create'], ['class' => 'btn btn-success openModal', 'size' => 'sm', 'header' => 'Create Religion']) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'pager' => ['linkOptions' => ['class' => 'page-link'], 'disabledPageCssClass' => 'page-item', 'pageCssClass' => 'page-item', 'prevPageCssClass' => 'page-item prev', 'nextPageCssClass' => 'page-item next', 'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link disabled']],
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
                                    return Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'openModal', 'size' => 'sm', 'header' => 'Update Religion']);
                                }
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>


</div>
