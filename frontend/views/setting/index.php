<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'OPD Ticket Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'pager' => ['linkOptions' => ['class' => 'page-link'], 'disabledPageCssClass' => 'page-item', 'pageCssClass' => 'page-item', 'prevPageCssClass' => 'page-item prev', 'nextPageCssClass' => 'page-item next', 'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link disabled']],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'friendly_name',
                        /* [
                            'attribute' => 'value',
                            'value' => function($model) {
                                return $model->input_type != 'richtext' ? $model->value : null;
                            },
                        ], */
                        [
                            'class' => ActionColumn::class,
                            'template' => '{update}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
