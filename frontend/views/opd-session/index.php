<?php

use frontend\models\Setting;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'OPD Sessions';
$this->params['breadcrumbs'][] = $this->title;

$statuses = ['1' => 'Active', '0' => 'Deleted'];

$setting = Setting::findOne(['name' => 'opd_session_auto_set']);

$updateAutoUrl = Url::to(['/opd-session/session-auto', 'mode' => '']);

?>
<div class="session-index">

    <p>
        <?= Html::a('Create OPD Session', ['create'], ['class' => 'btn btn-success openModal', 'size' => 'sm', 'header' => 'Create OPD Session']) ?>
    </p>

    <div class="form-check form-switch mb-3" style="margin-left: 1.3rem;">
        <input class="form-check-input" type="checkbox" id="opd-session-auto-switch" <?= $setting->value == 'Yes' ? 'checked' : null ?>>
        <label class="form-check-label" for="mySwitch">Automatically change OPD session according to start timing.</label>
    </div>

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
                            'attribute' => 'start_time',
                            'value' => function($model) {
                                return $model->start_time ? date('h:i a', strtotime($model->start_time)) : null;
                            }
                        ],
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

<?php
$this->registerJs(<<<JS
$("#opd-session-auto-switch").change(function() {
    let radio = $(this);

    const mode = $(this).is(':checked') ? 'Yes' : 'No';

    $.ajax({
        url: "$updateAutoUrl" + mode,
        method: 'POST',
        success: function(response) {
            console.log(response)
            if (response == 0) {
                toast('Failed to update!');
                radio.prop("checked", false);
            } else {
                toast("Successfully updated!", "bg-success");
            }
        },
        error: function(xhr, status, error) {
            toast('Failed to update! ' + error);
            radio.prop("checked", false);
        }
    });
});
JS
);
