<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use common\models\User;
use frontend\models\Department;
use frontend\models\OpdSession;
use frontend\models\Religion;

$this->title = 'OPD Registration';
$this->params['breadcrumbs'][] = $this->title;

$users = ArrayHelper::map(User::find()->asArray()->select('id, username')->orderBy('username')->all(), 'id', 'username');
$departments = ArrayHelper::map(Department::find()->asArray()->select('id, name')->orderBy('name')->all(), 'id', 'name');
$religions = ArrayHelper::map(Religion::find()->asArray()->select('id, name')->orderBy('name')->all(), 'id', 'name');
$opdSessions = ArrayHelper::map(OpdSession::find()->asArray()->select('id, name')->orderBy('name')->all(), 'id', 'name');
$statuses = ['1' => 'Active', '0' => 'Deleted'];
?>
<div class="opd-index">

    <p>
        <?= Html::a('New OPD Registration', ['create'], ['class' => 'btn btn-success openModal', 'size' => 'xl', 'header' => 'New OPD Registration']) ?>
    </p>

    <div class="mb-1">
        <b id="filter" class="text-muted">Filter <i id="filter-toggle-icon" class="fas fa-angle-down"></i></b>
    </div>

    <div id="search-form" class="mb-3">
        <?= $this->render('_search', ['model' => $searchModel, 'departments' => $departments, 'religions' => $religions, 'users' => $users, 'opdSessions' => $opdSessions, 'statuses' => $statuses]); ?>
    </div>

    <div class="text-end mb-3">
    <?= ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'dropdownOptions' => [
            'label' => 'Export',
            'class' => 'btn btn-sm'
        ],
        'columnSelectorOptions' => [
            'label' => 'Columns',
            'class' => 'btn btn-sm',
        ],
        'columnSelectorMenuOptions' => [
            'class' => 'p-2',
        ],
        'filename' => 'OPD Registrations - ' . date('d-m-Y'),
        'exportConfig' => [
            ExportMenu::FORMAT_PDF => false,
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_HTML => false,
            ExportMenu::FORMAT_CSV => false,
        ],
        'columns' => [
            'opd_registration_no',
            'abha_id',
            'patient_name',
            'age',
            'gender',
            'fee_amount',
            'opd_date',
            [
                'attribute' => 'department_id',
                'value' => function($model) use($departments) {
                    return isset($departments[$model->department_id]) ? $departments[$model->department_id] : $model->department_id;
                },
            ],
            [
                'attribute' => 'created_by_user_id',
                'value' => function($model) use($users) {
                    return isset($users[$model->created_by_user_id]) ? $users[$model->created_by_user_id] : $model->created_by_user_id;
                },
            ],
        ],
    ]); ?>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-sm table-striped'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'opd_registration_no',
                        'abha_id',
                        'patient_name',
                        'age',
                        'gender',
                        'fee_amount',
                        'opd_date',
                        [
                            'attribute' => 'department_id',
                            'value' => function($model) use($departments) {
                                return isset($departments[$model->department_id]) ? $departments[$model->department_id] : $model->department_id;
                            },
                            'filter' => $departments
                        ],
                        [
                            'attribute' => 'created_by_user_id',
                            'value' => function($model) use($users) {
                                return isset($users[$model->created_by_user_id]) ? $users[$model->created_by_user_id] : $model->created_by_user_id;
                            },
                            'filter' => $users
                        ],
                        [
                            'class' => ActionColumn::class,
                            'template' => '{view} {update}',
                            'buttons' => [
                                'update' => function($url, $model) {
                                    return Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'openModal', 'size' => 'xl', 'header' => 'Update OPD Registration']);
                                }
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>

<style>
#filter {
    cursor: pointer;
}
<?php if (!isset($_GET['OpdSearch'])) { ?>
#search-form {
    display: none;
}
<?php } ?>
#search-form {
    padding: 1rem 1rem 0rem 1rem;
    border: 1px solid #ddd;
    background-color: #fff;
}
</style>

<?php
$this->registerJs(<<<JS
$("#filter").click(function() {
    $("#search-form").slideToggle(function() {
        $("#opdsearch-opd_registration_no").focus();
    });

    const filterIcon = $("#filter-toggle-icon");
    if (filterIcon.hasClass('fa-angle-right')) filterIcon.removeClass('fa-angle-right').addClass('fa-angle-down');
    else if (filterIcon.hasClass('fa-angle-down')) filterIcon.removeClass('fa-angle-down').addClass('fa-angle-right');
});
JS
);
