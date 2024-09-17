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

        $closestSession = OpdSession::find()->asArray()->select('id, name, start_time, current_session')->where(['<', 'start_time', date('H:i:s')])->andWhere(['is_active' => '1'])->orderBy('start_time DESC')->one();

        $opdSessionPrompt = $closestSession && $closestSession['current_session'] != '1';

        $activeOpdSession = OpdSession::find()->asArray()->select('name')->where(['current_session' => '1', 'is_active' => '1'])->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'opdSessionPrompt' => $opdSessionPrompt,
            'closestSession' => $closestSession,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
            $model->opd_date = date('Y-m-d', strtotime($model->opd_date));

            $model->created_by_user_id = Yii::$app->user->id;

            $maxOpdRegNo = Opd::find()->max('opd_registration_no');
            $model->opd_registration_no = $maxOpdRegNo + 1;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully saved!');
            } else {
                Yii::$app->session->setFlash('success', 'Failed to save! ' . json_encode($model->errors));
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        $activeOpdSession = OpdSession::find()->asArray()->select('id, fee')->where(['current_session' => '1', 'is_active' => '1'])->one();
        if ($activeOpdSession) {
            $model->opd_session_id = $activeOpdSession['id'];
            $model->fee_amount = $activeOpdSession['fee'];
        }

        $model->opd_date = date('d/m/Y');

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
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
            $model->opd_date = date('Y-m-d', strtotime($model->opd_date));

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully saved!');
            } else {
                Yii::$app->session->setFlash('success', 'Failed to save! ' . json_encode($model->errors));
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        $model->opd_date = date('d/m/Y', strtotime($model->opd_date));

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    // print opd ticket
    public function actionPrint($id) {
        $settings = Setting::find()->asArray()->select('name, value')->where(['name' => ['receipt_heading', 'vital_signs', 'physical_examination', 'systemic_examination', 'chief_complaints', 'comorbidities', 'receipt_footer']])->all();

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
        ]);
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
