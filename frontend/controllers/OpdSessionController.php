<?php

namespace frontend\controllers;

use Yii;
use frontend\models\OpdSession;
use frontend\models\OpdSessionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OpdSessionController implements the CRUD actions for OpdSession model.
 */
class OpdSessionController extends Controller
{
    /**
     * Lists all OpdSession models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OpdSessionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new OpdSession model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new OpdSession();

        if ($model->load($this->request->post())) {
            if ($model->current_session == '1') {
                // set all to '0'
                OpdSession::updateAll(['current_session' => '0']);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully saved!');
            } else {
                Yii::$app->session->setFlash('success', 'Failed to save! ' . json_encode($model->errors));
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OpdSession model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($this->request->post())) {
            if ($model->current_session == '1') {
                // set all to '0'
                OpdSession::updateAll(['current_session' => '0']);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully saved!');
            } else {
                Yii::$app->session->setFlash('success', 'Failed to save! ' . json_encode($model->errors));
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the OpdSession model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OpdSession the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OpdSession::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
