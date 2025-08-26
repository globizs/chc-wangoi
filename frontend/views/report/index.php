<?php

use yii\helpers\Html;
use kartik\date\DatePicker;

$this->title = 'Case Statistics Report';

$genders = ['Male' => 'Male', 'Female' => 'Female', 'Transgender' => 'Transgender'];
$age_ranges = ['1' => '0 - 1 year', '2' => '1 - 5 years', '3' => '5 - 15 years', '4' => '15 - 50 years', '5' => '50 - 65 years', '6' => '65 years and above'];

$session_gender_set = ['Male' => 0, 'Female' => 0, 'Transgender' => 0];
$department_gender_set = ['Male' => 0, 'Female' => 0, 'Transgender' => 0];
?>

<?= Html::beginForm(['/report/index'], 'GET') ?>

<div class="row mb-3">
    <div class="col-md-3 mb-3">
        <div><label for="department_id"><b>Department</b></label></div>
        <?= Html::dropDownList('department_id', $department_id, $departments, ['class' => 'form-select', 'prompt' => 'All Departments', 'id' => 'department_id']) ?>
    </div>
    <div class="col-md-3 mb-3">
        <div><label for="opd_session_id"><b>OPD Session</b></label></div>
        <?= Html::dropDownList('opd_session_id', $opd_session_id, $opd_sessions, ['class' => 'form-select', 'prompt' => 'All Sessions', 'id' => 'opd_session_id']) ?>
    </div>
    <div class="col-md-3 mb-3">
        <div><label for="gender"><b>Gender</b></label></div>
        <?= Html::dropDownList('gender', $gender, $genders, ['class' => 'form-select', 'prompt' => 'All Genders', 'id' => 'gender']) ?>
    </div>
    <div class="col-md-3 mb-3">
        <div><label for="religion_id"><b>Religion</b></label></div>
        <?= Html::dropDownList('religion_id', $religion_id, $religions, ['class' => 'form-select', 'prompt' => 'All Religions', 'id' => 'religion_id']) ?>
    </div>
    <div class="col-md-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label id="age-range-label" class="age-flipper <?= $age_start || $age_end ? 'text-muted' : '' ?>"" data-target="age-range" data-target-hide="year-month" for="age_range_id"><b title="Filter by age range">Age Range</b></label>
            <svg height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M32 96l320 0 0-64c0-12.9 7.8-24.6 19.8-29.6s25.7-2.2 34.9 6.9l96 96c6 6 9.4 14.1 9.4 22.6s-3.4 16.6-9.4 22.6l-96 96c-9.2 9.2-22.9 11.9-34.9 6.9s-19.8-16.6-19.8-29.6l0-64L32 160c-17.7 0-32-14.3-32-32s14.3-32 32-32zM480 352c17.7 0 32 14.3 32 32s-14.3 32-32 32l-320 0 0 64c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-96-96c-6-6-9.4-14.1-9.4-22.6s3.4-16.6 9.4-22.6l96-96c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 64 320 0z"/></svg>
            <label id="year-month-label" class="age-flipper <?= $age_start || $age_end ? '' : 'text-muted' ?>" data-target="year-month" data-target-hide="age-range" for="age_start"><b title="Filter by min. age & max. age (inclusive)">Year/Month</b></label>
        </div>
        <div id="age-range">
            <?= Html::dropDownList('age_range_id', $age_range_id, $age_ranges, ['class' => 'form-select', 'prompt' => 'All ages', 'id' => 'age_range_id']) ?>
        </div>
        <div id="year-month">
            <div class="d-flex">
                <?= Html::textInput('age_start', $age_start, ['class' => 'form-control', 'prompt' => 'Min. age', 'type' => 'number', 'min' => 0, 'max' => 150, 'placeholder' => 'Min. age', 'id' => 'age_start', 'style' => 'border-top-right-radius: 0; border-bottom-right-radius: 0;']) ?>

                <?= Html::textInput('age_end', $age_end, ['class' => 'form-control', 'prompt' => 'Max. age', 'type' => 'number', 'min' => 0, 'max' => 150, 'placeholder' => 'Max. age', 'id' => 'age_end', 'style' => 'border-top-left-radius: 0; border-bottom-left-radius: 0;']) ?>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div><label for="start_date"><b>From date</b></label></div>
        <?= DatePicker::widget([
            'name' => 'start_date', 
            'value' => $start_date,
            'options' => ['placeholder' => 'From date', 'id' => 'start_date'],
            'pluginOptions' => [
                'format' => 'dd-M-yyyy',
                'todayHighlight' => true,
                'autoclose' => true,
            ]
        ]) ?>
    </div>
    <div class="col-md-3 mb-3">
        <div><label for="end_date"><b>To date</b></label></div>
        <?= DatePicker::widget([
            'name' => 'end_date', 
            'value' => $end_date,
            'options' => ['placeholder' => 'To date', 'id' => 'end_date'],
            'pluginOptions' => [
                'format' => 'dd-M-yyyy',
                'todayHighlight' => true,
                'autoclose' => true,
            ]
        ]) ?>
    </div>
    <div class="col-md-3 mb-3">
        <div><label>&nbsp;</label></div>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?= Html::endForm() ?>

<hr>

<?php if ($report['totalCases']) { ?>
    
<div class="text-end"><button id="downloadImage" class="btn btn-outline-dark">Download as Image</button></div>
    
<div id="myDiv">
    <h4 class="mb-3"><b>Total no. of cases:</b> <?= $report['totalCases'] ?></h4>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <table id="gender-wise" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th><th>Gender</th><th>No. of cases</th><th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($report['totalCasesByGender'] as $sl => $reportItem) { ?>
                                <tr>
                                    <td><?= $sl + 1 ?></td>
                                    <th><?= $reportItem['gender'] ?></th>
                                    <td><?= $reportItem['total'] ?></td>
                                    <td><?= round(($reportItem['total'] / $report['totalCases']) * 100, 2) ?>%</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <table id="opd-session-wise" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th><th>OPD Session</th><th>No. of cases</th>
                                <?php foreach ($genders as $gender) { ?>
                                    <th><?= $gender ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($report['totalCasesByOpdSession'] as $sl => $reportItem) { ?>
                                <tr>
                                    <td><?= $sl + 1 ?></td>
                                    <th><?= $opd_sessions[$reportItem['opd_session_id']] ?></th>
                                    <td><?= $reportItem['total'] ?></td>
                                    <?php foreach ($genders as $gender) { ?>
                                        <td>
                                            <?php
                                            foreach ($report['totalCasesByOpdSessionGender'] as $reportGenderItem) {
                                                if ($reportGenderItem['opd_session_id'] != $reportItem['opd_session_id'] || $reportGenderItem['gender'] != $gender) continue;

                                                echo $reportGenderItem['total'];

                                                $session_gender_set[$reportItem['opd_session_id']][$gender] = 1;
                                            }

                                            if (!isset($session_gender_set[$reportItem['opd_session_id']][$gender]) || (isset($session_gender_set[$reportItem['opd_session_id']][$gender]) && !$session_gender_set[$reportItem['opd_session_id']][$gender])) echo 0;
                                            ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <table id="department-wise" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th><th>Department</th><th>No. of cases</th>
                        <?php foreach ($genders as $gender) { ?>
                            <th><?= $gender ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($report['totalCasesByDepartment'] as $sl => $reportItem) { ?>
                        <tr>
                            <td><?= $sl + 1 ?></td>
                            <th><?= $departments[$reportItem['department_id']] ?></th>
                            <td><?= $reportItem['total'] ?></td>
                            <?php foreach ($genders as $gender) { ?>
                                <td>
                                    <?php
                                    foreach ($report['totalCasesByDepartmentGender'] as $reportGenderItem) {
                                        if ($reportGenderItem['department_id'] != $reportItem['department_id'] || $reportGenderItem['gender'] != $gender) continue;

                                        echo $reportGenderItem['total'];

                                        $session_gender_set[$reportItem['department_id']][$gender] = 1;
                                    }

                                    if (!isset($session_gender_set[$reportItem['department_id']][$gender]) || (isset($session_gender_set[$reportItem['department_id']][$gender]) && !$session_gender_set[$reportItem['department_id']][$gender])) echo 0;
                                    ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php } else { ?>
    <h4 class="py-3"><b>No patient records found.</b></h4>
<?php } ?>

<style>
<?php if ($age_start || $age_end) { ?>
    #age-range {
        display: none;
    }
<?php } else { ?>
    #year-month {
        display: none;
    }
<?php } ?>
.age-flipper {
    cursor: pointer;
}
.input-group.date input.form-control {
    height: unset;
}
.datatable-gender, .datatable-opd-session, .datatable-department {
    display: flex;
    margin-bottom: 1rem;
    justify-content: space-between;
}
.buttons-html5 {
    background-color: #fff;
}
</style>

<script>
document.getElementById('downloadImage').addEventListener('click', function () {
    const element = document.getElementById('myDiv');

    html2canvas(element, {
        ignoreElements: (node) => node.tagName === 'BUTTON', // Ignore all <button> elements
    }).then(canvas => {
        const dataUrl = canvas.toDataURL('image/png');

        // Create a temporary anchor element to trigger the download
        const link = document.createElement('a');
        link.href = dataUrl;
        link.download = 'chc-wangoi-report.png';

        // Trigger the download by programmatically clicking the anchor
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
});
</script>

<?php
$this->registerJs(<<<JS
$("#gender-wise").DataTable({
    dom: '<"datatable-gender"lB>frtip', // Add a custom class to the header section with buttons
    // dom: 'Bfrtip', // Include Buttons in the table controls
    buttons: [{
        extend: 'excel',
        title: 'Gender Wise Report',
        className: 'btn-outline-success',
    }, {
        extend: 'pdf',
        title: 'Gender Wise Report',
        className: 'btn-outline-danger',
    }],
    searching: false,
    paging: false,
    language: {
        "info": ""
    },
    initComplete: function () {
        $(".datatable-gender").prepend('<h4 style="display: inline-block; margin-right: 20px;">Gender Wise Report</h4>');
    }
});

$("#opd-session-wise").DataTable({
    dom: '<"datatable-opd-session"lB>frtip', // Add a custom class to the header section with buttons
    // dom: 'Bfrtip', // Include Buttons in the table controls
    buttons: [{
        extend: 'excel',
        title: 'OPD Session Wise Report',
        className: 'btn-outline-success',
    }, {
        extend: 'pdf',
        title: 'OPD Session Wise Report',
        className: 'btn-outline-danger',
    }],
    searching: false,
    paging: false,
    language: {
        "info": ""
    },
    initComplete: function () {
        $(".datatable-opd-session").prepend('<h4 style="display: inline-block; margin-right: 20px;">OPD Session Wise Report</h4>');
    }
});

$("#department-wise").DataTable({
    dom: '<"datatable-department"lB>frtip', // Add a custom class to the header section with buttons
    // dom: 'Bfrtip', // Include Buttons in the table controls
    buttons: [{
        extend: 'excel',
        title: 'Department Wise Report',
        className: 'btn-outline-success',
    }, {
        extend: 'pdf',
        title: 'Department Wise Report',
        className: 'btn-outline-danger',
    }],
    searching: false,
    paging: false,
    language: {
        "info": ""
    },
    initComplete: function () {
        $(".datatable-department").prepend('<h4 style="display: inline-block; margin-right: 20px;">Department Wise Report</h4>');
    }
});

$(".age-flipper").click(function() {
    const hideId = $(this).attr("data-target-hide");
    const targetId = $(this).attr("data-target");

    if (hideId == 'year-month') {
        $("#age-range-label").removeClass("text-muted");
        $("#year-month-label").addClass("text-muted");
        $("#age_start").val('');
        $("#age_end").val('');
    } else {
        $("#age-range-label").addClass("text-muted");
        $("#year-month-label").removeClass("text-muted");
        $("#age_range_id").val('');
    }

    $("#" + hideId).hide();
    $("#" + targetId).show();
});
JS
);
