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

    <?php if ($opdSessionUpdated) { ?>
        <div class="bg-dark text-white mb-3 p-2">
            OPD Session changed to <?= $activeOpdSession['name'] ?>
        </div>
    <?php } ?>

    <div class="row mb-3">
        <div class="col-md-6">
            <?= Html::a('New OPD Registration', ['create'], ['class' => 'btn btn-success openModal', 'size' => 'xl', 'header' => 'New OPD Registration']) ?>
        </div>
        <div class="col-md-6 text-end flex items-center justify-end">
            Current OPD Session:&nbsp;<b class="text-success"><?= $activeOpdSession['name'] ?></b>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6 flex items-center">
            <b id="filter" class="text-muted">Filter <i id="filter-toggle-icon" class="fas fa-angle-down"></i></b>
        </div>
        <div class="col-md-6 text-end">
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
                    'serial_no',
                    'abha_id',
                    'patient_name',
                    'age',
                    'gender',
                    'fee_amount',
                    [
                        'attribute' => 'opd_date',
                        'value' => function($model) {
                            return date('d/m/Y h:i a', strtotime($model->opd_date));
                        }
                    ],
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
    </div>

    <div id="search-form" class="mb-3">
        <?= $this->render('_search', ['model' => $searchModel, 'departments' => $departments, 'religions' => $religions, 'users' => $users, 'opdSessions' => $opdSessions, 'statuses' => $statuses]); ?>
    </div>

    <?php
    // to print OPD ticket if set in session
    $printTicketId = Yii::$app->session->get('print-ticket');
    if ($printTicketId) {
        echo '<div class="text-end">';
        echo Html::a('Click here to print OPD ticket', ['/opd/print', 'id' => $printTicketId], ['target' => '_blank', 'id' => 'print-ticket-link']);
        echo '</div>';
        echo '<script>document.getElementById("print-ticket-link").click();</script>';
    }
    ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'pager' => ['linkOptions' => ['class' => 'page-link'], 'disabledPageCssClass' => 'page-item', 'pageCssClass' => 'page-item', 'prevPageCssClass' => 'page-item prev', 'nextPageCssClass' => 'page-item next', 'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link disabled']],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'opd_registration_no',
                        'serial_no',
                        'patient_name',
                        [
                            'attribute' => 'opd_date',
                            'value' => function($model) {
                                return date('d/m/Y h:i a', strtotime($model->opd_date));
                            }
                        ],
                        [
                            'attribute' => 'department_id',
                            'value' => function($model) use($departments) {
                                return isset($departments[$model->department_id]) ? $departments[$model->department_id] : $model->department_id;
                            },
                            'filter' => $departments
                        ],
                        /* [
                            'attribute' => 'created_by_user_id',
                            'value' => function($model) use($users) {
                                return isset($users[$model->created_by_user_id]) ? $users[$model->created_by_user_id] : $model->created_by_user_id;
                            },
                            'filter' => $users
                        ], */
                        [
                            'class' => ActionColumn::class,
                            'template' => '{print} {view} {update}',
                            'buttons' => [
                                'view' => function($url, $model) {
                                    return Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'openModal', 'size' => 'xl', 'header' => 'OPD Registration: ' . $model->opd_registration_no]);
                                },
                                'print' => function($url, $model) {
                                    return Html::a('<i class="fas fa-print"></i>', $url, ['target' => '_blank']);
                                },
                                'update' => function($url, $model) {
                                    return Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'openModal', 'size' => 'xl', 'header' => 'Update OPD Registration: ' . $model->opd_registration_no]);
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
    $("#search-form").slideToggle();

    const filterIcon = $("#filter-toggle-icon");
    if (filterIcon.hasClass('fa-angle-right')) filterIcon.removeClass('fa-angle-right').addClass('fa-angle-down');
    else if (filterIcon.hasClass('fa-angle-down')) filterIcon.removeClass('fa-angle-down').addClass('fa-angle-right');
});
JS
);
