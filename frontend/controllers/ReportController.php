<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Opd;
use frontend\models\OpdSession;
use frontend\models\Department;
use frontend\models\Religion;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

date_default_timezone_set('Asia/Kolkata');

class ReportController extends Controller
{
    public function actionIndex($gender = null, $opd_session_id = null, $department_id = null, $religion_id = null, $age_range_id = null, $age_start = null, $age_end = null, $start_date = null, $end_date = null) {
        // Get the current year and month
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Adjust fiscal year start and end based on the current month
        if ($currentMonth >= 4) {
            // If the current month is April or later, fiscal year starts in current year
            $fiscalYearStart = date('Y-m-d', strtotime("$currentYear-04-01"));
            $fiscalYearEnd = date('Y-m-d', strtotime(($currentYear + 1) . '-03-31'));
        } else {
            // If the current month is before April, fiscal year starts in the previous year
            $fiscalYearStart = date('Y-m-d', strtotime(($currentYear - 1) . '-04-01'));
            $fiscalYearEnd = date('Y-m-d', strtotime("$currentYear-03-31"));
        }

        // Set the start and end dates based on fiscal year if not provided
        $start_date = $start_date ? date('Y-m-d', strtotime($start_date)) : $fiscalYearStart;
        $end_date = $end_date ? date('Y-m-d', strtotime($end_date)) : $fiscalYearEnd;

        // age filter formatter
        $opdObj = new Opd();
        $age_min = $age_max = null;     // age is stored in months
        if ($age_range_id) {
            switch ($age_range_id) {
                // 0 to <1
                case 1: $age_min = 1;
                        $age_max = $opdObj->calculateDaysFromAge(0, 11, 364);
                        break;
                // 1 to <5
                case 2: $age_min = $opdObj->calculateDaysFromAge(1);
                        $age_max = $opdObj->calculateDaysFromAge(4, 11, 364);
                        break;
                // 5 to <15
                case 3: $age_min = $opdObj->calculateDaysFromAge(5);
                        $age_max = $opdObj->calculateDaysFromAge(14, 11, 364);
                        break;
                // 15 to <50
                case 4: $age_min = $opdObj->calculateDaysFromAge(15);
                        $age_max = $opdObj->calculateDaysFromAge(49, 11, 364);
                        break;
                // 50 to <65
                case 5: $age_min = $opdObj->calculateDaysFromAge(50);
                        $age_max = $opdObj->calculateDaysFromAge(64, 11, 364);
                        break;
                // >=65
                case 6: $age_min = $opdObj->calculateDaysFromAge(65);
                        $age_max = $opdObj->calculateDaysFromAge(150);
                        break;
            }
        } else if ($age_start || $age_end) {
            $age_min = $age_start ? $opdObj->calculateDaysFromAge($age_start) : null;
            $age_max = $age_end ? $opdObj->calculateDaysFromAge($age_end, 11, 364) : null;
        }

        $reportQuery = Opd::find()
            ->filterWhere([
                'gender' => $gender, 
                'opd_session_id' => $opd_session_id, 
                'department_id' => $department_id, 
                'religion_id' => $religion_id
            ])
            ->andFilterWhere(['>=', 'DATE(opd_date)', $start_date])
            ->andFilterWhere(['<=', 'DATE(opd_date)', $end_date])
            ->andFilterWhere(['>=', 'age', $age_min])
            ->andFilterWhere(['<=', 'age', $age_max]);

        // Get total cases
        $totalCases = $reportQuery->count();

        // Get total cases by gender
        $totalCasesByGender = $reportQuery
            ->select(['gender', 'COUNT(*) as total'])
            ->groupBy('gender')
            ->asArray()
            ->all();

        // Get total cases by opd_session
        $totalCasesByOpdSession = $reportQuery
            ->select(['opd_session_id', 'COUNT(*) as total'])
            ->groupBy('opd_session_id')
            ->asArray()
            ->all();

        // Get total cases by opd_session categorized by gender
        $totalCasesByOpdSessionGender = $reportQuery
        ->select(['opd_session_id', 'gender', 'COUNT(*) as total'])
        ->groupBy(['opd_session_id', 'gender'])
        ->asArray()
        ->all();

        // Get total cases by department
        $totalCasesByDepartment = $reportQuery
            ->select(['department_id', 'COUNT(*) as total'])
            ->groupBy('department_id')
            ->asArray()
            ->all();

        // Get total cases by department categorized by gender
        $totalCasesByDepartmentGender = $reportQuery
        ->select(['department_id', 'gender', 'COUNT(*) as total'])
        ->groupBy(['department_id', 'gender'])
        ->asArray()
        ->all();

        // Get total cases by religion
        // $totalCasesByReligion = $reportQuery
        //     ->select(['religion_id', 'COUNT(*) as total'])
        //     ->groupBy('religion_id')
        //     ->asArray()
        //     ->all();

        // Prepare report data for passing to the view
        $report = [
            'totalCases' => $totalCases,
            'totalCasesByGender' => $totalCasesByGender,
            'totalCasesByOpdSession' => $totalCasesByOpdSession,
            'totalCasesByDepartment' => $totalCasesByDepartment,
            // 'totalCasesByReligion' => $totalCasesByReligion,
            'totalCasesByOpdSessionGender' => $totalCasesByOpdSessionGender,
            'totalCasesByDepartmentGender' => $totalCasesByDepartmentGender,
        ];

        $opd_sessions = ArrayHelper::map(OpdSession::find()->asArray()->select('id, name')->where(['is_active' => '1'])->all(), 'id', 'name');
        $departments = ArrayHelper::map(Department::find()->asArray()->select('id, name')->where(['is_active' => '1'])->orderBy('name')->all(), 'id', 'name');
        $religions = ArrayHelper::map(Religion::find()->asArray()->select('id, name')->where(['is_active' => '1'])->orderBy('name')->all(), 'id', 'name');

        $start_date = date('d-M-Y', strtotime($start_date));
        $end_date = date('d-M-Y', strtotime($end_date));

        return $this->render('index', [
            'report' => $report,
            'gender' => $gender,
            'opd_session_id' => $opd_session_id,
            'department_id' => $department_id,
            'religion_id' => $religion_id,
            'age_range_id' => $age_range_id,
            'age_start' => $age_start,
            'age_end' => $age_end,
            'opd_sessions' => $opd_sessions,
            'departments' => $departments,
            'religions' => $religions,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
}
