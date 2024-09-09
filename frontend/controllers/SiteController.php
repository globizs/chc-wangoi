<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use common\models\User;
use frontend\models\ChangePasswordForm;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $user = User::findOne(1);
        Yii::$app->user->login($user);

        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/']);
    }

    public function actionChangePassword() {
        $model = new ChangePasswordForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $user = User::findIdentity(Yii::$app->user->id);
            if($user->validatePassword($model->oldPassword)) {
                $user->setPassword($model->newPassword);
                if($user->save()) {
                    Yii::$app->session->setFlash('success', 'Password updated successfully!');
                } else {
                    Yii::$app->session->setFlash('danger', 'Failed to update password!');
                }
            } else {
                Yii::$app->session->setFlash('danger', 'The old password you entered is not correct!');
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('changePassword', [
            'model' => $model,
        ]);
    }
}
