<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Opd;
use frontend\models\OpdSearch;
use frontend\models\OpdSession;
use frontend\models\Setting;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

date_default_timezone_set('Asia/Kolkata');

/**
 * OpdController implements the CRUD actions for Opd model.
 */
class OpdController extends Controller
{
    /**
     * Lists all Opd models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OpdSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $opdSessionUpdated = false;
        
        $activeOpdSession = OpdSession::find()->asArray()->select('id, name')->where(['current_session' => '1', 'is_active' => '1'])->one();

        $setting = Setting::find()->asArray()->select('value')->where(['name' => 'opd_session_auto_set'])->one();

        if ($setting['value'] == 'Yes') {
            $closestSession = OpdSession::find()->where(['<', 'start_time', date('H:i:s')])->andWhere(['is_active' => '1'])->orderBy('start_time DESC')->one();

            if ($closestSession && $closestSession->current_session != '1') {
                OpdSession::updateAll(['current_session' => '0']);

                $closestSession->current_session = '1';
                $closestSession->save(false);

                $opdSessionUpdated = true;

                $activeOpdSession = $closestSession->toArray();
            }
        } else {
            // set OPD Session to last used session
            $latestSession = Opd::find()->asArray()->select('opd_session_id')->where(['NOT', ['opd_session_id' => 3]])->orderBy('id DESC')->limit(1)->one();

            if ($latestSession && $latestSession['opd_session_id'] != $activeOpdSession['id']) {
                OpdSession::updateAll(['current_session' => '0']);

                OpdSession::updateAll(['current_session' => '1'], ['id' => $latestSession['opd_session_id']]);

                $opdSessionUpdated = true;

                $activeOpdSession = OpdSession::find()->asArray()->select('id, name')->where(['current_session' => '1', 'is_active' => '1'])->one();
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'opdSessionUpdated' => $opdSessionUpdated,
            'activeOpdSession' => $activeOpdSession,
        ]);
    }

    /**
     * Displays a single Opd model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $model->age_formatted = $model->convertDaysToAge($model->age);

        return $this->renderAjax('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Opd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Opd();

        if ($model->load($this->request->post())) {
            $model->opd_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $model->opd_date)));

            $model->created_by_user_id = Yii::$app->user->id;
            
            $model->date_of_birth = date('Y-m-d', strtotime($model->date_of_birth));
            $model->age = $model->calculateDaysBetweenDates($model->date_of_birth, date('Y-m-d', strtotime($model->opd_date)));    // no. of days
            
            $transaction = Yii::$app->db->beginTransaction();
            
            try {
                $model->generateRegNo();

                $model->generateSerial();
    
                if ($model->save()) {
                    $transaction->commit();

                    Yii::$app->session->setFlash('success', 'Successfully saved!');
                    Yii::$app->session->setFlash('print-ticket', $model->id);
                } else {
                    $transaction->rollBack();

                    Yii::$app->session->setFlash('danger', 'Failed to save! ' . json_encode($model->errors));
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger', 'An exception has occurred!');
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        $activeOpdSession = OpdSession::find()->asArray()->select('id, fee')->where(['current_session' => '1', 'is_active' => '1'])->one();
        if ($activeOpdSession) {
            $model->opd_session_id = $activeOpdSession['id'];
            $model->fee_amount = $activeOpdSession['fee'];
        }

        $model->opd_date = date('d/m/Y h:i a');

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    // get patient details from ABHA ID
    public function actionGetPatientByAbha($abha_id) {
        $patient = Opd::find()->asArray()->select('patient_name, care_taker_name, date_of_birth, contact_no, gender, religion_id, address, aadhaar_no')->where(['abha_id' => $abha_id, 'is_active' => '1'])->orderBy('id DESC')->limit(1)->one();

        $patient['date_of_birth'] = date('d-M-Y', strtotime($patient['date_of_birth']));

        return json_encode($patient);
    }

    // get patient details from AADHAAR No.
    public function actionGetPatientByAadhaar($aadhaar_no) {
        $patient = Opd::find()->asArray()->select('patient_name, care_taker_name, date_of_birth, contact_no, gender, religion_id, address, abha_id')->where(['aadhaar_no' => $aadhaar_no, 'is_active' => '1'])->orderBy('id DESC')->limit(1)->one();

        $patient['date_of_birth'] = date('d-M-Y', strtotime($patient['date_of_birth']));

        return json_encode($patient);
    }

    /**
     * Updates an existing Opd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($this->request->post())) {
            $model->opd_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $model->opd_date)));

            $model->date_of_birth = date('Y-m-d', strtotime($model->date_of_birth));
            $model->age = $model->calculateDaysBetweenDates($model->date_of_birth, date('Y-m-d', strtotime($model->opd_date)));    // no. of days

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully saved!');
            } else {
                Yii::$app->session->setFlash('danger', 'Failed to save! ' . json_encode($model->errors));
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        $model->opd_date = date('d/m/Y h:i a', strtotime($model->opd_date));
        $model->date_of_birth = date('d-M-Y', strtotime($model->date_of_birth));

        $model->age_formatted = $model->convertDaysToAge($model->age);

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    // print opd ticket
    public function actionPrint($id) {
        $settings = Setting::find()->asArray()->select('name, value')->where(['name' => ['receipt_heading', 'vital_signs', 'physical_examination', 'systemic_examination', 'chief_complaints', 'comorbidities', 'receipt_footer', 'investigation']])->all();

        foreach ($settings as $setting) {
            switch ($setting['name']) {
                case 'receipt_heading':
                    $receiptHeading = $setting['value'];
                    break;
                case 'vital_signs':
                    $vitalSigns = $setting['value'];
                    break;
                case 'physical_examination':
                    $physicalExamination = $setting['value'];
                    break;
                case 'systemic_examination':
                    $systemicExamination = $setting['value'];
                    break;
                case 'chief_complaints':
                    $chiefComplaints = $setting['value'];
                    break;
                case 'comorbidities':
                    $comorbidities = $setting['value'];
                    break;
                case 'investigation':
                    $investigation = $setting['value'];
                    break;
                case 'receipt_footer':
                    $receiptFooter = $setting['value'];
                    break;
            }
        }

        return $this->renderAjax('_ticket', [
            'model' => $this->findModel($id),
            'receiptHeading' => $receiptHeading,
            'vitalSigns' => $vitalSigns,
            'physicalExamination' => $physicalExamination,
            'systemicExamination' => $systemicExamination,
            'chiefComplaints' => $chiefComplaints,
            'comorbidities' => $comorbidities,
            'receiptFooter' => $receiptFooter,
            'investigation' => $investigation,
        ]);
    }

    // to format age from dob (ajax)
    public function actionFormatAge($date_of_birth, $date) {
        $date_of_birth = date('Y-m-d', strtotime(str_replace('/', '-', $date_of_birth)));
        $date = $date ? date('Y-m-d', strtotime(str_replace('/', '-', $date))) : date('Y-m-d');

        $opd = new Opd();
        $opd->age = $opd->calculateDaysBetweenDates($date_of_birth, $date);

        return json_encode(['age_formatted' => $opd->convertDaysToAge($opd->age)]);
    }

    /**
     * Finds the Opd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Opd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Opd::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
