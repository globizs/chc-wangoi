<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\models\SignupForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use mdm\admin\models\Assignment;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'assign' => ['post'],
                    'revoke' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $users = User::find()->asArray()->select('id, username, status')->all();

        return $this->render('index', [
            'users' => $users
        ]);
    }

    public function actionCreate() {
        $model = new SignupForm();
        $model->scenario = 'create';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ActiveForm::validate($model);
        }

        if($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if(!($user_id = $model->signup())) {
                    
                    $transaction->rollback();
                    Yii::$app->session->setFlash('danger', 'Failed to add new user!');
                } else {
                    $auth = Yii::$app->authManager;
                    $role = $auth->getRole('admin');
                    $auth->assign($role, $user_id);

                    if($model->permissions) {
                        // Now assign user permissions
                        $assignModel = new Assignment($user_id);
                        $permissions_assigned = $assignModel->assign($model->permissions);
                    } else {
                        $permissions_assigned = true;
                    }

                    if($permissions_assigned) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'New user successfully added!');
                    } else {
                        $transaction->rollback();
                        Yii::$app->session->setFlash('danger', 'Failed to assign permissions!');
                    }
                }
            } catch(\Exception $e) {
                $transaction->rollback();
                Yii::$app->session->setFlash('danger', 'An exception has occurred!');
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        $permissions = [];

        $permissions_raw = array_filter(Yii::$app->authManager->getPermissions(), function($item) {
            $isPermission = 1;
            return $isPermission xor (strncmp($item->name, '/', 1) === 0 or strncmp($item->name, '@', 1) === 0);
        });
        foreach ($permissions_raw as $key => $p) {
            $permissions[$key] = $key;
        }
        // persmissions to be selected by default
        $model->permissions = [];

        return $this->renderAjax('_form', [
            'model' => $model,
            'permissions' => $permissions
        ]);
    }

    public function actionUpdate($id) {
        $model = new SignupForm();
        $model->scenario = 'update';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ActiveForm::validate($model);
        }

        $user = User::findOne($id);

        $role = Yii::$app->authManager->getRolesByUser($user->id);

        if($model->load(Yii::$app->request->post())) {
            if($model->reset_password && $model->new_password && strlen($model->new_password) >= 6) {
                $user->setPassword($model->new_password);
            }
            if($model->username != $user->username) {
                if(User::find()->where(['username' => $model->username])->andWhere(['!=', 'id', $id])->exists()) {
                    Yii::$app->session->setFlash('danger', 'Duplicate username already exists!');
                    return $this->redirect(Yii::$app->request->referrer);
                }
                $user->username = $model->username;
            }
            if($model->status == 10) {
                $user->status = 10;
            } else if($model->status == 9) {
                if($user->id == 1) {
                    Yii::$app->session->setFlash('warning', 'This account cannot be deactivated!');
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    $user->status = 9;
                }
            }

            if($user->save()) {
                Yii::$app->session->setFlash('success', 'User account successfully updated!');
            } else {
                Yii::$app->session->setFlash('danger', 'Failed to update user account');
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        $model->status = $user->status;
        $model->username = $user->username;
        $model->id = $user->id;

        return $this->renderAjax('_form_update', [
            'model' => $model,
            'id' => $id
        ]);
    }

    // copied from mdm soft
    public function actionPermission($id)
    {
        $model = $this->findUser($id);

        return $this->renderAjax('permission', [
            'model' => $model,
        ]);
    }

    // copied from mdm soft
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment($id);
        $success = $model->assign($items);
        Yii::$app->getResponse()->format = 'json';
        return array_merge($model->getItems(), ['success' => $success]);
    }

    // copied from mdm soft
    public function actionRevoke($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment($id);
        $success = $model->revoke($items);
        Yii::$app->getResponse()->format = 'json';
        return array_merge($model->getItems(), ['success' => $success]);
    }

    // copied from mdm soft
    protected function findUser($id)
    {
        if (($user = User::findIdentity($id)) !== null) {
            return new Assignment($id, $user);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
